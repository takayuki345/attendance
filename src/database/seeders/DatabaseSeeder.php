<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(AttendanceStatusesTableSeeder::class);
        $this->call(RequestStatusesTableSeeder::class);
        $this->call(AttendancesTableSeeder::class);
        $this->call(AttendanceBreaksTableSeeder::class);
        $this->call(AttendanceRequestsTableSeeder::class);
        $this->call(AttendanceRequestBreaksTableSeeder::class);
    }
}
