<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\UnifiedSignup;
use App\Livewire\Vendor\Settings;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MyLibraryController;
use App\Http\Controllers\OrderController;

// Route::get('/', function () {
//     return view('welcome');




// This route handles the main product landing page
// URL will look like: /books/5?type=digital


// });
Route::get('/signup',UnifiedSignup::class)->name('signup');
Route::get('/login',Login::class)->name('login');
Route::view('/vendor/dashboard','pages.dashboard')->name('vendor.dashboard');
Route::get('/vendor/settings',Settings::class)->name('vendor.settings');
Route::view('/', 'pages.home')->name('home');
Route::view('/search', 'pages.home')->name('search');
Route::view('/book-details', 'pages.book-details')->name('book-details');
Route::view('/book-vendor', 'pages.book-vendor')->name('book-vendor');
Route::view('/book-list', 'pages.book-list')->name('book-list');
Route::view('/category', 'pages.category')->name('category');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/profile', 'pages.home')->name('profile');
//Route::view('/contact-us', 'pages.contact')->name('contact');
// Route::view('/login', 'pages.home')->name('login');
Route::view('/dashboard', 'pages.dashboard')->name('dashboard');
Route::get('/categories', [CategoryController::class, 'show'])->name('category.books');


Route::get('/books/{uuid}', [BookController::class, 'show'])->name('books.show');
//Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');


Route::middleware('sessionauth')->group(function () {
    Route::get('/my-library', [MyLibraryController::class, 'show'])->name('library.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    // User Library Page (The one you are building now)
    Route::get('/order-management', function () {
        return view('pages.order-management'); // This view will hold your Livewire component
    })->name('order.management');

    // Order Success / Details Page
    Route::get('/dashboard/my-orders', function () {
        return view('users.my-order');
    })->name('my.orders');
});