<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slot;
use App\Models\Event;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function index()
    {
        $slots = Slot::with('event')->latest()->get();
        return view('admin.slots.index', compact('slots'));
    }

    public function create()
    {
        $events = Event::all();
        return view('admin.slots.create', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'slot_time' => 'required|date',
            'quota' => 'required|integer|min:1',
        ]);

        Slot::create($validated);

        return redirect()->route('slots.index')->with('success', 'Slot created successfully.');
    }

    public function edit(Slot $slot)
    {
        $events = Event::all();
        return view('admin.slots.edit', compact('slot', 'events'));
    }

    public function update(Request $request, Slot $slot)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'slot_time' => 'required|date',
            'quota' => 'required|integer|min:1',
        ]);

        $slot->update($validated);

        return redirect()->route('slots.index')->with('success', 'Slot updated successfully.');
    }

    public function destroy(Slot $slot)
    {
        $slot->delete();

        return redirect()->route('slots.index')->with('success', 'Slot deleted successfully.');
    }
}
