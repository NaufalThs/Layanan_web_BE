<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'naufal@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '1234567890',
            'address' => 'albalad'
        ]);
    }
}
