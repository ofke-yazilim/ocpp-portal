<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SiteSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RfidCardSeeder::class);
        $this->call(StationSeeder::class);
    }
}
