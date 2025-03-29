<?php

namespace Database\Seeders;

use App\Models\AttendanceRequestBreak;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttendanceRequestBreaksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $content = [
            'attendance_request_id' => 1,
            'break_start' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(12, 10, 0),
            'break_end' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(13, 10, 0),
        ];
        AttendanceRequestBreak::create($content);
        $content = [
            'attendance_request_id' => 2,
            'break_start' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(11, 40, 0),
            'break_end' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(13, 40, 0),
        ];
        AttendanceRequestBreak::create($content);
        $content = [
            'attendance_request_id' => 3,
            'break_start' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(11, 110, 0),
            'break_end' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(14, 10, 0),
        ];
        AttendanceRequestBreak::create($content);
        $content = [
            'attendance_request_id' => 4,
            'break_start' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(10, 40, 0),
            'break_end' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(14, 40, 0),
        ];
        AttendanceRequestBreak::create($content);
        $content = [
            'attendance_request_id' => 5,
            'break_start' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(10, 10, 0),
            'break_end' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(15, 10, 0),
        ];
        AttendanceRequestBreak::create($content);
    }
}
