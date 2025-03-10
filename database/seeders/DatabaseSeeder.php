<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $ringData = [
            ["size" => "5.0", "gold_price" => 149441.50, "silver_price" => 2137.25],
            ["size" => "5.5", "gold_price" => 151080.75, "silver_price" => 2166.30],
            ["size" => "6.0", "gold_price" => 149047.25, "silver_price" => 2112.35],
            ["size" => "6.5", "gold_price" => 152305.00, "silver_price" => 2199.50],
            ["size" => "7.0", "gold_price" => 153570.75, "silver_price" => 2220.25],
            ["size" => "7.5", "gold_price" => 154836.50, "silver_price" => 2241.00],
            ["size" => "8.0", "gold_price" => 156102.25, "silver_price" => 2261.75],
            ["size" => "8.5", "gold_price" => 157285.00, "silver_price" => 2282.50],
            ["size" => "9.0", "gold_price" => 158550.75, "silver_price" => 2303.25],
            ["size" => "9.5", "gold_price" => 159816.50, "silver_price" => 2324.00],
            ["size" => "10.0", "gold_price" => 161082.25, "silver_price" => 2344.75],
            ["size" => "10.5", "gold_price" => 162348.00, "silver_price" => 2365.50],
            ["size" => "11.0", "gold_price" => 163613.75, "silver_price" => 2386.25],
            ["size" => "11.5", "gold_price" => 164879.50, "silver_price" => 2407.00],
            ["size" => "12.0", "gold_price" => 166145.25, "silver_price" => 2427.75],
        ];

        DB::table('rings')->truncate(); // Clear old data
        DB::table('rings')->insert($ringData);
    }
}
