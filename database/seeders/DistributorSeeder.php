<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("distributors")->insert([
            'company_name'      => "Tian Mei",
            'company_email'     => "tianmei@hotmail.com",
            'company_phone'     => "1234567890",
            'address'           => "long long address"
        ]);
    }
}
