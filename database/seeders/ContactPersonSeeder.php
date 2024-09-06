<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactPersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("contact_person")->insert([
            'name'              => "Ya Mu",
            'email'             => "tianmei@hotmail.com",
            'phone'             => "1234567890",
            'role'              => 0,
            'distributor_id'    => 1
        ]);
    }
}
