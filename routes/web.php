<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NursesController;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\PasientsController;
use App\Http\Controllers\TreatmentsController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\AppointmentsTreatmentsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FinancialReportController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

// Route untuk halaman awal
// Route::get('/', function () {
//     return view('welcome');
// });

// Route dashboard dan profil, hanya bisa diakses jika sudah login

// Route untuk logout (gunakan metode POST)
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Route untuk halaman login (GET untuk form login dan POST untuk aksi login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

    // Route halaman register (jika diperlukan)
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
});

// Kelompok rute yang membutuhkan autentikasi
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    // Rute untuk doctors
    Route::resource('/doctors', DoctorsController::class);
    Route::resource('/patients', PasientsController::class);

    // Rute resource untuk nurses
    Route::resource('/nurses', NursesController::class);

    // Rute resource untuk appointments
    Route::resource('/appointments', AppointmentsController::class);

    // Rute resource untuk treatments
    Route::resource('treatments', TreatmentsController::class);

    // Rute resource untuk appointment_treatments
    Route::resource('appointment_treatments', AppointmentsTreatmentsController::class);

    // Rute tambahan untuk nurses
    Route::post('/nurses/store', [NursesController::class, 'store'])->name('nurses.store');

    // Rute tambahan untuk pasien
    Route::post('/patient/store', [PasientsController::class, 'store'])->name('patient.store');
    Route::put('/patients/{id}', [PasientsController::class, 'update'])->name('patients.update');
    Route::get('/nurses', [NursesController::class, 'index'])->name('nurses.index');

    // Rute tambahan untuk appointment_treatments
    Route::put('appointment_treatments/update/{id}/{createdAtDate}', [AppointmentsTreatmentsController::class, 'update'])->name('appointment_treatments.update');
    Route::get('appointment_treatments/edit/{id}/{createdAtDate}', [AppointmentsTreatmentsController::class, 'edit'])->name('appointment_treatments.edit');
    Route::delete('appointment_treatments/{id}/{createdAtDate}', [AppointmentsTreatmentsController::class, 'destroy'])->name('appointment_treatments.destroy');
    Route::get('appointment_treatments/{appointmentId}/{createdAtDate}', [AppointmentsTreatmentsController::class, 'show'])->name('appointment_treatments.show');

    // Rute untuk payments
    Route::resource('payments', PaymentsController::class);
    Route::get('appointment/{id}/total-cost', [PaymentsController::class, 'getTotalCost']);


    Route::get('/daily', [FinancialReportController::class, 'dailyReport'])->name('reports.daily');
    Route::get('/monthly', [FinancialReportController::class, 'monthlyReport'])->name('reports.monthly');

    Route::get('/daily/csv', [FinancialReportController::class, 'downloadCsv'])->name('reports.daily.csv');
    Route::get('/daily/pdf', [FinancialReportController::class, 'downloadPdf'])->name('reports.daily.pdf');

    // Route::get('//monthly', [ReportController::class, 'monthlyReport'])->name('reports.monthly');

    // Rute untuk unduhan CSV bulanan
    Route::get('//monthly/csv', [FinancialReportController::class, 'downloadMonthlyCsv'])->name('reports.monthly.csv');

    // Rute untuk unduhan PDF bulanan
    Route::get('//monthly/pdf', [FinancialReportController::class, 'downloadMonthlyPdf'])->name('reports.monthly.pdf');


    // user
    Route::resource('/users', UserController::class);
    // Route::put('users/{user}/status', [UserController::class, 'updateStatus'])->name('users.updateStatus');
    Route::put('users/{user}/status', [UserController::class, 'updateStatus'])->name('users.updateStatus');
});
