@extends('layouts.app')

@section('content')
  <div class="max-w-2xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Edit Event</h1>

    <form action="{{ route('events.update', $event) }}" method="POST" class="space-y-6">
      @csrf
      @method('PUT')

      <div>
        <label class="block text-gray-700">Title</label>
        <input type="text" name="title" value="{{ old('title', $event->title) }}" class="w-full mt-1 p-2 border rounded"
          required>
      </div>

      <div>
        <label class="block text-gray-700">Description</label>
        <textarea name="description" class="w-full mt-1 p-2 border rounded" rows="4">{{ old('description', $event->description) }}</textarea>
      </div>

      <div>
        <label class="flex items-center space-x-2">
          <input type="checkbox" name="is_login_required" value="1" {{ $event->is_login_required ? 'checked' : '' }}>
          <span class="text-gray-700">Require Login to Book Slot</span>
        </label>
      </div>

      <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
          Update
        </button>
      </div>
    </form>
  </div>
@endsection
