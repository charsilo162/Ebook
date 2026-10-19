<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\UnifiedSignup;
use App\Livewire\Vendor\Settings;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MyLibraryController;
use App\Http\Controllers\OrderController;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\User\UserSettings;
use Illuminate\Support\Facades\Session;
use App\Livewire\AffiliateDashboard;
use App\Livewire\Admin\PayoutManager;
use App\Livewire\Admin\AffiliateOverview;

// Route::get('/', function () {
//     return view('welcome');
//Route::view('/book-details', 'pages.book-details')->name('book-details');
// Route::view('/category', 'pages.category')->name('category');
//Route::view('/contact-us', 'pages.contact')->name('contact');
// Route::view('/login', 'pages.home')->name('login');
//Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
//Route::view('/profile', 'pages.home')->name('profile');
//Route::view('/vendor/dashboard','pages.dashboard')->name('vendor.dashboard');


// This route handles the main product landing page
// URL will look like: /books/5?type=digital


// });
Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');

Route::get('/forgot-password', ForgotPassword::class)->name('password.request');

Route::get('/signup',UnifiedSignup::class)->name('signup');
Route::get('/login',Login::class)->name('login');
Route::post('/logout', function () { Session::forget('user');
                Session::forget('api_token');
                return redirect()->route('login');
            })->name('logout');

 

Route::view('/', 'pages.home')->name('home');
Route::view('/search', 'pages.home')->name('search');
Route::view('/book-vendor', 'pages.book-vendor')->name('book-vendor');
Route::view('/book-list', 'pages.book-list')->name('book-list');
Route::view('/contact', 'pages.contact')->name('contact');
Route::get('/categories', [CategoryController::class, 'show'])->name('category.books');
Route::get('/books/{uuid}', [BookController::class, 'show'])->name('books.show');
Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');

   // Users routes
Route::middleware('sessionauth')->group(function () {
    Route::get('/user-settings', UserSettings::class)->name('user.settings');
    Route::get('/my-library', [MyLibraryController::class, 'show'])->name('library.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    // User Library Page (The one you are building now)
    // Route::view('/dashboard', 'pages.dashboard')->name('dashboard');

 
    Route::get('/dashboard/my-orders', function () {
        return view('users.my-order');
    })->name('my.orders');

});




            //Vendor Routes
        Route::middleware('vendor')->group(function () {
        Route::get('/order-management', function () {
                        return view('pages.order-management'); // This view will hold your Livewire component
                    })->name('order.management');
        Route::get('/vendor/settings',Settings::class)->name('vendor.settings');
        });


// Admin Routes
 Route::middleware('admin')->group(function () {
    Route::get('/admin/manage-books', function () {
        return view('pages.admin-manger');
    })->name('admin.books');
    Route::get('/admin/manage-user', function () {
        return view('pages.manage-user');
    })->name('admin.user');
    Route::get('/admin/manage-category', function () {
        return view('pages.manage-category');
    })->name('admin.category');

 });

 // --- USER ROUTES ---
Route::middleware(['sessionauth'])->group(function () {
    // User's own referral and withdrawal page
        Route::get('/affiliate-center', function () {
        return view('pages.affiliate');
    })->name('affiliate.dashboard');
    // Route::get('/affiliate-center', AffiliateDashboard::class)->name('affiliate.dashboard');
});

// --- ADMIN ROUTES ---
Route::middleware(['admin'])->group(function () {
    // Page to manage and approve withdrawal requests
        Route::get('/admin/payouts', function () {
        return view('pages.payouts');
    })->name('admin.payouts');
   // Route::get('/admin/payouts', PayoutManager::class)->name('admin.payouts');
    
    // Page to see all balances, logs, and change commission rates
            Route::get('/admin/affiliate-overview', function () {
        return view('pages.affiliate-overview');
    })->name('admin.overview');
    // Route::get('/admin/affiliate-overview', AffiliateOverview::class)->name('admin.overview');
});