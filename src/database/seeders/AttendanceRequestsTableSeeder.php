<?php

namespace Database\Seeders;

use App\Models\AttendanceRequest;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttendanceRequestsTableSeeder extends Seeder
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
            'attendance_id' => 9,
            'start' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(9, 10, 0),
            'end' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(19, 10, 0),
            'note' => 'by test1',
            'request_status_id' => 2,
            'request_time' => Carbon::today()->startOfMonth()->subMonth(2)->subDay(5)->setTime(03, 0, 0),
        ];
        AttendanceRequest::create($content);
        $content = [
            'id' => 2,
            'attendance_id' => 10,
            'start' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(8, 10, 0),
            'end' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(20, 10, 0),
            'note' => 'by test2',
            'request_status_id' => 2,
            'request_time' => Carbon::today()->startOfMonth()->subMonth(2)->subDay(4)->setTime(03, 0, 0),
        ];
        AttendanceRequest::create($content);
        $content = [
            'id' => 3,
            'attendance_id' => 11,
            'start' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(7, 10, 0),
            'end' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(21, 10, 0),
            'note' => 'by test3',
            'request_status_id' => 2,
            'request_time' => Carbon::today()->startOfMonth()->subMonth(2)->subDay(3)->setTime(03, 0, 0),
        ];
        AttendanceRequest::create($content);
        $content = [
            'id' => 4,
            'attendance_id' => 12,
            'start' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(6, 10, 0),
            'end' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(22, 10, 0),
            'note' => 'by test4',
            'request_status_id' => 3,
            'request_time' => Carbon::today()->startOfMonth()->subMonth(2)->subDay(2)->setTime(03, 0, 0),
        ];
        AttendanceRequest::create($content);
        $content = [
            'id' => 5,
            'attendance_id' => 13,
            'start' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(5, 10, 0),
            'end' => Carbon::today()->startOfMonth()->subMonth(2)->setTime(23, 10, 0),
            'note' => 'by test5',
            'request_status_id' => 3,
            'request_time' => Carbon::today()->startOfMonth()->subMonth(2)->subDay()->setTime(03, 0, 0),
        ];
        AttendanceRequest::create($content);
    }
}