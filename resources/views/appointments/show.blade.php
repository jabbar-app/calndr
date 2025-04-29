@extends('layouts.app')

@section('content')
  <div class="max-w-2xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Appointment Details</h1>

    {{-- ✅ Alert Message --}}
    @if (session('success'))
      <div class="mb-4 p-4 bg-green-100 text-green-800 rounded border border-green-300">
        {{ session('success') }}
      </div>
    @elseif (session('info'))
      <div class="mb-4 p-4 bg-blue-100 text-blue-800 rounded border border-blue-300">
        {{ session('info') }}
      </div>
    @elseif ($errors->any())
      <div class="mb-4 p-4 bg-red-100 text-red-800 rounded border border-red-300">
        <ul class="list-disc pl-5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

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
