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
            'start' => Carbon::today()->subDays(2)->setTime(7, 45, 30),
            'end' => Carbon::today()->subDays(2)->setTime(18, 15, 10),
            'note' => '備考',
            'attendance_status_id' => 1,
            'request_status_id' => 1,
        ];
        Attendance::create($content);
    }
}
