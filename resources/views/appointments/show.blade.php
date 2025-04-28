@extends('layouts.app')

@section('content')
  <div class="max-w-2xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Appointment Details</h1>

    <div class="bg-white shadow rounded p-6 space-y-4">
      <div>
        <strong>Name:</strong> {{ $appointment->name }}
      </div>
      <div>
        <strong>Phone:</strong> {{ $appointment->phone }}
      </div>
      <div>
        <strong>Email:</strong> {{ $appointment->email }}
      </div>
      <div>
        <strong>Date & Time:</strong> {{ \Carbon\Carbon::parse($appointment->date_time)->format('l, d M Y H:i') }}
      </div>

      <div class="mt-6 flex justify-between">
        @php
          $event = \App\Models\Event::find(session('selected_event_id'));
          $start = \Carbon\Carbon::parse($appointment->date_time)->format('Ymd\THis\Z');
          $end = \Carbon\Carbon::parse($appointment->date_time)->addMinutes(30)->format('Ymd\THis\Z');
          $googleCalendarUrl =
              'https://calendar.google.com/calendar/render?action=TEMPLATE' .
              '&text=' .
              urlencode($event->title ?? 'Appointment') .
              '&dates=' .
              $start .
              '/' .
              $end .
              '&details=' .
              urlencode(
                  ($event->description ?? '') . "\nPhone: " . $appointment->phone . "\nEmail: " . $appointment->email,
              ) .
              '&sf=true&output=xml';
        @endphp

        <a href="{{ $googleCalendarUrl }}" target="_blank"
          class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
          Add to Google Calendar
        </a>

        <a href="{{ route('pages.landing') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
          Back
        </a>
      </div>
    </div>
  </div>
@endsection
