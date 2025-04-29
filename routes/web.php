<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\EventBookingController;
use App\Http\Controllers\Admin\SlotController as AdminSlotController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

// Public Home (atau redirect ke dashboard)
Route::get('/', [PageController::class, 'landing'])->name('pages.landing');
Route::get('/book/{slug}', [EventBookingController::class, 'show'])->name('events.book');
Route::post('/book/{slug}/verify', [EventBookingController::class, 'verify'])->name('events.book.verify');

// Public Appointments Flow
Route::get('/appointments/select-slot', [AppointmentController::class, 'selectSlot'])->name('appointments.selectSlot');
Route::post('/appointments/choose-slot', [AppointmentController::class, 'chooseSlot'])->name('appointments.chooseSlot');


// Authenticated User Profile
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/events/{event}/detail', [AdminDashboardController::class, 'detailEvent'])->name('events.detail');
    Route::post('/events/{event}/send-wa', [AdminDashboardController::class, 'sendWhatsappReminder'])->name('admin.events.sendWhatsappReminder');
    Route::resource('events', AdminEventController::class);
    Route::resource('slots', AdminSlotController::class);
    Route::resource('users', AdminUserController::class)->only(['index', 'edit', 'update']);
});

Route::resource('appointments', AppointmentController::class)->except(['index']);

require __DIR__ . '/auth.php';
