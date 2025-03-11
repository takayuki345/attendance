<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', function(){
    return view('login');
});

Route::get('/register', function() {
    return view('register');
});

Route::get('/attendance', function() {
    return view('attendance');
});

Route::get('/attendance-detail', function() {
    return view('attendance-detail');
});

Route::get('/attendance-detail-edit', function() {
    return view('attendance-detail-edit');
});

Route::get('/staff', function() {
    return view('staff');
});

Route::get('/stamp-request', function() {
    return view('stamp-request');
});

Route::get('/attendance-staff-list', function() {
    return view('attendance-staff-list');
});

Route::get('/attendance-list', function() {
    return view('attendance-list');
});

Route::get('/email/verify', function() {
    return view('verify-email');
});