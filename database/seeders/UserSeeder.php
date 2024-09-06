<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = fake();

        DB::table("users")->insert([
            'name'      => "Admin 001",
            'email'     => "admin1@admin.com",
            'password'  => bcrypt('password'),
        ]);

        for ($i = 0; $i < 5; $i++) {
            DB::table('users')->insert([
                'name'      => $faker->name,
                'email'     => $faker->unique()->safeEmail,
                'password'  => bcrypt('password'),
            ]);
        }

    }
}
