<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slot;
use App\Models\User;
use App\Models\Event;
use App\Models\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $usersByMonth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $appointmentsByMonth = Appointment::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $recentAppointments = Appointment::latest()->take(5)->get();

        $topEvents = Event::withCount('slots')
            ->orderByDesc('slots_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'eventsCount' => Event::count(),
            'slotsCount' => Slot::count(),
            'appointmentsCount' => Appointment::count(),
            'usersCount' => User::count(),
            'adminsCount' => User::where('role', 'admin')->count(),
            'regularUsersCount' => User::where('role', 'user')->count(),
            'usersByMonth' => $usersByMonth,
            'appointmentsByMonth' => $appointmentsByMonth,
            'recentAppointments' => $recentAppointments,
            'topEvents' => $topEvents,
        ]);
    }

    public function detailEvent(Event $event)
    {
        $slots = $event->slots()->with('appointments')->orderBy('slot_time')->paginate(5);
        return view('admin.events.detail', compact('event', 'slots'));
    }

    public function sendWhatsappReminder(Request $request, Event $event)
    {
        $request->validate([
            'slot_id' => 'nullable|exists:slots,id',
            'message' => 'required|string|min:5',
        ]);

        $appointments = Appointment::where('event_id', $event->id)
            ->when($request->filled('slot_id'), function ($query) use ($request) {
                $query->where('slot_id', $request->slot_id);
            })
            ->whereNotNull('phone')
            ->with('slot')
            ->get();

        $token = env('WHATSAPP_TOKEN');
        $sent = 0;

        foreach ($appointments as $appointment) {
            $message = str_replace(
                ['{name}', '{link}'],
                [$appointment->name ?? 'Peserta', route('appointments.show', $appointment)],
                $request->message
            );

            try {
                Http::withHeaders([
                    'Authorization' => $token,
                ])->post('https://api.fonnte.com/send', [
                    'target' => $appointment->phone,
                    'message' => $message,
                    'delay' => '1-3',
                    'countryCode' => '62',
                ]);
                $sent++;
            } catch (\Exception $e) {
                Log::error("Gagal kirim WhatsApp ke {$appointment->phone}: " . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', "WhatsApp berhasil dikirim ke {$sent} peserta.");
    }
}
