<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Slot;
use App\Models\Appointment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $usersByMonth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $appointmentsByMonth = Appointment::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $recentAppointments = Appointment::latest()->take(5)->get();

        $topEvents = Event::withCount('slots')
            ->orderByDesc('slots_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'eventsCount' => Event::count(),
            'slotsCount' => Slot::count(),
            'appointmentsCount' => Appointment::count(),
            'usersCount' => User::count(),
            'adminsCount' => User::where('role', 'admin')->count(),
            'regularUsersCount' => User::where('role', 'user')->count(),
            'usersByMonth' => $usersByMonth,
            'appointmentsByMonth' => $appointmentsByMonth,
            'recentAppointments' => $recentAppointments,
            'topEvents' => $topEvents,
        ]);
    }
}
