@extends('layouts.app')

@section('content')
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:p-8">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Detail Slot</h1>
      <a href="{{ route('slots.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
        ⬅️ Kembali
      </a>
    </div>

    <div class="bg-white p-6 rounded shadow mb-8">
      <h2 class="text-lg font-semibold text-gray-700 mb-2">Slot Info</h2>
      <p><strong>Event:</strong> {{ $slot->event->title }}</p>
      <p><strong>Slot Time:</strong> {{ \Carbon\Carbon::parse($slot->slot_time)->format('l, d M Y H:i') }}</p>
      <p><strong>Quota:</strong> {{ $slot->quota }}</p>
    </div>

    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-lg font-semibold text-gray-700 mb-4">Peserta Terdaftar</h2>

      @if ($slot->appointments->isEmpty())
        <p class="text-gray-500">Belum ada peserta yang terdaftar.</p>
      @else
        <table class="min-w-full text-sm border">
          <thead class="bg-gray-100 text-left">
            <tr>
              <th class="px-4 py-2">Nama</th>
              <th class="px-4 py-2">Email</th>
              <th class="px-4 py-2">Phone</th>
              <th class="px-4 py-2">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($slot->appointments as $app)
              <tr class="border-t">
                <td class="px-4 py-2">{{ $app->name ?? 'Guest' }}</td>
                <td class="px-4 py-2">{{ blur_email($app->email) }}</td>
                <td class="px-4 py-2">{{ blur_phone($app->phone) }}</td>
                <td class="px-4 py-2">
                  <div class="flex gap-2">
                    <a href="{{ route('appointments.show', $app) }}"
                      class="text-sm px-3 py-1 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Lihat</a>
                    <a href="{{ route('appointments.edit', $app) }}"
                      class="text-sm px-3 py-1 bg-yellow-300 text-yellow-800 rounded hover:bg-yellow-400">Edit</a>
                    <form action="{{ route('appointments.destroy', $app) }}" method="POST"
                      onsubmit="return confirm('Hapus peserta ini?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                        class="text-sm px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Hapus</button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
@endsection
