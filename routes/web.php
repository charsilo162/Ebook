<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');



// });
Route::view('/', 'pages.home')->name('home');
Route::view('/search', 'pages.home')->name('search');
Route::view('/contact', 'pages.home')->name('contact');
Route::view('/profile', 'pages.home')->name('profile');
Route::view('/login', 'pages.home')->name('login');
