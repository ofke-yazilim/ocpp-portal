<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        $site = \DB::table('public.sites')->where('name','Main Office Test')->first();
        if(\DB::table('public.users')->where('name','Admin')->get()->count() == 0 && $site){
            DB::table('public.users')->insert([
                [
                    'username' => 'admin_user',
                    'name' => 'Admin',
                    'surname' => 'User',
                    'email' => 'admin@example.com',
                    'role' => 'admin',
                    'site_id' => $site->id,
                    'apartment_id' => '101',
                    'ip' => '192.168.1.10',
                    'data' => null,
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'remember_token' => Str::random(10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'username' => 'manager_user',
                    'name' => 'Manager',
                    'surname' => 'User',
                    'email' => 'manager@example.com',
                    'role' => 'manager',
                    'site_id' => $site->id,
                    'apartment_id' => '202',
                    'ip' => '192.168.1.11',
                    'data' => null,
                    'email_verified_at' => now(),
                    'password' => Hash::make('password123'),
                    'remember_token' => Str::random(10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'username' => 'driver_user',
                    'name' => 'Driver',
                    'surname' => 'User',
                    'email' => 'driver@example.com',
                    'role' => 'driver',
                    'site_id' => $site->id,
                    'apartment_id' => '303',
                    'ip' => '192.168.1.12',
                    'data' => null,
                    'email_verified_at' => now(),
                    'password' => Hash::make('password123'),
                    'remember_token' => Str::random(10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
