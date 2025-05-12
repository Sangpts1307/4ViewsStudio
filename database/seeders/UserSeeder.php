<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 2; $i <= 10; $i++) {
            DB::table('users')->insert([
                'name' => "user" . $i,
                'email' => 'user' .$i . '@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 2
            ]);
        }
        for ($i = 11; $i <= 40; $i++) {
            DB::table('users')->insert([
                'name' => "staff" . $i,
                'email' => 'user' .$i . '@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 1
            ]);
        } 
        for ($i = 41; $i <= 100; $i++) {
            DB::table('users')->insert([
                'name' => "staff" . $i,
                'email' => 'user' .$i . '@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 0
            ]);
        } 
    }
}
