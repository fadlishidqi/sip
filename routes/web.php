<?php

   use Illuminate\Support\Facades\Route;
   use App\Http\Controllers\ProfileController;
   use App\Http\Controllers\BookingController; 
   use App\Http\Controllers\CrowdingController;
   use App\Http\Controllers\PaymentController;
   use App\Http\Controllers\StatusController;

   // Redirect root ke login
   Route::get('/', function () {
      return redirect()->route('pendaki.loginForm');
   });

   // Auth routes
   Route::get('/login', [App\Http\Controllers\Auth\PendakiAuthController::class, 'showLoginForm'])->name('pendaki.loginForm');
   Route::post('/login', [App\Http\Controllers\Auth\PendakiAuthController::class, 'login'])->name('pendaki.login');
   Route::get('/register', [App\Http\Controllers\Auth\PendakiAuthController::class, 'showRegisterForm'])->name('pendaki.registerForm');
   Route::post('/register', [App\Http\Controllers\Auth\PendakiAuthController::class, 'register'])->name('pendaki.register');
   Route::post('/logout', [App\Http\Controllers\Auth\PendakiAuthController::class, 'logout'])->name('pendaki.logout');

   // Routes yang memerlukan autentikasi pendaki
   Route::middleware(['auth:pendaki'])->group(function () {
      // Dashboard
      Route::get('/dashboard-pendaki', function () {
         return view('pendaki.dashboard');
      })->name('pendaki.dashboard');

      // Profile routes
      Route::get('/profile', [ProfileController::class, 'edit'])->name('pendaki.profile');
      Route::put('/profile', [ProfileController::class, 'update'])->name('pendaki.profile.update');

      // Booking routes
      Route::get('/booking', [BookingController::class, 'create'])->name('pendaki.booking');
      Route::post('/booking', [BookingController::class, 'store'])->name('pendaki.booking.store');
      Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('pendaki.booking.show');

      // Crowding information routes
      Route::get('/crowding', [CrowdingController::class, 'index'])->name('pendaki.crowding');

      // Payment routes
      Route::get('/payment/history', [PaymentController::class, 'history'])->name('pendaki.payment.history');
      Route::get('/payment', [PaymentController::class, 'create'])->name('pendaki.payment');
      Route::post('/payment', [PaymentController::class, 'store'])->name('pendaki.payment.store');
      Route::get('/payment/{payment}', [PaymentController::class, 'show'])->name('pendaki.payment.show');

      // Hiking status routes
      Route::get('/status', [StatusController::class, 'index'])->name('pendaki.status');
      Route::post('/status/depart', [StatusController::class, 'depart'])->name('pendaki.status.depart');
      Route::post('/status/return', [StatusController::class, 'return'])->name('pendaki.status.return');

      Route::post('/notifications/{id}/mark-as-read', function($id) {
         Auth::guard('pendaki')->user()
            ->notifications()
            ->where('id', $id)
            ->update(['read_at' => now()]);
         return response()->json(['status' => 'success']);
   })->name('notifications.mark-as-read');
   });