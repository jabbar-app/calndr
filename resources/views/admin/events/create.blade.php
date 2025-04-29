@extends('layouts.app')

@section('content')
  <div class="max-w-2xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-6">Create Event</h1>

    <form id="create-event-form" action="{{ route('events.store') }}" method="POST" class="space-y-6">
      @include('events._form')
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
