<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Karlygash Ussen',
                'email' => 'usenkarlygash@gmail.com',
                'phone' => '+77053500089',
                'address' => 'Almaty, Kazakhstan',
                'password' => Hash::make('12345678'),
            ],
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'phone' => '+77051234567',
                'address' => 'Almaty, Kazakhstan',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'phone' => '+77059876543',
                'address' => 'Almaty, Kazakhstan',
                'password' => Hash::make('password456'),
            ],
            [
                'name' => 'Aliya Kenzhebek',
                'email' => 'aliya.kenzhebek@example.com',
                'phone' => '+77057654321',
                'address' => 'Astana, Kazakhstan',
                'password' => Hash::make('password789'),
            ],
        ]);
    }    
}
