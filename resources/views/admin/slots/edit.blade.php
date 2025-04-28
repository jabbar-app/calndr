@extends('layouts.app')

@section('content')
  <div class="max-w-2xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Edit Slot</h1>

    <form action="{{ route('slots.update', $slot) }}" method="POST" class="space-y-6">
      @csrf
      @method('PUT')

      <div>
        <label class="block text-gray-700">Event</label>
        <select name="event_id" class="w-full mt-1 p-2 border rounded" required>
          @foreach ($events as $event)
            <option value="{{ $event->id }}" {{ $event->id == $slot->event_id ? 'selected' : '' }}>
              {{ $event->title }}
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-gray-700">Slot Time</label>
        <input type="datetime-local" name="slot_time" class="w-full mt-1 p-2 border rounded"
          value="{{ old('slot_time', \Carbon\Carbon::parse($slot->slot_time)->format('Y-m-d\TH:i')) }}" required>
      </div>

      <div>
        <label class="block text-gray-700">Quota</label>
        <input type="number" name="quota" class="w-full mt-1 p-2 border rounded" value="{{ $slot->quota }}"
          min="1" required>
      </div>

      <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
          Update
        </button>
      </div>
    </form>
  </div>
@endsection
