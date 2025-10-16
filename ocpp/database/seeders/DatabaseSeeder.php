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
//        \DB::table('public.sites')->insert([
//            [
//                'id' => (string) \Str::uuid(),
//                'name' => 'Main Office',
//                'location' => 'Istanbul',
//                'address' => '123 Main Street, Istanbul, Türkiye',
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'id' => (string) \Str::uuid(),
//                'name' => 'Branch Office',
//                'location' => 'Ankara',
//                'address' => '456 Elm Street, Ankara, Türkiye',
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//        ]);

        for ($i = 1; $i <= 1; $i++) {
            \DB::table('rfid_cards')->insert([
                'id' => (string) \Str::uuid(),
                'user_id' => 6, // varsayılan olarak 1-10 arası user_id
                'uid' => 1000 + $i,
                'site_id' => "9d6a53cd-95d6-4f97-b9fb-781162465cde", // örnek site_id
                'status' => rand(0, 1), // 0: pasif, 1: aktif
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }




        // User::factory(10)->create();
//        User::firstOrCreate(
//            ['email' => 'omer@gmail.com'],
//            [
//                'name' => 'Test User',
//                'password' => Hash::make('password'),
//                'email_verified_at' => now(),
//            ]
//        );
    }
}
