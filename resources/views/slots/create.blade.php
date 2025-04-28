@extends('layouts.app')

@section('content')
  <div class="max-w-2xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Create Slot</h1>

    <form action="{{ route('slots.store') }}" method="POST" class="space-y-6">
      @csrf

      <div>
        <label class="block text-gray-700">Slot Time</label>
        <input type="datetime-local" name="slot_time" class="w-full mt-1 p-2 border rounded" value="{{ old('slot_time') }}"
          required>
      </div>

      <div>
        <label class="block text-gray-700">Quota</label>
        <input type="number" name="quota" min="1" class="w-full mt-1 p-2 border rounded"
          value="{{ old('quota', 1) }}" required>
      </div>

      <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
      </div>
    </form>
  </div>
@endsection
