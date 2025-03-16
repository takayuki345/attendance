<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceRequestController;
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

    Route::get('/attendance', [AttendanceController::class, 'showStamp']);

    Route::post('/attendance', [AttendanceController::class, 'execStamp']);

    Route::get('/attendance/list', [AttendanceController::class, 'showMonthAttendance']);

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
    Route::get('/attendance/{id}', [AttendanceController::class, 'showDetail']);
    Route::post('/attendance/{id}', [AttendanceController::class, 'updateDetail']);
    Route::get('/stamp_correction_request/list', [AttendanceRequestController::class, 'index']);
});
