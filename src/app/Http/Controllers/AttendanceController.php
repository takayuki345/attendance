<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceRequest2;
use App\Models\Attendance;
use App\Models\AttendanceBreak;
use App\Models\AttendanceRequest;
use App\Models\AttendanceRequestBreak;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AttendanceController extends Controller
{

    public function showStamp()
    {
        $userId = Auth::id();
        $now = Carbon::now();
        $attendance = Attendance::where('date', $now->format('Y-m-d'))->where('user_id', $userId)->first();

        if($attendance) {

            $attendanceStatus = $attendance->attendance_status->name;

        }else{

            $attendanceStatus = "勤務外";

        }
        $date = $now->isoFormat('YYYY年M月D日(ddd)');
        $time = $now->isoFormat('HH:mm');
        return view('attendance', compact('attendanceStatus', 'date', 'time'));
    }

    public function execStamp(Request $request)
    {
        $userId = Auth::id();
        $now = Carbon::now();

        $action = $request->action;

        if ($action == 'start') {

            $attendance = new Attendance();
            $attendance->user_id = $userId;
            $attendance->date = $now->toDateString();
            $attendance->start = $now->format('Y-m-d H:i:00');
            $attendance->end = null;
            $attendance->note = null;
            $attendance->attendance_status_id = 2;
            $attendance->request_status_id = 1;
            $attendance->save();

        } else {

            $attendance = Attendance::where('date', $now->format('Y-m-d'))->where('user_id', $userId)->first();
            if (isset($attendance)) {

                if ($action == 'end') {

                    $attendance->end = $now->format('Y-m-d H:i:00');
                    $attendance->attendance_status_id = 4;
                    $attendance->save();

                } elseif ($action == 'break_start') {

                    $attendance->attendance_status_id = 3;
                    $attendance->save();
                    $attendanceBreak = new AttendanceBreak();
                    $attendanceBreak->attendance_id = $attendance->id;
                    $attendanceBreak->break_start = $now->format('Y-m-d H:i:00');
                    $attendanceBreak->break_end = null;
                    $attendanceBreak->save();

                } elseif($action == 'break_end') {

                    $attendance->attendance_status_id = 2;
                    $attendance->save();
                    $targetId = AttendanceBreak::where('attendance_id', $attendance->id)->max('id');
                    $attendanceBreak = AttendanceBreak::find($targetId);
                    $attendanceBreak->break_end = $now->format('Y-m-d H:i:00');
                    $attendanceBreak->save();
                }
            }
        }

        return redirect('/attendance');

    }

    public function showMonthAttendance(Request $request, $id = null)
    {

        $year = $request->year;
        $month = $request->month;
        if ($id) {
            $userId = $id;
        } else {
            $userId = Auth::id();
        }

        $userName = User::find($userId)->name;

        if ($year != null && $month != null) {
            $startDate = Carbon::create($year, $month)->startOfMonth();
            $endDate = Carbon::create($year, $month)->endOfMonth();
        } else {
            $year = Carbon::now()->year;
            $month = Carbon::now()->month;
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        }
        $targets= [
            'year' => $year,
            'month' => $month,
            'beforeYear' => Carbon::create($year, $month - 1)->year,
            'beforeMonth' => Carbon::create($year, $month - 1)->month,
            'afterYear' => Carbon::create($year, $month + 1)->year,
            'afterMonth' => Carbon::create($year, $month + 1)->month,
        ];

        $timeRecords = $this->getTimeRecordsArray($year, $month, $userId);

        return view('attendance-list', compact('timeRecords', 'targets', 'userId', 'userName'));
    }

    public function showDetail($id)
    {
        $attendance = Attendance::find($id);

        if ($attendance->date == Carbon::now()->format('Y-m-d')) {

            $attendance = Attendance::with('user', 'attendance_breaks')->find($id);

            return view('attendance-detail2', compact('attendance'));

        }

        if (Auth::guard('admin')->check() || $attendance->request_status_id == 1) {

            $attendance = Attendance::with('user', 'attendance_breaks')->find($id);

            return view('attendance-detail-edit', compact('attendance'));

        } elseif ($attendance->request_status_id == 2) {

            $attendanceRequest = AttendanceRequest::with('attendance.user', 'attendance_request_breaks')->find(AttendanceRequest::where('attendance_id', $id)->max('id'));

            return view('attendance-detail', compact('attendanceRequest'));

        }
    }

    public function updateDetail($id, AttendanceRequest2 $request)
    {

        if (Auth::guard('admin')->check()) {

            $attendance = Attendance::find($id);
            $date = $attendance->date;
            $attendance->start = Carbon::createFromTimeString($date . ' ' . $request->start . ':00');
            $attendance->end = Carbon::createFromTimeString($date . ' ' . $request->end . ':00');
            $attendance->note = $request->note;
            $attendance->save();

            if (isset($request->id)) {
                $len = count($request->id);
                for ($i = 0; $i < $len; $i++) {
                    $attendanceBreak = AttendanceBreak::find($request->id[$i]);
                    $attendanceBreak->break_start = Carbon::createFromTimeString($date . ' ' . $request->break_start[$i] . ':00');
                    $attendanceBreak->break_end = Carbon::createFromTimeString($date . ' ' . $request->break_end[$i] . ':00');
                    $attendanceBreak->save();
                }
            }

            if ($request->break_start_add != null && $request->break_end_add != null) {
                $attendanceBreak = new AttendanceBreak();
                $attendanceBreak->attendance_id = $id;
                $attendanceBreak->break_start = Carbon::createFromTimeString($date . ' ' . $request->break_start_add . ':00');
                $attendanceBreak->break_end = Carbon::createFromTimeString($date . ' ' . $request->break_end_add . ':00');
                $attendanceBreak->save();
            }

            return redirect('/admin/attendance/list');

        } else {

            $attendance = Attendance::find($id);
            $attendance->request_status_id = 2;
            $attendance->save();

            $date = $attendance->date;

            $attendanceRequest = new AttendanceRequest();
            $attendanceRequest->attendance_id = $id;
            $attendanceRequest->start = Carbon::createFromTimeString($date . ' ' . $request->start . ':00');
            $attendanceRequest->end = Carbon::createFromTimeString($date . ' ' . $request->end . ':00');
            $attendanceRequest->note = $request->note;
            $attendanceRequest->request_status_id = 2;
            $attendanceRequest->request_time = Carbon::now();
            $attendanceRequest->save();

            if (isset($request->break_start)) {
                $len = count($request->break_start);
                for ($i = 0; $i < $len; $i++) {
                    $attendanceRequestBreak = new AttendanceRequestBreak();
                    $attendanceRequestBreak->attendance_request_id = $attendanceRequest->id;
                    $attendanceRequestBreak->break_start = Carbon::createFromTimeString($date . ' ' . $request->break_start[$i] . ':00');
                    $attendanceRequestBreak->break_end = Carbon::createFromTimeString($date . ' ' . $request->break_end[$i] . ':00');
                    $attendanceRequestBreak->save();
                }
            }

            if ($request->break_start_add != null && $request->break_end_add != null) {
                $attendanceRequestBreak = new AttendanceRequestBreak();
                $attendanceRequestBreak->attendance_request_id = $attendanceRequest->id;
                $attendanceRequestBreak->break_start = Carbon::createFromTimeString($date . ' ' . $request->break_start_add . ':00');
                $attendanceRequestBreak->break_end = Carbon::createFromTimeString($date . ' ' . $request->break_end_add . ':00');
                $attendanceRequestBreak->save();
            }

            return redirect('/stamp_correction_request/list');
        }

    }

    public function showDayStaffAttendance(Request $request)
    {
        $date = $request->date;
        if(!isset($date)){
            $date = Carbon::now()->format('Y-m-d');
        }

        $users = User::all();
        $timeRecords = array();

        foreach ($users as $user) {

            $userName = $user->name;
            $start = "";
            $end = "";
            $break = "";
            $total = "";
            $id = "";

            $attendance = Attendance::with(['attendance_breaks'])->where('date', $date)->where('user_id', $user->id)->first();

            if (isset($attendance->start)) {
                $start = Carbon::parse($attendance->start)->format('H:i');
            }

            if (isset($attendance->end)) {
                $end = Carbon::parse($attendance->end)->format('H:i');
            }

            $breakSeconds = 0;
            if (isset($attendance->attendance_breaks)) {
                foreach ($attendance->attendance_breaks as $attendanceBreak) {
                    if ($attendanceBreak->break_end) {
                        $breakSeconds += strtotime($attendanceBreak->break_end) - strtotime($attendanceBreak->break_start);
                    }
                }
            }

            if ($breakSeconds != 0) {
                $break = $this->formatTime($breakSeconds);
            } elseif (isset($attendance->attendance_breaks)) {
                if ($attendance->attendance_breaks->count() > 0) {
                    $break = $this->formatTime(0);
                }
            }

            if (isset($attendance->end)) {
                $totalSeconds = strtotime($attendance->end) - strtotime($attendance->start) -$breakSeconds;
                $total = $this->formatTime($totalSeconds);
            }

            if (isset($attendance->id)) {
                $id = $attendance->id;
            }

            $timeRecord = [
                'userName' => $userName,
                'start' => $start,
                'end' => $end,
                'break' => $break,
                'total' => $total,
                'id' => $id
            ];

            array_push($timeRecords, $timeRecord);

        }

        $dateSet = [
            'target' => $date,
            'before' => Carbon::parse($date)->subDay()->format('Y-m-d'),
            'after' => Carbon::parse($date)->addDay()->format('Y-m-d'),
        ];


        return view('attendance-staff-list', compact('timeRecords', 'dateSet'));
    }

    public function formatTime(int $seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);

        return sprintf('%02d', $hours) . ':' . sprintf('%02d', $minutes);
    }

    public function downloadCsv(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $userId = $request->user_id;

        $csvHeader = ['日付', '出勤', '退勤', '休憩', '合計'];
        $csvData = $this->getTimeRecordsArray($year, $month, $userId);

        mb_convert_variables('SJIS-win', 'UTF-8', $csvHeader);
        mb_convert_variables('SJIS-win', 'UTF-8', $csvData);

        $response = new StreamedResponse(function () use ($csvHeader, $csvData) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $csvHeader);

            foreach ($csvData as $csv) {
                unset($csv['id']);
                fputcsv($handle, $csv);
            }
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="month_attendance_' . $year . '_' . sprintf('%02d',$month) . '_' . $request->user_id . '.csv"',
        ]);

        return $response;
    }

    public function getTimeRecordsArray($year, $month, $userId)
    {

        $startDate = Carbon::create($year, $month)->startOfMonth();
        $endDate = Carbon::create($year, $month)->endOfMonth();

        $period = CarbonPeriod::create($startDate, $endDate);

        $timeRecords = array();

        foreach ($period as $date) {
            $attendance = Attendance::where('user_id', $userId)->where('date', $date->format('Y-m-d'))->first();
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
                $breakSeconds = 0;
                foreach ($attendance->attendance_breaks as $attendanceBreak) {
                    if (isset($attendanceBreak->break_end)) {
                        $breakSeconds += strtotime($attendanceBreak->break_end) - strtotime($attendanceBreak->break_start);
                    }
                }
                if ($breakSeconds != 0) {
                    $break = $this->formatTime($breakSeconds);
                } elseif (isset($attendance->attendance_breaks)) {
                    if ($attendance->attendance_breaks->count() > 0) {
                        $break = $this->formatTime(0);
                    }
                }

                if(isset($attendance->end)) {
                    $totalSeconds = strtotime($attendance->end) - strtotime($attendance->start) - $breakSeconds;
                    $total = $this->formatTime($totalSeconds);
                }
                $id = $attendance->id;
            }
            $timeRecord = [
                'date' => $date->isoFormat('MM/DD(ddd)'),
                'start' => $start,
                'end' => $end,
                'break' => $break,
                'total' => $total,
                'id' => $id,
            ];
            array_push($timeRecords, $timeRecord);
        }

        return $timeRecords;
    }
}
