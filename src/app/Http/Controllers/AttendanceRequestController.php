<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceRequestController extends Controller
{
    public function index(Request $request)
    {
        $user_id = Auth::id();
        $status = $request->status;

        if (isset($status)) {
            $request_status_id = $status;
        } else {
            $request_status_id = 2;
        }

        $attendance_requests = AttendanceRequest::whereHas('attendance', function($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->where('request_status_id', $request_status_id)->get();

        return view('stamp-request', compact('request_status_id', 'attendance_requests'));
    }
}
