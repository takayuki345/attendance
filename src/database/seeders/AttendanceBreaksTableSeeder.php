<?php

namespace Database\Seeders;

use App\Models\AttendanceBreak;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttendanceBreaksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $content = [
            'attendance_id' => 2,
            'break_start' => Carbon::now()->setTime(2, 0, 0),
            'break_end' => null,
        ];
        AttendanceBreak::create($content);
        $content = [
            'attendance_id' => 3,
            'break_start' => Carbon::now()->subDay()->setTime(11, 0, 0),
            'break_end' => Carbon::now()->subDay()->setTime(14, 0, 0),
        ];
        AttendanceBreak::create($content);
        $content = [
            'attendance_id' => 4,
            'break_start' => Carbon::now()->setTime(11, 30, 0),
            'break_end' => Carbon::now()->setTime(13, 30, 0),
        ];
        AttendanceBreak::create($content);
        $content = [
            'attendance_id' => 5,
            'break_start' => Carbon::now()->addDay()->setTime(12, 0, 0),
            'break_end' => Carbon::now()->addDay()->setTime(13, 0, 0),
        ];
        AttendanceBreak::create($content);
        $content = [
            'attendance_id' => 6,
            'break_start' => Carbon::now()->startOfMonth()->subMonth()->setTime(11, 0, 0),
            'break_end' => Carbon::now()->startOfMonth()->subMonth()->setTime(14, 0, 0),
        ];
        AttendanceBreak::create($content);
        $content = [
            'attendance_id' => 7,
            'break_start' => Carbon::now()->startOfMonth()->setTime(11, 30, 0),
            'break_end' => Carbon::now()->startOfMonth()->setTime(13, 30, 0),
        ];
        AttendanceBreak::create($content);
        $content = [
            'attendance_id' => 8,
            'break_start' => Carbon::now()->startOfMonth()->addMonth()->setTime(12, 0, 0),
            'break_end' => Carbon::now()->startOfMonth()->addMonth()->setTime(13, 0, 0),
        ];
        AttendanceBreak::create($content);


        $content = [
            'attendance_id' => 9,
            'break_start' => Carbon::now()->startOfMonth()->subMonth(2)->setTime(12, 0, 0),
            'break_end' => Carbon::now()->startOfMonth()->subMonth(2)->setTime(13, 0, 0),
        ];
        AttendanceBreak::create($content);
        $content = [
            'attendance_id' => 10,
            'break_start' => Carbon::now()->startOfMonth()->subMonth(2)->setTime(11, 30, 0),
            'break_end' => Carbon::now()->startOfMonth()->subMonth(2)->setTime(13, 30, 0),
        ];
        AttendanceBreak::create($content);
        $content = [
            'attendance_id' => 11,
            'break_start' => Carbon::now()->startOfMonth()->subMonth(2)->setTime(11, 0, 0),
            'break_end' => Carbon::now()->startOfMonth()->subMonth(2)->setTime(14, 0, 0),
        ];
        AttendanceBreak::create($content);
        $content = [
            'attendance_id' => 12,
            'break_start' => Carbon::now()->startOfMonth()->subMonth(2)->setTime(10, 40, 0),
            'break_end' => Carbon::now()->startOfMonth()->subMonth(2)->setTime(14, 40, 0),
        ];
        AttendanceBreak::create($content);
        $content = [
            'attendance_id' => 13,
            'break_start' => Carbon::now()->startOfMonth()->subMonth(2)->setTime(10, 10, 0),
            'break_end' => Carbon::now()->startOfMonth()->subMonth(2)->setTime(15, 10, 0),
        ];
        AttendanceBreak::create($content);
    }
}
