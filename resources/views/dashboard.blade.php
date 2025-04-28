@extends('layouts.app')

@section('content')
  <div class="max-w-7xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-8">Welcome, {{ Auth::user()->name }}!</h1>

    @if (session('success'))
      <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
      </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class="p-6">
        <h3 class="text-lg font-semibold mb-4">Your Appointments</h3>

        @isset($appointments)
          @if ($appointments->count())
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Event Title
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Date & Time
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  @foreach ($appointments as $appointment)
                    <tr>
                      <td class="px-6 py-4 whitespace-nowrap">
                        {{ $appointment->event->title ?? '-' }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($appointment->date_time)->format('d M Y H:i') }}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="text-gray-600">
              You have no appointments yet.
            </div>
          @endif
        @else
          <div class="text-gray-600">
            (No appointments data received)
          </div>
        @endisset

      </div>
    </div>
  </div>
@endsection
