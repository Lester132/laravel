<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Http\Controllers\Auth\EmailVerificationController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\PreventAdminMiddleware;

// Public Routes (Accessible to all users without login, except admins)
Route::get('/', [HomeController::class, 'homepage'])->name('home')->middleware(PreventAdminMiddleware::class);
Route::get('/home', [HomeController::class, 'homepage'])->name('home')->middleware(['verified', PreventAdminMiddleware::class]);
Route::get('/about', [HomeController::class, 'aboutpage'])->name('about')->middleware(PreventAdminMiddleware::class);
Route::get('/services', [HomeController::class, 'servicespage'])->name('services')->middleware(PreventAdminMiddleware::class);
Route::get('/contact', [HomeController::class, 'contactpage'])->name('contact')->middleware(PreventAdminMiddleware::class);

// Admin Routes (Only Admin Users)
Route::middleware(['auth', 'verified', AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/pending', [HomeController::class, 'pendingpage'])->name('pending');
    Route::get('/completed', [HomeController::class, 'completedAppointments'])->name('completed');
    Route::get('/expired', [HomeController::class, 'expiredAppointments'])->name('expired');

    // Route for completed appointments page
    Route::get('/appointments/completed', [AppointmentController::class, 'indexCompleted'])->name('appointments.completed');
});

// Regular user routes that require authentication and email verification
Route::middleware(['auth', 'verified', PreventAdminMiddleware::class])->group(function () {
    Route::get('/home', [HomeController::class, 'homepage'])->name('home');
});

// Email Verification Routes
Route::get('/email/verify', [EmailVerificationController::class, 'show'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');

// Resend email verification route
Route::post('/email/resend', function () {
    if (Auth::check()) {
        return back()->with('message', 'Verification email sent!');
    }
    return redirect()->route('login')->with('error', 'You must be logged in to resend the verification email.');
})->name('verification.resend');

// Authenticated and Protected Routes (for Regular Users)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
});

// Appointment management routes for admin
Route::middleware(['auth', 'verified', AdminMiddleware::class])->group(function () {
    // Routes for viewing appointments by status
    Route::get('/appointments/pending', [AppointmentController::class, 'indexPending'])->name('appointments.pending');
    Route::get('/appointments/completed', [AppointmentController::class, 'indexCompleted'])->name('appointments.completed');
    Route::get('/appointments/canceled', [AppointmentController::class, 'indexCanceled'])->name('appointments.canceled');
    Route::get('/appointments/expired', [HomeController::class, 'expiredAppointments'])->name('appointments.expired');
    
    // Routes for completing and canceling appointments
    Route::post('/appointments/{id}/complete', [AppointmentController::class, 'complete'])->name('appointments.complete');
    Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
});

// If the user is not authenticated, route them to the login page
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Test email route for sending a test email
Route::get('/send-test-mail', function () {
    Mail::to('test@example.com')->send(new TestMail());
    return 'Test email sent!';
});
