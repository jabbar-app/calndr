<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\User;
use App\Models\Event;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::orderBy('date_time', 'desc')->get();
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        if (!session('selected_slot_time')) {
            return redirect()->route('appointments.selectSlot')->with('error', 'Please select a slot first.');
        }

        $selectedSlotTime = session('selected_slot_time');

        $user = User::find(Auth::id());

        if (!$user) {
            // Kalau user belum login, tetap lanjut isi form manual
            return view('appointments.create');
        }

        $existingAppointment = Appointment::where('email', $user->email)
            ->where('phone', $user->phone)
            ->where('date_time', $selectedSlotTime)
            ->first();

        if ($existingAppointment) {
            return redirect()->route('appointments.show', $existingAppointment)
                ->with('info', 'You have already booked this slot.');
        }

        return view('appointments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'date_time' => 'required|date',
        ]);

        $slot = Slot::where('slot_time', $validated['date_time'])
            ->where('quota', '>', 0)
            ->first();

        if (!$slot) {
            return redirect()->route('appointments.selectSlot')->withErrors(['date_time' => 'Selected slot is no longer available.']);
        }

        // $duplicate = Appointment::where('phone', $validated['phone'])
        //     ->where('email', $validated['email'])
        //     ->where('slot_id', $slot->id)
        //     ->first();

        // if ($duplicate) {
        //     return redirect()->route('appointments.show', $duplicate)->with('info', 'You have already booked this slot.');
        // }

        $appointment = Appointment::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'date_time' => $validated['date_time'],
            'slot_id' => $slot->id,
            'event_id' => $slot->event_id,
        ]);

        $slot->decrement('quota');
        session()->forget('selected_slot_time');

        // ✅ Kirim Booking Link ke Aplikasi B
        $event = $slot->event;
        $confirmationLink = route('appointments.show', $appointment);

        if ($event && $event->url) {
            try {
                Http::post($event->url, [
                    'phone' => $appointment->phone,
                    'link' => $confirmationLink,
                ]);
            } catch (\Exception $e) {
                Log::error('Gagal kirim link konfirmasi ke Aplikasi B: ' . $e->getMessage());
            }
        }

        return redirect()->route('appointments.show', $appointment)->with('success', 'Appointment created successfully.');
    }

    public function show(Appointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        return view('appointments.edit', compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'date_time' => 'required|date',
        ]);

        $slot = Slot::where('slot_time', $validated['date_time'])
            ->first();

        if (!$slot) {
            return back()->withErrors(['date_time' => 'The selected time slot is invalid.']);
        }

        $appointment->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'date_time' => $validated['date_time'],
            'slot_id' => $slot->id,
            'event_id' => $slot->event_id,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
    }

    public function selectSlot(Request $request)
    {
        $eventSlug = $request->query('event');

        if ($eventSlug) {
            $event = Event::where('slug', $eventSlug)->firstOrFail();

            // Cek apakah event ini mengharuskan login
            if ($event->is_login_required && !Auth::check()) {
                // Simpan dulu URL tujuan setelah login
                session(['url.intended' => route('appointments.selectSlot', ['event' => $eventSlug])]);
                return redirect()->route('login')->with('message', 'Please login to access this event.');
            }

            $slots = $event->slots()->where('slot_time', '>=', now())->orderBy('slot_time')->get();
        } else {
            $slots = Slot::where('slot_time', '>=', now())->orderBy('slot_time')->get();
        }

        return view('appointments.select-slot', compact('slots'));
    }



    public function chooseSlot(Request $request)
    {
        $request->validate([
            'slot_time' => 'required|date',
        ]);

        $slot = Slot::where('slot_time', $request->slot_time)
            ->where('quota', '>', 0)
            ->first();

        if (!$slot) {
            return redirect()->back()->withErrors(['slot_time' => 'Selected slot is no longer available.']);
        }

        $event = $slot->event;

        session([
            'selected_slot_time' => $slot->slot_time,
            'selected_event_id' => $event->id,
        ]);

        if ($event->is_login_required && !Auth::check()) {
            return redirect()->route('login');
        }

        return redirect()->route('appointments.create');
    }
}
