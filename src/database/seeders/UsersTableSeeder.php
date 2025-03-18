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
        $content = [
            'id' => 3,
            'name' => 'test3',
            'email' => 'test3@test',
            'password' => Hash::make('test3test3'),
        ];
        User::create($content);
        $content = [
            'id' => 4,
            'name' => 'test4',
            'email' => 'test4@test',
            'password' => Hash::make('test4test4'),
        ];
        User::create($content);
        $content = [
            'id' => 5,
            'name' => 'test5',
            'email' => 'test5@test',
            'password' => Hash::make('test5test5'),
        ];
        User::create($content);
    }
}
