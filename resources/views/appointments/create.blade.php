@extends('layouts.app')

@section('content')
  <div class="max-w-2xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Create Appointment</h1>

    @if ($errors->any())
      <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        {{ $errors->first() }}
      </div>
    @endif

    <form id="create-appointment-form" action="{{ route('appointments.store') }}" method="POST" class="space-y-6">
      @csrf

      <!-- Name -->
      <div>
        <label class="block text-gray-700 font-semibold">Name</label>
        <input type="text" name="name" required class="w-full mt-1 p-3 border rounded"
          value="{{ old('name', auth()->check() ? auth()->user()->name : '') }}">
      </div>

      <!-- Phone -->
      <div>
        <label class="block text-gray-700 font-semibold">Phone Number (must start with 628)</label>
        <input type="text" id="phone" name="phone" required pattern="628[0-9]{8,13}"
          title="Phone number must start with 628 and contain 11-15 digits" class="w-full mt-1 p-3 border rounded"
          value="{{ old('phone', auth()->check() ? auth()->user()->phone : '') }}">
      </div>

      <!-- Email -->
      <div>
        <label class="block text-gray-700 font-semibold">Email</label>
        <input type="email" name="email" required class="w-full mt-1 p-3 border rounded"
          value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}">
      </div>

      <!-- Date & Time -->
      <div>
        <label class="block text-gray-700 font-semibold">Date & Time</label>
        <input type="datetime-local" name="date_time" readonly required class="w-full mt-1 p-3 border rounded bg-gray-100"
          value="{{ old('date_time', session('selected_slot_time') ? \Carbon\Carbon::parse(session('selected_slot_time'))->format('Y-m-d\TH:i') : '') }}">
      </div>

      <div class="flex justify-end pt-6">
        <button type="submit" id="submit-button"
          class="px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold">
          Save Appointment
        </button>
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const phoneInput = document.getElementById('phone');

      phoneInput.addEventListener('input', function() {
        if (this.value.startsWith('0')) {
          this.value = this.value.replace(/^0/, '62');
        }
      });
    });
  </script>
@endpush
