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
            'date' => Carbon::today()->subDays(2),
            'user_id' => 1,
            'start' => Carbon::today()->subDays(2)->setTime(7, 45, 0),
            'end' => Carbon::today()->subDays(2)->setTime(18, 15, 0),
            'note' => null,
            'attendance_status_id' => 4,
            'request_status_id' => 2,
        ];
        Attendance::create($content);
        $content = [
            'id' => 2,
            'date' => Carbon::today()->subDays(1),
            'user_id' => 2,
            'start' => Carbon::today()->subDays(1)->setTime(9, 25, 0),
            'end' => Carbon::today()->subDays(1)->setTime(21, 15, 0),
            'note' => null,
            'attendance_status_id' => 4,
            'request_status_id' => 1,
        ];
        Attendance::create($content);
        $content = [
            'id' => 3,
            'date' => Carbon::today()->subDays(1),
            'user_id' => 3,
            'start' => Carbon::today()->subDays(1)->setTime(10, 10, 0),
            'end' => Carbon::today()->subDays(1)->setTime(20, 35, 0),
            'note' => null,
            'attendance_status_id' => 4,
            'request_status_id' => 2,
        ];
        Attendance::create($content);
    }
}
