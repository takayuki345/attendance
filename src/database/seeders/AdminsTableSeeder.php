<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'id' => 1,
            'name' => 'admin1',
            'email' => 'admin1@admin',
            'password' => Hash::make('admin1admin1'),
        ];
        Admin::create($content);
    }
}
