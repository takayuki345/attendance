<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestStatusesTableSeeder extends Seeder
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
                'name' => 'なし',
            ],
            [
                'id' => 2,
                'name' => '承認前',
            ],
            [
                'id' => 3,
                'name' => '承認済み',
            ],
        ];
        DB::table('request_statuses')->insert($contents);
    }
}
