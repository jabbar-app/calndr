@extends('layouts.page')

@section('content')
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow w-full max-w-md">
      <h1 class="text-2xl font-bold mb-6 text-center">Enter PIN to Access Event</h1>

      @if ($errors->any())
        <div class="mb-4 text-red-600">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('events.book.verify', $event->slug) }}">
        @csrf
        <input type="text" name="pin_code" placeholder="Enter PIN Code" class="w-full p-3 border rounded mb-4" required>

        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded hover:bg-blue-700">
          Submit
        </button>
      </form>
    </div>
  </div>
@endsection
