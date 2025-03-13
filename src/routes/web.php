<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Admin\AdminController as AdminLoginController;


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

Route::get('/', function() {
    return redirect('/attendance');
});

Route::middleware('auth')->group(function() {

    Route::get('/attendance', function() {
        return view('attendance');
    });

    Route::get('/attendance/list', function() {
        return view('attendance-list');
    });

    // Route::get('/attendance/{id}', [AttendanceController::class, 'index']);

});

Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm']);
Route::post('/admin/login', [AdminLoginController::class, 'login']);
Route::post('/admin/logout', [AdminLoginController::class, 'logout']);

Route::middleware(['admin'])->group(function() {
    Route::get('/admin/attendance/list', function() {
        return view('attendance-staff-list');
    });
    Route::get('/admin/staff/list', function() {
        return view('staff');
    });
});

Route::middleware(['anyauth'])->group(function() {
    Route::get('/attendance/{id}', function() {
        return view('attendance-detail-edit');
    });
    Route::get('/stamp_correction_request/list', function() {
        return view('stamp-request');
    });
});
