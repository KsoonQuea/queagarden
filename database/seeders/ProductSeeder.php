<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("products")->insert([
            [
                'name'              => "Guava Lohan",
                'type'              => 0,
                'grade_list'        => "A, B"
            ], [
                'name'              => "Papaya",
                'type'              => 0,
                'grade_list'        => "A, B"
            ], [
                'name'              => "Green Tangerine",
                'type'              => 0,
                'grade_list'        => "A, B, C"
            ]
        ] );
    }
}
