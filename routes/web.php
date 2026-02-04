<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\UnifiedSignup;
use App\Livewire\Vendor\Settings;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');



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
