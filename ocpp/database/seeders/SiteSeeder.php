<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(\DB::table('public.sites')->where('name','Main Office Test')->get()->count() == 0){
            \DB::table('public.sites')->insert([
                [
                    'name' => 'Main Office Test',
                    'location' => 'Istanbul',
                    'address' => '123 Main Street, Istanbul, Türkiye',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Branch Office',
                    'location' => 'Ankara',
                    'address' => '456 Elm Street, Ankara, Türkiye',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
