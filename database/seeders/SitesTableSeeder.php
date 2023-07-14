<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sites = [
            [
                'id' => 'AAAAA00000',
                'name' => 'Pasig site',
                'address' => 'San Isidro, Makati City',
                'site_manager_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 'BBBBB11111',
                'name' => 'Makati site',
                'address' => 'Bambang, Pasig City',
                'site_manager_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'id' => 'CCCCC22222',
                'name' => 'Bataan site',
                'address' => 'Bagac, Bataan',
                'site_manager_id' => 2,
                'created_at' => Carbon::now(),
            ],
        ];

        DB::table('sites')->insert($sites);
    }
}
