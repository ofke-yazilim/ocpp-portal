<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RfidCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $site = \DB::table('public.sites')->where('name','Main Office Test')->first();
        if(\DB::table('public.users')->where('name','Admin')->get()->count() > 0 && $site){
            for ($i = 1; $i <= 3; $i++) {
                $result = \DB::table('public.rfid_cards')->insert([
                    'user_id' => $i, // varsayılan olarak 1-10 arası user_id
                    'uid' => (string) \Str::uuid(),
                    'site_id' => $site->id, // örnek site_id
                    'status' => 1, // 0: pasif, 1: aktif
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
