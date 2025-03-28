<?php

namespace Database\Seeders;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $content = [
            'id' => 1,
            'date' => Carbon::now(),
            'user_id' => 2,
            'start' => Carbon::now()->setTime(1, 0, 0),
            'end' => null,
            'note' => null,
            'attendance_status_id' => 2,
            'request_status_id' => 1,
        ];
        Attendance::create($content);
        $content = [
            'id' => 2,
            'date' => Carbon::now(),
            'user_id' => 3,
            'start' => Carbon::now()->setTime(1, 0, 0),
            'end' => null,
            'note' => null,
            'attendance_status_id' => 3,
            'request_status_id' => 1,
        ];
        Attendance::create($content);
        $content = [
            'id' => 3,
            'date' => Carbon::now()->subDay(),
            'user_id' => 4,
            'start' => Carbon::now()->subDay()->setTime(7, 0, 0),
            'end' => Carbon::now()->subDay()->setTime(21, 0, 0),
            'note' => null,
            'attendance_status_id' => 4,
            'request_status_id' => 1,
        ];
        Attendance::create($content);
        $content = [
            'id' => 4,
            'date' => Carbon::now(),
            'user_id' => 4,
            'start' => Carbon::now()->setTime(8, 0, 0),
            'end' => Carbon::now()->setTime(20, 0, 0),
            'note' => null,
            'attendance_status_id' => 4,
            'request_status_id' => 1,
        ];
        Attendance::create($content);
        $content = [
            'id' => 5,
            'date' => Carbon::now()->addDay(),
            'user_id' => 4,
            'start' => Carbon::now()->addDay()->setTime(9, 0, 0),
            'end' => Carbon::now()->addDay()->setTime(19, 0, 0),
            'note' => null,
            'attendance_status_id' => 4,
            'request_status_id' => 1,
        ];
        Attendance::create($content);
        $content = [
            'id' => 6,
            'date' => Carbon::now()->subMonth()->startOfMonth(),
            'user_id' => 5,
            'start' => Carbon::now()->subMonth()->startOfMonth()->setTime(7, 0, 0),
            'end' => Carbon::now()->subMonth()->startOfMonth()->setTime(21, 0, 0),
            'note' => null,
            'attendance_status_id' => 4,
            'request_status_id' => 1,
        ];
        Attendance::create($content);
        $content = [
            'id' => 7,
            'date' => Carbon::now()->startOfMonth(),
            'user_id' => 5,
            'start' => Carbon::now()->startOfMonth()->setTime(8, 0, 0),
            'end' => Carbon::now()->startOfMonth()->setTime(20, 0, 0),
            'note' => null,
            'attendance_status_id' => 4,
            'request_status_id' => 1,
        ];
        Attendance::create($content);
        $content = [
            'id' => 8,
            'date' => Carbon::now()->addMonth()->startOfMonth(),
            'user_id' => 5,
            'start' => Carbon::now()->addMonth()->startOfMonth()->setTime(9, 0, 0),
            'end' => Carbon::now()->addMonth()->startOfMonth()->setTime(19, 0, 0),
            'note' => null,
            'attendance_status_id' => 4,
            'request_status_id' => 1,
        ];
        Attendance::create($content);




        $content = [
            'id' => 9,
            'date' => Carbon::now()->subMonth(2)->startOfMonth(),
            'user_id' => 1,
            'start' => Carbon::now()->subMonth(2)->startOfMonth()->setTime(9, 0, 0),
            'end' => Carbon::now()->subMonth(2)->startOfMonth()->setTime(19, 0, 0),
            'note' => null,
            'attendance_status_id' => 4,
            'request_status_id' => 2,
        ];
        Attendance::create($content);
        $content = [
            'id' => 10,
            'date' => Carbon::now()->subMonth(2)->startOfMonth(),
            'user_id' => 2,
            'start' => Carbon::now()->subMonth(2)->startOfMonth()->setTime(8, 0, 0),
            'end' => Carbon::now()->subMonth(2)->startOfMonth()->setTime(20, 0, 0),
            'note' => null,
            'attendance_status_id' => 4,
            'request_status_id' => 2,
        ];
        Attendance::create($content);
        $content = [
            'id' => 11,
            'date' => Carbon::now()->subMonth(2)->startOfMonth(),
            'user_id' => 3,
            'start' => Carbon::now()->subMonth(2)->startOfMonth()->setTime(7, 0, 0),
            'end' => Carbon::now()->subMonth(2)->startOfMonth()->setTime(21, 0, 0),
            'note' => null,
            'attendance_status_id' => 4,
            'request_status_id' => 2,
        ];
        Attendance::create($content);
        $content = [
            'id' => 12,
            'date' => Carbon::now()->subMonth(2)->startOfMonth(),
            'user_id' => 4,
            'start' => Carbon::now()->subMonth(2)->startOfMonth()->setTime(6, 10, 0),
            'end' => Carbon::now()->subMonth(2)->startOfMonth()->setTime(22, 10, 0),
            'note' => 'by test4',
            'attendance_status_id' => 4,
            'request_status_id' => 3,
        ];
        Attendance::create($content);
        $content = [
            'id' => 13,
            'date' => Carbon::now()->subMonth(2)->startOfMonth(),
            'user_id' => 5,
            'start' => Carbon::now()->subMonth(2)->startOfMonth()->setTime(5, 10, 0),
            'end' => Carbon::now()->subMonth(2)->startOfMonth()->setTime(23, 10, 0),
            'note' => 'by test5',
            'attendance_status_id' => 4,
            'request_status_id' => 3,
        ];
        Attendance::create($content);
    }
}
