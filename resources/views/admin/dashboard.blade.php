@extends('layouts.app')

@section('content')
  <div class="max-w-7xl mx-auto py-10">
    <h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>

    @if (session('success'))
      <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
      </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
      <div class="bg-white shadow rounded p-6">
        <h2 class="text-xl font-bold mb-2">Events</h2>
        <p class="text-3xl">{{ $eventsCount }}</p>
        <a href="{{ route('events.create') }}"
          class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
          Create Event
        </a>
      </div>

      <div class="bg-white shadow rounded p-6">
        <h2 class="text-xl font-bold mb-2">Slots</h2>
        <p class="text-3xl">{{ $slotsCount }}</p>
        <a href="{{ route('slots.create') }}"
          class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
          Create Slot
        </a>
      </div>

      <div class="bg-white shadow rounded p-6">
        <h2 class="text-xl font-bold mb-2">Appointments</h2>
        <p class="text-3xl">{{ $appointmentsCount }}</p>
        <a href="{{ route('appointments.index') }}"
          class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
          View Appointments
        </a>
      </div>

      <div class="bg-white shadow rounded p-6">
        <h2 class="text-xl font-bold mb-2">Total Users</h2>
        <p class="text-3xl">{{ $usersCount }}</p>
        <a href="{{ route('users.index') }}"
          class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
          Manage Users
        </a>
      </div>

      <div class="bg-white shadow rounded p-6">
        <h2 class="text-xl font-bold mb-2">Admins</h2>
        <p class="text-3xl">{{ $adminsCount }}</p>
      </div>

      <div class="bg-white shadow rounded p-6">
        <h2 class="text-xl font-bold mb-2">Regular Users</h2>
        <p class="text-3xl">{{ $regularUsersCount }}</p>
      </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-10">
      <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">User Growth</h2>
        <canvas id="userChart"></canvas>
      </div>

      <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Appointments Growth</h2>
        <canvas id="appointmentChart"></canvas>
      </div>
    </div>

    <script>
      const usersByMonth = @json($usersByMonth);
      const appointmentsByMonth = @json($appointmentsByMonth);

      const months = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
      ];

      const userData = months.map((_, index) => usersByMonth[index + 1] ?? 0);
      const appointmentData = months.map((_, index) => appointmentsByMonth[index + 1] ?? 0);

      const ctxUser = document.getElementById('userChart').getContext('2d');
      new Chart(ctxUser, {
        type: 'line',
        data: {
          labels: months,
          datasets: [{
            label: 'Users',
            data: userData,
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            fill: true,
            tension: 0.4,
          }]
        }
      });

      const ctxAppointment = document.getElementById('appointmentChart').getContext('2d');
      new Chart(ctxAppointment, {
        type: 'line',
        data: {
          labels: months,
          datasets: [{
            label: 'Appointments',
            data: appointmentData,
            borderColor: 'rgb(16, 185, 129)',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            fill: true,
            tension: 0.4,
          }]
        }
      });
    </script>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-10">
      <!-- Recent Appointments -->
      <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Recent Appointments</h2>
        <ul class="divide-y divide-gray-200">
          @forelse ($recentAppointments as $appointment)
            <li class="py-4 flex flex-col">
              <span class="font-medium">{{ $appointment->name ?? 'Guest' }}</span>
              <span class="text-gray-600 text-sm">
                {{ \Carbon\Carbon::parse($appointment->date_time)->format('l, d M Y H:i') }}
              </span>
            </li>
          @empty
            <li class="py-4 text-gray-500">No recent appointments.</li>
          @endforelse
        </ul>
      </div>

      <!-- Top 5 Events -->
      <div class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">Top 5 Events</h2>
        <ul class="divide-y divide-gray-200">
          @forelse ($topEvents as $event)
            <li class="py-4 flex justify-between items-center">
              <span>{{ $event->title }}</span>
              <span class="text-gray-500 text-sm">{{ $event->slots_count }} Slots</span>
            </li>
          @empty
            <li class="py-4 text-gray-500">No events found.</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>
@endsection
