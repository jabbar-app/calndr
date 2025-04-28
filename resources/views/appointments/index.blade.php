@extends('layouts.app')

@section('content')
  <div class="max-w-7xl mx-auto py-10">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Appointments</h1>
      <a href="{{ route('appointments.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Create Appointment
      </a>
    </div>

    @if (session('success'))
      <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
      </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
      <table class="min-w-full">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Time</th>
            <th class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach ($appointments as $appointment)
            <tr>
              <td class="px-6 py-4">{{ $appointment->name }}</td>
              <td class="px-6 py-4">{{ $appointment->phone }}</td>
              <td class="px-6 py-4">{{ $appointment->email }}</td>
              <td class="px-6 py-4">{{ $appointment->date_time }}</td>
              <td class="px-6 py-4 flex space-x-2">
                <a href="{{ route('appointments.show', $appointment) }}" class="text-blue-600 hover:underline">View</a>
                <a href="{{ route('appointments.edit', $appointment) }}" class="text-yellow-500 hover:underline">Edit</a>
                <form action="{{ route('appointments.destroy', $appointment) }}" method="POST"
                  onsubmit="return confirm('Are you sure?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:underline">Delete</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
