<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            [
                'id' => 1,
                'attendance_id' => 1,
                'start' => Carbon::today()->subDay(2)->setTime(9, 45, 0),
                'end' => Carbon::today()->subDay(2)->setTime(19, 25, 0),
                'note' => '時間調整の為',
                'request_status_id' => 2,
                'request_time' => Carbon::today()->subDay(1)->setTime(10, 20, 0),
            ],
            [
                'id' => 2,
                'attendance_id' => 3,
                'start' => Carbon::today()->subDays(1)->setTime(10, 10, 0),
                'end' => Carbon::today()->subDays(1)->setTime(20, 35, 0),
                'note' => '休憩記載もれ',
                'request_status_id' => 2,
                'request_time' => Carbon::today()->subDay(1)->setTime(10, 20, 0),
            ],
        ];
        DB::table('attendance_requests')->insert($content);
    }
}