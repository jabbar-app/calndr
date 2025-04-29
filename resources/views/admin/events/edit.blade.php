@extends('layouts.app')

@section('content')
  <div class="max-w-2xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Edit Event</h1>

    <form id="edit-event-form" action="{{ route('events.update', $event) }}" method="POST" class="space-y-6">
      @method('PUT')
      @include('admin.events._form', ['event' => $event])
    </form>
  </div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('edit-event-form');
      const submitButton = document.getElementById('submit-button');

      form.addEventListener('submit', function() {
        submitButton.disabled = true;
        submitButton.innerText = 'Updating...';
        submitButton.classList.add('opacity-50', 'cursor-not-allowed');
      });
    });
  </script>
@endpush
