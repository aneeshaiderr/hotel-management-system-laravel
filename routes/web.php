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
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;

use Illuminate\Support\Facades\Auth;
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
        $current_uri = request()->segment(1) ?: 'dashboard';
        return view('dashboard', compact('current_uri'));
    })->middleware(['auth'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Users CRUD
    Route::get('/user', [UserController::class, 'index'])->name('dashboard.user');
    Route::get('/user/datatable', [UserController::class, 'datatable'])->name('dashboard.user.datatable');
    Route::get('/user/create', [UserController::class, 'create'])->name('dashboard.user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('dashboard.user.store');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('dashboard.user.edit');
    Route::post('/user/update', [UserController::class, 'update'])->name('dashboard.user.update');
    Route::post('/user/delete', [UserController::class, 'delete'])->name('dashboard.user.delete');

    // Rooms CRUD
    Route::get('/rooms', [Room::class, 'dashboardIndex'])->name('dashboard.rooms');
    Route::get('/rooms/datatable', [Room::class, 'datatable'])->name('dashboard.rooms.datatable');
    Route::get('/room/create', [Room::class, 'create'])->name('dashboard.room.create');
    Route::post('/room/store', [Room::class, 'store'])->name('dashboard.room.store');
    Route::get('/room/edit/{id}', [Room::class, 'edit'])->name('dashboard.room.edit');
    Route::post('/room/update', [Room::class, 'update'])->name('dashboard.room.update');
    Route::post('/room/delete', [Room::class, 'delete'])->name('dashboard.room.delete');

    // Services CRUD
    Route::get('/services', [ServiceController::class, 'index'])->name('dashboard.services');
    Route::get('/services/datatable', [ServiceController::class, 'datatable'])->name('dashboard.services.datatable');
    Route::get('/service/create', [ServiceController::class, 'create'])->name('dashboard.service.create');
    Route::post('/service/store', [ServiceController::class, 'store'])->name('dashboard.service.store');
    Route::get('/service/edit/{id}', [ServiceController::class, 'edit'])->name('dashboard.service.edit');
    Route::post('/service/update', [ServiceController::class, 'update'])->name('dashboard.service.update');
    Route::post('/service/delete', [ServiceController::class, 'delete'])->name('dashboard.service.delete');

    // Hotels CRUD
    Route::get('/hotel', [\App\Http\Controllers\HotelController::class, 'index'])->name('dashboard.hotel');
    Route::get('/hotel/datatable', [\App\Http\Controllers\HotelController::class, 'datatable'])->name('dashboard.hotel.datatable');
    Route::get('/hotel/create', [\App\Http\Controllers\HotelController::class, 'create'])->name('dashboard.hotel.create');
    Route::post('/hotel/store', [\App\Http\Controllers\HotelController::class, 'store'])->name('dashboard.hotel.store');
    Route::get('/hotel/edit/{id}', [\App\Http\Controllers\HotelController::class, 'edit'])->name('dashboard.hotel.edit');
    Route::post('/hotel/update', [\App\Http\Controllers\HotelController::class, 'update'])->name('dashboard.hotel.update');
    Route::post('/hotel/delete', [\App\Http\Controllers\HotelController::class, 'delete'])->name('dashboard.hotel.delete');

    // Discounts CRUD
    Route::get('/discount', [\App\Http\Controllers\DiscountController::class, 'index'])->name('dashboard.discount');
    Route::get('/discount/datatable', [\App\Http\Controllers\DiscountController::class, 'datatable'])->name('dashboard.discount.datatable');
    Route::get('/discount/create', [\App\Http\Controllers\DiscountController::class, 'create'])->name('dashboard.discount.create');
    Route::post('/discount/store', [\App\Http\Controllers\DiscountController::class, 'store'])->name('dashboard.discount.store');
    Route::get('/discount/edit/{id}', [\App\Http\Controllers\DiscountController::class, 'edit'])->name('dashboard.discount.edit');
    Route::post('/discount/update', [\App\Http\Controllers\DiscountController::class, 'update'])->name('dashboard.discount.update');
    Route::post('/discount/delete', [\App\Http\Controllers\DiscountController::class, 'delete'])->name('dashboard.discount.delete');

    Route::view('/analytics', 'dashboard.page', ['title' => 'Analytics'])->name('dashboard.analytics');
    Route::view('/setting', 'dashboard.page', ['title' => 'Settings'])->name('dashboard.setting');
    // Reservations CRUD
    Route::get('/reservation', [\App\Http\Controllers\ReservationController::class, 'index'])->name('dashboard.reservation');
    Route::get('/reservation/datatable', [\App\Http\Controllers\ReservationController::class, 'datatable'])->name('dashboard.reservation.datatable');
    Route::get('/reservation/create', [\App\Http\Controllers\ReservationController::class, 'create'])->name('dashboard.reservation.create');
    Route::post('/reservation/store', [\App\Http\Controllers\ReservationController::class, 'store'])->name('dashboard.reservation.store');
    Route::get('/reservation/edit/{id}', [\App\Http\Controllers\ReservationController::class, 'edit'])->name('dashboard.reservation.edit');
    Route::post('/reservation/update', [\App\Http\Controllers\ReservationController::class, 'update'])->name('dashboard.reservation.update');
    Route::post('/reservation/delete', [\App\Http\Controllers\ReservationController::class, 'delete'])->name('dashboard.reservation.delete');
    Route::view('/payment', 'dashboard.page', ['title' => 'Payments'])->name('dashboard.payment');
    Route::view('/permission', 'dashboard.page', ['title' => 'Permissions'])->name('dashboard.permission');
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
Route::get('/path-check', function () {
    return 'Base Path: ' . base_path() . ' | DB: ' . DB::connection()->getDatabaseName();
});
