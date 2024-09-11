<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Sample products data
        $users = [
            ['name' => 'Super Admin', 'email' => 'admin@test.com', 'password' =>  Hash::make(123123)],
        ];
        DB::table('users')->insert($users);
    }
}
