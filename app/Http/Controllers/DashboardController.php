<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $appointments = Appointment::where('email', Auth::user()->email)
            ->orderBy('date_time', 'desc')
            ->get();

        return view('dashboard', compact('appointments'));
    }
}
