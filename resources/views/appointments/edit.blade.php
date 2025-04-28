@extends('layouts.app')

@section('content')
  <div class="max-w-2xl mx-auto py-10">
    <h1 class="text-2xl font-bold mb-6">Edit Appointment</h1>

    <form action="{{ route('appointments.update', $appointment) }}" method="POST" class="space-y-6">
      @csrf
      @method('PUT')

      <div>
        <label class="block text-gray-700">Name</label>
        <input type="text" name="name" class="w-full mt-1 p-2 border rounded"
          value="{{ old('name', $appointment->name) }}">
      </div>

      <div>
        <label class="block text-gray-700">Phone</label>
        <input type="text" name="phone" class="w-full mt-1 p-2 border rounded"
          value="{{ old('phone', $appointment->phone) }}">
      </div>

      <div>
        <label class="block text-gray-700">Email</label>
        <input type="email" name="email" class="w-full mt-1 p-2 border rounded"
          value="{{ old('email', $appointment->email) }}">
      </div>

      <div>
        <label class="block text-gray-700">Date & Time</label>
        <input type="datetime-local" name="date_time" class="w-full mt-1 p-2 border rounded"
          value="{{ old('date_time', \Carbon\Carbon::parse($appointment->date_time)->format('Y-m-d\TH:i')) }}">
      </div>

      <div class="flex justify-end">
        <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Update</button>
      </div>
    </form>
  </div>
@endsection
