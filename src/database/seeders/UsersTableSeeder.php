<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
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
            'name' => 'test1',
            'email' => 'test1@test',
            'password' => Hash::make('test1test1'),
        ];
        User::create($content);
        $content = [
            'id' => 2,
            'name' => 'test2',
            'email' => 'test2@test',
            'password' => Hash::make('test2test2'),
        ];
        User::create($content);
    }
}
