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
                'id' => 1,
                'attendance_id' => 1,
                'break_start' => Carbon::today()->subDay(2)->setTime(11, 58, 25),
                'break_end' => Carbon::today()->subDay(2)->setTime(12, 52, 55),
            ],
            [
                'id' => 2,
                'attendance_id' => 1,
                'break_start' => Carbon::today()->subDay(2)->setTime(14, 34, 56),
                'break_end' => Carbon::today()->subDay(2)->setTime(16, 10, 20),
            ],
        ];
        DB::table('attendance_breaks')->insert($contents);
    }
}
