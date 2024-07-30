<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('clients')->insert([
            ['name' => 'Client 1', 'car_id' => 1, 'sold' => false, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Client 2', 'car_id' => 2, 'sold' => false, 'created_at' => now(), 'updated_at' => now()],
            // Add more clients as needed
        ]);
    }
}
