<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contacts')->insert([
            [
                'user_id' => '1',
                'contact_id' => '2',
                'nickname' => 'JohnZhan'
            ],
            [
                'user_id' => '1',
                'contact_id' => '3',
                'nickname' => 'America Aga'

            ],
        ]);
    }
}
