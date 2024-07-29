<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class BranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // prepare data to be seeded to the database
        DB::table('branches')->insert([
            ['name' => 'ABB', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'CAL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'CLV', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'CPL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'CSD', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'HIG', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'HVY', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'IDY', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'JPL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'LHL', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'LON', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'MEA', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'MCN', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'MLW', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'MNA', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'RIV', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'SPW', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'STR', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'WHP', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'WMC', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'WOO', 'created_at' => now(), 'updated_at' => now()],
        ]);
        
    }
}
