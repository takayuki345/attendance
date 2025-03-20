<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceBreak;
use App\Models\AttendanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceRequestController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;

        if (isset($status)) {
            $requestStatusId = $status;
        } else {
            $requestStatusId = 2;
        }

        if (Auth::guard('admin')->check()) {

            $attendanceRequests = AttendanceRequest::with('attendance.user')->where('request_status_id', $requestStatusId)->get();

        } else {

            $userId = Auth::id();
            $attendanceRequests = AttendanceRequest::whereHas('attendance', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })->where('request_status_id', $requestStatusId)->get();

        }

        return view('stamp-request', compact('requestStatusId', 'attendanceRequests'));
    }

    public function showRequestDetail($id)
    {

        $attendanceRequest = AttendanceRequest::with('attendance.user', 'attendance_request_breaks')->find($id);

        return view('attendance-detail', compact('attendanceRequest'));
    }

    public function approveRequestDetail($id)
    {

        $attendanceRequest = AttendanceRequest::with('attendance_request_breaks')->find($id);
        $attendanceRequest->request_status_id = 3;
        $attendanceRequest->save();

        $attendance = Attendance::find($attendanceRequest->attendance_id);
        $attendance->start = $attendanceRequest->start;
        $attendance->end = $attendanceRequest->end;
        $attendance->note = $attendanceRequest->note;
        // $attendance->note = $attendanceRequest->null;
        $attendance->attendance_status_id = 4;
        $attendance->request_status_id = 1;
        $attendance->save();

        AttendanceBreak::where('attendance_id', $attendance->id)->delete();

        foreach ($attendanceRequest->attendance_request_breaks as $attendanceRequestBreak) {
            $attendanceBreak = new AttendanceBreak();
            $attendanceBreak->attendance_id = $attendance->id;
            $attendanceBreak->break_start = $attendanceRequestBreak->break_start;
            $attendanceBreak->break_end = $attendanceRequestBreak->break_end;
            $attendanceBreak->save();
        }

        return redirect('/stamp_correction_request/list?status=3');
    }
}
