<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceBreak;
use App\Models\AttendanceRequest;
use App\Models\AttendanceRequestBreak;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index($id)
    {
        if($id == 1) {

            return view('attendance-detail-edit');

        } elseif($id == 2) {

            return view('attendance-detail');

        }
    }

    public function showStamp()
    {
        $user_id = Auth::id();
        $now = Carbon::now();
        $attendance = Attendance::where('date', $now->isoFormat('YYYY-MM-DD'))->where('user_id', $user_id)->first();

        if($attendance) {

            $attendance_status = $attendance->attendance_status->name;

        }else{

            $attendance_status = "勤務外";

        }
        $date = $now->isoFormat('YYYY年M月D日(ddd)');
        $time = $now->isoFormat('HH:mm');
        return view('attendance', compact('attendance_status', 'date', 'time'));
    }

    public function execStamp(Request $request)
    {
        $user_id = Auth::id();
        $now = Carbon::now();

        $action = $request->action;

        if ($action == 'start') {

            $attendance = new Attendance();
            $attendance->user_id = $user_id;
            $attendance->date = $now->toDateString();
            $attendance->start = $now;
            $attendance->end = null;
            $attendance->note = null;
            $attendance->attendance_status_id = 2;
            $attendance->request_status_id = 1;
            $attendance->save();

        } elseif ($action == 'end') {

            $attendance = Attendance::where('date', $now->isoFormat('YYYY-MM-DD'))->where('user_id', $user_id)->first();
            $attendance->end = $now;
            $attendance->attendance_status_id = 4;
            $attendance->save();

        } elseif ($action == 'break_start') {

            $attendance = Attendance::where('date', $now->isoFormat('YYYY-MM-DD'))->where('user_id', $user_id)->first();
            $attendance->attendance_status_id = 3;
            $attendance->save();
            $attendance_break = new AttendanceBreak();
            $attendance_break->attendance_id = $attendance->id;
            $attendance_break->break_start = $now;
            $attendance_break->break_end = null;
            $attendance_break->save();

        } elseif($action == 'break_end') {

            $attendance = Attendance::where('date', $now->isoFormat('YYYY-MM-DD'))->where('user_id', $user_id)->first();
            $attendance->attendance_status_id = 2;
            $attendance->save();

            $target_id = AttendanceBreak::where('attendance_id', $attendance->id)->max('id');
            $attendance_break = AttendanceBreak::find($target_id);
            $attendance_break->break_end = $now;
            $attendance_break->save();
        }

        return redirect('/attendance');
    }

    public function showMonthAttendance(Request $request)
    {

        $year = $request->year;
        $month = $request->month;
        $user_id = Auth::id();

        if ($year != null && $month != null) {
            $start_date = Carbon::create($year, $month)->startOfMonth();
            $end_date = Carbon::create($year, $month)->endOfMonth();
        } else {
            $year = Carbon::now()->year;
            $month = Carbon::now()->month;
            $start_date = Carbon::now()->startOfMonth();
            $end_date = Carbon::now()->endOfMonth();
        }
        $targets= [
            'year' => $year,
            'month' => $month,
            'before_year' => Carbon::create($year, $month - 1)->year,
            'before_month' => Carbon::create($year, $month - 1)->month,
            'after_year' => Carbon::create($year, $month + 1)->year,
            'after_month' => Carbon::create($year, $month + 1)->month,
        ];

        $period = CarbonPeriod::create($start_date, $end_date);

        $time_records = array();

        foreach ($period as $date) {
            $attendance = Attendance::where('user_id', $user_id)->where('date', $date->isoFormat('YYYY-MM-DD'))->first();
            $start = "";
            $end = "";
            $break = "";
            $total = "";
            $id = "";
            if($attendance) {
                if ($attendance->start != null) {
                    $start = Carbon::parse($attendance->start)->isoFormat('HH:mm');
                }
                if ($attendance->end != null) {
                    $end = Carbon::parse($attendance->end)->isoFormat('HH:mm');
                }
                $break_seconds = 0;
                foreach ($attendance->attendance_breaks as $attendance_break) {
                    if (isset($attendance_break->break_end)) {
                        $break_seconds += strtotime($attendance_break->break_end) - strtotime($attendance_break->break_start);
                    }
                }
                if ($break_seconds != 0) {
                    $break = $this->formatTime($break_seconds);
                }

                if(isset($attendance->end)) {
                    $total_seconds = strtotime($attendance->end) - strtotime($attendance->start) - $break_seconds;
                    $total = $this->formatTime($total_seconds);
                }
                $id = $attendance->id;
            }
            $time_record = [
                'date' => $date->isoFormat('MM/DD(ddd)'),
                'start' => $start,
                'end' => $end,
                'break' => $break,
                'total' => $total,
                'id' => $id,
            ];
            array_push($time_records, $time_record);
        }

        return view('attendance-list', compact('time_records'), compact('targets'));
    }

    public function showDetail($id)
    {
        $attendance = Attendance::find($id);

        if ($attendance->request_status_id == 1) {

            $attendance = Attendance::with('user', 'attendance_breaks')->find($id);

            return view('attendance-detail-edit', compact('attendance'));

        } elseif ($attendance->request_status_id == 2) {

            $attendance_request = AttendanceRequest::with('attendance.user', 'attendance_request_breaks')->find($id);

            return view('attendance-detail', compact('attendance_request'));

        }
    }

    public function updateDetail($id, Request $request)
    {

        $attendance = Attendance::find($id);
        $attendance->request_status_id = 2;
        $attendance->save();

        $attendance_request = new AttendanceRequest();
        $attendance_request->attendance_id = $id;
        $attendance_request->start = Carbon::createFromTimeString($request->start . ':00');
        $attendance_request->end = Carbon::createFromTimeString($request->end . ':00');
        $attendance_request->note = $request->note;
        $attendance_request->request_status_id = 2;
        $attendance_request->request_time = Carbon::now();
        $attendance_request->save();


        if (isset($request->break_start)) {
            $len = count($request->break_start);
            for ($i = 0; $i < $len; $i++) {
                $attendance_request_break = new AttendanceRequestBreak();
                $attendance_request_break->attendance_request_id = $id;
                $attendance_request_break->break_start = Carbon::createFromTimeString($request->break_start[$i] . ':00');
                $attendance_request_break->break_end = Carbon::createFromTimeString($request->break_end[$i] . ':00');
                $attendance_request_break->save();
            }
        }
        if ($request->break_start_add != null && $request->break_end_add != null) {
            $attendance_request_break = new AttendanceRequestBreak();
            $attendance_request_break->attendance_request_id = $id;
            $attendance_request_break->break_start = Carbon::createFromTimeString($request->break_start_add . ':00');
            $attendance_request_break->break_end = Carbon::createFromTimeString($request->break_end_add . ':00');
            $attendance_request_break->save();
        }

        return redirect('/stamp_correction_request/list');
    }

    public function formatTime(int $seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        return sprintf('%02d', $hours) . ':' . sprintf('%02d', $minutes);
    }
}
