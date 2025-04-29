@extends('layouts.app')

@section('content')
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:p-8">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
      <div>
        <h1 class="text-3xl font-bold text-gray-800 leading-tight">
          <a href="{{ url('book/' . $event->slug) }}{{ $event->pin_code ? '?code=' . $event->pin_code : '' }}"
            target="_blank" class="hover:text-blue-800">
            {{ $event->title }}
          </a>
        </h1>
      </div>

      <div class="flex gap-2">
        <a href="{{ route('events.edit', $event) }}"
          class="px-4 py-2 bg-yellow-400 text-yellow-900 rounded hover:bg-yellow-500 text-sm font-semibold transition">
          ✏️ Edit Event
        </a>
        <a href="{{ route('events.index') }}"
          class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 text-sm font-medium">
          ⬅️ Kembali
        </a>
      </div>
    </div>

    {{-- Event Description --}}
    <div class="bg-white p-6 rounded shadow mb-8">
      <div class="text-gray-700 text-base space-y-2">
        <p><strong>Deskripsi:</strong></p>
        <div>{!! autolink($event->description) !!}</div>
        <p><strong>Login Required:</strong> {{ $event->is_login_required ? 'Yes' : 'No' }}</p>
      </div>
    </div>

    {{-- WhatsApp Reminder Form --}}
    <div class="bg-white p-6 rounded shadow mb-8">
      <h3 class="text-xl font-semibold mb-4 text-blue-700">📲 Kirim WhatsApp Reminder ke Peserta</h3>

      <form action="{{ route('admin.events.sendWhatsappReminder', $event) }}" method="POST" class="space-y-4">
        @csrf

        <div>
          <label for="slot_id" class="block font-medium mb-1">Target Slot (Opsional)</label>
          <select name="slot_id" id="slot_id" class="w-full p-2 border rounded text-sm">
            <option value="">-- Semua Slot di Event Ini --</option>
            @foreach ($event->slots as $slot)
              <option value="{{ $slot->id }}">
                {{ \Carbon\Carbon::parse($slot->slot_time)->format('d M Y H:i') }}
              </option>
            @endforeach
          </select>
        </div>

        <div>
          <label for="message" class="block font-medium mb-1">Pesan WhatsApp</label>
          <textarea name="message" id="message" rows="4" required class="w-full p-3 border rounded text-sm"
            placeholder="Contoh: Halo {name}, ini pengingat jadwal kamu. Cek detailnya di sini: {link}">Halo {name}, ini pengingat jadwal kamu di Future Leaders ID. Cek detailnya di sini: {link}

Abaikan pesan ini jika sudah melakukan konfirmasi atau hadir.</textarea>
          <small class="text-gray-500">Gunakan <code>{name}</code> untuk nama peserta dan <code>{link}</code> untuk link
            appointment.</small>
        </div>

        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 font-medium transition">
          Kirim WhatsApp Reminder
        </button>
      </form>
    </div>

    {{-- Slot Table --}}
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-semibold text-gray-800">🗓 Slot Jadwal & Bookings</h2>
      <a href="{{ route('slots.create', ['event_id' => $event->id]) }}"
        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
        + Add More Slot
      </a>
    </div>

    @if ($slots->isEmpty())
      <p class="text-gray-500">Belum ada slot yang tersedia untuk event ini.</p>
    @else
      <div class="overflow-x-auto bg-white rounded shadow border">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-100 text-left text-gray-600">
            <tr>
              <th class="px-4 py-3">Slot Waktu</th>
              <th class="px-4 py-3">Kuota</th>
              <th class="px-4 py-3">Peserta Terdaftar</th>
              <th class="px-4 py-3">Detail Peserta</th>
              <th class="px-4 py-3">Aksi</th>
            </tr>
          </thead>
          <tbody class="text-gray-800">
            @foreach ($slots as $slot)
              <tr class="border-t">
                <td class="px-4 py-3">
                  {{ \Carbon\Carbon::parse($slot->slot_time)->format('l, d M Y H:i') }}
                </td>
                <td class="px-4 py-3">{{ $slot->quota }}</td>
                <td class="px-4 py-3">{{ $slot->appointments->count() }}</td>
                <td class="px-4 py-3">
                  @if ($slot->appointments->isEmpty())
                    <span class="text-gray-400">-</span>
                  @else
                    <ul class="list-disc pl-5 space-y-1">
                      @foreach ($slot->appointments as $app)
                        <li>{{ $app->name ?? 'Guest' }} ({{ blur_email($app->email) }})</li>
                      @endforeach
                    </ul>
                  @endif
                </td>
                <td class="px-4 py-3 whitespace-nowrap">
                  <div class="flex gap-2">
                    <a href="{{ route('slots.show', $slot) }}"
                      class="text-sm px-3 py-1 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Lihat</a>
                    <a href="{{ route('slots.edit', $slot) }}"
                      class="text-sm px-3 py-1 bg-yellow-300 text-yellow-800 rounded hover:bg-yellow-400">Edit</a>
                    <form action="{{ route('slots.destroy', $slot) }}" method="POST"
                      onsubmit="return confirm('Hapus slot ini?');">
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
      </div>

      <div class="mt-6">
        {{ $slots->withQueryString()->links() }}
      </div>
    @endif
  </div>
@endsection
