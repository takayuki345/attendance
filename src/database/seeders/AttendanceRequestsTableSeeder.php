<?php

namespace Database\Seeders;

use App\Models\AttendanceRequest;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB;

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
            'start' => Carbon::today()->subMonth(2)->startOfMonth()->setTime(9, 10, 0),
            'end' => Carbon::today()->subMonth(2)->startOfMonth()->setTime(19, 10, 0),
            'note' => 'by test1',
            'request_status_id' => 2,
            'request_time' => Carbon::today()->subMonth(2)->startOfMonth()->subDay(5)->setTime(03, 0, 0),
        ];
        AttendanceRequest::create($content);
        $content = [
            'id' => 2,
            'attendance_id' => 10,
            'start' => Carbon::today()->subMonth(2)->startOfMonth()->setTime(8, 10, 0),
            'end' => Carbon::today()->subMonth(2)->startOfMonth()->setTime(20, 10, 0),
            'note' => 'by test2',
            'request_status_id' => 2,
            'request_time' => Carbon::today()->subMonth(2)->startOfMonth()->subDay(4)->setTime(03, 0, 0),
        ];
        AttendanceRequest::create($content);
        $content = [
            'id' => 3,
            'attendance_id' => 11,
            'start' => Carbon::today()->subMonth(2)->startOfMonth()->setTime(7, 10, 0),
            'end' => Carbon::today()->subMonth(2)->startOfMonth()->setTime(21, 10, 0),
            'note' => 'by test3',
            'request_status_id' => 2,
            'request_time' => Carbon::today()->subMonth(2)->startOfMonth()->subDay(3)->setTime(03, 0, 0),
        ];
        AttendanceRequest::create($content);
        $content = [
            'id' => 4,
            'attendance_id' => 12,
            'start' => Carbon::today()->subMonth(2)->startOfMonth()->setTime(6, 10, 0),
            'end' => Carbon::today()->subMonth(2)->startOfMonth()->setTime(22, 10, 0),
            'note' => 'by test4',
            'request_status_id' => 3,
            'request_time' => Carbon::today()->subMonth(2)->startOfMonth()->subDay(2)->setTime(03, 0, 0),
        ];
        AttendanceRequest::create($content);
        $content = [
            'id' => 5,
            'attendance_id' => 13,
            'start' => Carbon::today()->subMonth(2)->startOfMonth()->setTime(5, 10, 0),
            'end' => Carbon::today()->subMonth(2)->startOfMonth()->setTime(23, 10, 0),
            'note' => 'by test5',
            'request_status_id' => 3,
            'request_time' => Carbon::today()->subMonth(2)->startOfMonth()->subDay()->setTime(03, 0, 0),
        ];
        AttendanceRequest::create($content);
        // $content = [
        //     [
        //         'id' => 1,
        //         'attendance_id' => 1,
        //         'start' => Carbon::today()->subDay(2)->setTime(9, 45, 0),
        //         'end' => Carbon::today()->subDay(2)->setTime(19, 25, 0),
        //         'note' => '時間調整の為',
        //         'request_status_id' => 2,
        //         'request_time' => Carbon::today()->subDay(1)->setTime(10, 20, 0),
        //     ],
        //     [
        //         'id' => 2,
        //         'attendance_id' => 3,
        //         'start' => Carbon::today()->subDays(1)->setTime(10, 10, 0),
        //         'end' => Carbon::today()->subDays(1)->setTime(20, 35, 0),
        //         'note' => '休憩記載もれ',
        //         'request_status_id' => 2,
        //         'request_time' => Carbon::today()->subDay(1)->setTime(10, 20, 0),
        //     ],
        // ];
        // DB::table('attendance_requests')->insert($content);
    }
}