<?php

use App\Http\Controllers\About;
use App\Http\Controllers\Contact;
use App\Http\Controllers\Home;
use App\Http\Controllers\News;
use App\Http\Controllers\Room;
// use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
// Route::get('/register', [RegisteredUserController::class, 'store'])
//     ->middleware('guest')
//     ->name('register');
Route::get('register', [RegisteredUserController::class, 'create'])->middleware('guest')->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
    Route::get('/dashboard', function () {
    return view('dashboard'); // yahan dashboard.blade.php file ho
})->middleware(['auth'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard/rooms', [Room::class, 'dashboardIndex'])->name('dashboard.rooms.index');
    Route::get('/dashboard/rooms/datatable', [Room::class, 'datatable'])->name('dashboard.rooms.datatable');
});
// Route::get('/', function () {
//     return view('Home');
// });
// frontend
Route::get('/', [Home::class ,'index']);
Route::get('/room', [Room::class ,'index']);
Route::get('/about', [About::class ,'index']);
Route::get('/news', [News::class ,'index']);
Route::get('/contact', [Contact::class ,'index']);
