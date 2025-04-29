@extends('layouts.page')

@section('content')
  <div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-12">
    <div class="max-w-lg w-full bg-white rounded-2xl shadow-xl p-8 md:p-10 transition-all animate-fade-in">
      <div class="text-left">
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-4 break-words">
          {{ $event->title }}
        </h1>

        <div class="text-gray-700 leading-relaxed text-base md:text-lg break-words">
          {!! autolink($event->description) !!}
        </div>

        <div class="mt-8">
          <a href="{{ route('appointments.selectSlot', ['event' => $event->slug]) }}"
            class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-lg font-medium rounded-lg shadow transition duration-300">
            📅 Pilih Jadwal
          </a>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('styles')
  <style>
    @keyframes fade-in {
      0% {
        opacity: 0;
        transform: translateY(10px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fade-in {
      animation: fade-in 0.6s ease-out both;
    }

    /* Tambahan agar link panjang tetap wrap dan tidak keluar card */
    a {
      word-break: break-word;
    }
  </style>
@endpush
