<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create();

        // Define phone prefixes and cities
        $phonePrefixes = ['055', '066', '077'];
        $cities = ['Alger', 'Paris', 'London', 'New York', 'Dubai', 'Cairo'];
        $remarks = ['Good client', 'Doesn\'t want to stay long time', 'Frequent visitor', 'Prefers quick service', 'Loyal customer'];

        // Create a set to track unique phone numbers
        $phoneNumbers = [];

        // Insert 10 dummy client records
        for ($i = 0; $i < 10; $i++) {
            // Generate unique phone numbers
            do {
                $phone = $phonePrefixes[array_rand($phonePrefixes)] . rand(1000000, 9999999);
            } while (in_array($phone, $phoneNumbers));

            // Store the unique phone number
            $phoneNumbers[] = $phone;

            // Generate a unique secondary phone number
            do {
                $phone2 = $phonePrefixes[array_rand($phonePrefixes)] . rand(1000000, 9999999);
            } while (in_array($phone2, $phoneNumbers) || $phone2 === $phone);

            // Store the unique secondary phone number
            $phoneNumbers[] = $phone2;

            // Insert data into the database
            DB::table('clients')->insert([
                'name' => $faker->name(),
                'phone' => $phone,
                'phone2' => $phone2,
                'address' => $cities[array_rand($cities)],
                'remark' => $remarks[array_rand($remarks)],
                'sold' => rand(0, 2500000) / 100,  // Generates a value between 0.00 and 25000.00
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
