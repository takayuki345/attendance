<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            [
                'attendance_request_id' => 1,
                'break_start' => Carbon::today()->subDay(2)->setTime(12, 31, 0),
                'break_end' => Carbon::today()->subDay(2)->setTime(13, 28, 0),
            ],
            [
                'attendance_request_id' => 2,
                'break_start' => Carbon::today()->subDay(1)->setTime(12, 0, 0),
                'break_end' => Carbon::today()->subDay(1)->setTime(13, 0, 0),
            ],
        ];
        DB::table('attendance_request_breaks')->insert($content);
    }
}
