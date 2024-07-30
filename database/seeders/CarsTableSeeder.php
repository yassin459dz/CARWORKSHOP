<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cars')->insert([
            [
                'client_id' => 1,
                'BRAND' => 'Toyota',
                'MODEL' => 'Corolla',
                'COLOR' => 'White',
                'MAT' => 'XYZ1234',
                'KM' => 50000,
                'REMARK' => 'Well-maintained',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'client_id' => 2,
                'BRAND' => 'Honda',
                'MODEL' => 'Civic',
                'COLOR' => 'Black',
                'MAT' => 'ABC5678',
                'KM' => 30000,
                'REMARK' => 'Like new',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more records as needed
        ]);
    }
}
