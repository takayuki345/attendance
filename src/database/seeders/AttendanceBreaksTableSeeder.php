<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceBreaksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contents = [
            [
                'attendance_id' => 1,
                'break_start' => Carbon::today()->subDay(2)->setTime(11, 58, 0),
                'break_end' => Carbon::today()->subDay(2)->setTime(12, 52, 0),
            ],
            [
                'attendance_id' => 1,
                'break_start' => Carbon::today()->subDay(2)->setTime(14, 34, 0),
                'break_end' => Carbon::today()->subDay(2)->setTime(16, 10, 0),
            ],
            [
                'attendance_id' => 2,
                'break_start' => Carbon::today()->subDay(1)->setTime(12, 5, 0),
                'break_end' => Carbon::today()->subDay(1)->setTime(12, 58, 0),
            ],
        ];
        DB::table('attendance_breaks')->insert($contents);
    }
}
