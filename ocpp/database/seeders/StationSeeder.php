<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class StationSeeder extends Seeder
{
    public function run()
    {
        $site = \DB::table('public.sites')->where('name','Main Office Test')->first();
        if(\DB::table('public.stations')->where('name','Station Alpha')->get()->count() == 0 && $site){
            DB::table('public.stations')->insert([
                [
                    'name' => 'Station Alpha',
                    'location' => 'Apartman 1',
                    'site_id' => $site->id,
                    'station_alias'=> md5(time()),
                    'firmware_version' => 'v1.2.3',
                    'address' => '123 Alpha Street, Istanbul',
                    'status' => 1,
                    'last_seen' => Carbon::now()->subDays(1)->toDateString(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Station Beta',
                    'location' => 'Apartman 2',
                    'site_id' => $site->id,
                    'station_alias'=> md5(time()+22),
                    'firmware_version' => 'v1.3.0',
                    'address' => '456 Beta Avenue, Ankara',
                    'status' => 1,
                    'last_seen' => Carbon::now()->subDays(2)->toDateString(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Apartman 3',
                    'location' => 'Izmir',
                    'site_id' => $site->id,
                    'station_alias'=> md5(time()+2),
                    'firmware_version' => null,
                    'address' => '789 Gamma Blvd, Izmir',
                    'status' => 0,
                    'last_seen' => Carbon::now()->subDays(3)->toDateString(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
