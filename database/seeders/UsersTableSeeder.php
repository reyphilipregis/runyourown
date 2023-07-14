<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'id' => 1,
                'name' => 'Michael Jordan',
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Kobe Bryant',
                'created_at' => Carbon::now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
