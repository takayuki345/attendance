<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;


class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $content = [
            'name' => 'admin1',
            'email' => 'admin1@admin',
            'password' => Hash::make('admin1admin1'),
        ];
        Admin::create($content);
    }
}
