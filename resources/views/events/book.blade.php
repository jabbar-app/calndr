@extends('layouts.page')

@section('content')
  <div class="min-h-screen flex items-center justify-center">
    <div class="text-center">
      <h1 class="text-4xl font-bold">{{ $event->title }}</h1>
      <p class="mt-4 text-gray-600 max-w-xl mx-auto">{{ $event->description }}</p>

      <div class="mt-8">
        <a href="{{ route('appointments.selectSlot', ['event' => $event->slug]) }}"
          class="px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700">
          Select Available Slot
        </a>
      </div>
    </div>
  </div>
@endsection
