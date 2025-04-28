@extends('layouts.app')

@section('content')
  <div class="max-w-7xl mx-auto py-10">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Manage Slots</h1>
      <a href="{{ route('slots.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Create
        Slot</a>
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
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slot Time</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quota</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            <th class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach ($slots as $slot)
            <tr>
              <td class="px-6 py-4">{{ \Carbon\Carbon::parse($slot->slot_time)->format('l, d M Y H:i') }}</td>
              <td class="px-6 py-4">{{ $slot->quota }}</td>
              <td class="px-6 py-4">
                @if ($slot->quota > 0)
                  <span class="text-green-600">Available</span>
                @else
                  <span class="text-red-600">Full</span>
                @endif
              </td>
              <td class="px-6 py-4 flex space-x-2">
                <a href="{{ route('slots.edit', $slot) }}" class="text-yellow-500 hover:underline">Edit</a>
                <form action="{{ route('slots.destroy', $slot) }}" method="POST"
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
