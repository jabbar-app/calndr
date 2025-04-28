@extends('layouts.app')

@section('content')
  <div class="max-w-7xl mx-auto py-10">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">Manage Events</h1>
      <a href="{{ route('events.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Create Event
      </a>
    </div>

    @if (session('success'))
      <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
      </div>
    @endif


    <form action="{{ route('events.index') }}" method="GET" class="mb-6">
      <input type="text" name="search" placeholder="Search events..." class="p-2 border rounded w-full md:w-1/3"
        value="{{ request('search') }}">
    </form>

    <div class="bg-white shadow rounded-lg overflow-hidden">

      <table class="min-w-full">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Login Required</th>
            <th class="px-6 py-3"></th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse ($events as $event)
            <tr>
              <td class="px-6 py-4">
                <a href="{{ url('book/' . $event->slug) }}{{ $event->pin_code ? '?code=' . $event->pin_code : '' }}"
                  target="_blank" class="text-blue-600 hover:underline font-semibold">
                  {{ $event->title }}
                </a>
              </td>
              <td class="px-6 py-4">
                @if ($event->is_login_required)
                  <span class="text-green-600">Yes</span>
                @else
                  <span class="text-gray-600">No</span>
                @endif
              </td>
              <td class="px-6 py-4 flex space-x-2">
                <a href="{{ route('events.edit', $event) }}" class="text-yellow-500 hover:underline">Edit</a>
                <form action="{{ route('events.destroy', $event) }}" method="POST"
                  onsubmit="return confirm('Are you sure?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:underline">Delete</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="3" class="px-6 py-4 text-center text-gray-500">No events found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>

      <div class="mt-6">
        {{ $events->links() }}
      </div>

    </div>
  </div>
@endsection
