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
            'id' => 1,
            'attendance_id' => 1,
            'start' => Carbon::today()->subDay(2)->setTime(9, 45, 11),
            'end' => Carbon::today()->subDay(2)->setTime(19, 25, 37),
            'note' => '時間調整の為',
            'request_status_id' => 1,
            'request_time' => Carbon::today()->subDay(1)->setTime(10, 20, 30),
        ];
        DB::table('attendance_requests')->insert($content);
    }
}
