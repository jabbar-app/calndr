@extends('layouts.app')

@section('content')
  <div class="max-w-2xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Create Event</h1>

    <form action="{{ route('events.store') }}" method="POST" class="space-y-6">
      @csrf

      <div>
        <label class="block text-gray-700 font-semibold">Title</label>
        <input type="text" name="title" class="w-full mt-1 p-3 border rounded" required>
      </div>

      <div>
        <label class="block text-gray-700 font-semibold">Description</label>
        <textarea name="description" class="w-full mt-1 p-3 border rounded" rows="4"></textarea>
      </div>

      <div>
        <label class="block text-gray-700 font-semibold">PIN Code (Optional)</label>
        <input type="text" name="pin_code" class="w-full mt-1 p-3 border rounded" maxlength="10"
          placeholder="Enter PIN if you want to protect event">
        <small class="text-gray-500">Leave empty if you want this event public without PIN.</small>
      </div>

      <div class="flex items-center space-x-2">
        <input type="checkbox" name="is_login_required" value="1" id="is_login_required">
        <label for="is_login_required" class="text-gray-700 font-semibold">
          Require Login to Book Slot
        </label>
      </div>

      <div class="flex justify-end pt-6">
        <button id="submit-button" type="submit"
          class="px-6 py-3 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700">
          Save Event
        </button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('create-event-form');
      const submitButton = document.getElementById('submit-button');

      form.addEventListener('submit', function() {
        submitButton.disabled = true;
        submitButton.innerText = 'Saving...';
        submitButton.classList.add('opacity-50', 'cursor-not-allowed');
      });
    });
  </script>
@endpush
