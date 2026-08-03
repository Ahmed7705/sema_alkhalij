<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceManagerController;
use App\Http\Controllers\Admin\ProductManagerController;
use App\Http\Controllers\Admin\BookingManagerController;
use App\Http\Controllers\Admin\OrderManagerController;
use App\Http\Controllers\Admin\SettingsManagerController;
use App\Http\Controllers\Admin\UserManagerController;

/*
|--------------------------------------------------------------------------
| Web Routes — Sema Al-Khalij Medical Services
|--------------------------------------------------------------------------
*/

// Public Marketing Pages
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::get('/blog', function () {
    return view('blog');
})->name('blog');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/verify-otp', [VerificationController::class, 'showVerificationForm'])->name('verify.otp.form');
Route::post('/verify-otp', [VerificationController::class, 'verify'])->name('verify.otp');
Route::post('/verify-otp/resend', [VerificationController::class, 'resend'])->name('verify.otp.resend');

// Password Reset Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// Social Login Routes (Google & Apple)
Route::get('/auth/{provider}', [SocialAuthController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->name('social.callback');

// Customer Profile Route
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

// Legal Pages
Route::get('/privacy-policy', function () {
    return view('legal.privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('legal.terms');
})->name('terms');

use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\AuditLogController;

// ADMIN CONTROL PANEL ROUTES (Protected by Auth & Admin Middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Global Search
    Route::get('search', [SearchController::class, 'search'])->name('search');

    // Audit Activity Logs
    Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit.index');
    
    // Services
    Route::resource('services', ServiceManagerController::class);
    
    // Products
    Route::resource('products', ProductManagerController::class);
    
    // Bookings
    Route::get('bookings', [BookingManagerController::class, 'index'])->name('bookings.index');
    Route::post('bookings/{id}/status', [BookingManagerController::class, 'updateStatus'])->name('bookings.status');
    
    // Orders
    Route::get('orders', [OrderManagerController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [OrderManagerController::class, 'show'])->name('orders.show');
    Route::post('orders/{id}/status', [OrderManagerController::class, 'updateStatus'])->name('orders.status');
    
    // Settings & CMS
    Route::get('settings', [SettingsManagerController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsManagerController::class, 'update'])->name('settings.update');
    
    // Users & Roles
    Route::get('users', [UserManagerController::class, 'index'])->name('users.index');
    Route::post('users/{id}/role', [UserManagerController::class, 'updateRole'])->name('users.role');
    Route::post('users/{id}/toggle', [UserManagerController::class, 'toggleStatus'])->name('users.toggle');
    Route::delete('users/{id}', [UserManagerController::class, 'destroy'])->name('users.destroy');
});
