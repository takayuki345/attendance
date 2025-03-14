<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceStatusesTableSeeder extends Seeder
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
                'name' => '勤務外',
            ],
            [
                'id' => 2,
                'name' => '出勤中',
            ],
            [
                'id' => 3,
                'name' => '休憩中',
            ],
            [
                'id' => 4,
                'name' => '退勤済',
            ],
        ];
        DB::table('attendance_statuses')->insert($contents);
    }
}
