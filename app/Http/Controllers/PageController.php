<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function landing()
    {
        return view('pages.landing', [
            'appointmentCount' => Appointment::count(),
            'userCount' => User::count(),
            'teamCount' => 14,
        ]);
    }
}
