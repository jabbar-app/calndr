<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventBookingController extends Controller
{
    public function show($slug, Request $request)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        if ($event->pin_code && $request->input('code') !== $event->pin_code) {
            return view('events.enter-pin', compact('event'));
        }

        return view('events.book', compact('event'));
    }

    public function verify(Request $request, $slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        $request->validate([
            'pin_code' => 'required|string',
        ]);

        if ($request->input('pin_code') !== $event->pin_code) {
            return back()->withErrors(['pin_code' => 'Invalid PIN code.']);
        }

        return redirect()->route('events.book', ['slug' => $slug, 'code' => $event->pin_code]);
    }
}
