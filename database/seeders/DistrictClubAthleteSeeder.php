<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DistrictClubAthleteSeeder extends Seeder
{
    public function run(): void
    {
        $districtId = (string) Str::uuid();
        DB::table('districts')->updateOrInsert(
            ['code' => 'AAK'], // eksempel: Agder og Akershus – bytt kode/tekst etter ønske
            ['id' => $districtId, 'name' => 'Agder Friidrettskrets', 'updated_at' => now(), 'created_at' => now()]
        );

        $clubId = (string) Str::uuid();
        DB::table('clubs')->updateOrInsert(
            ['name' => 'Kristiansand IF Friidrett'],
            [
                'id' => $clubId,
                'short_name' => 'KIF',
                'district_id' => $districtId,
                'wa_code' => null,
                'org_no' => null,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        $athleteId = (string) Str::uuid();
        DB::table('athletes')->updateOrInsert(
            ['sports_id' => 'NOR-000001'],
            [
                'id' => $athleteId,
                'first_name' => 'Ola',
                'last_name'  => 'Nordmann',
                'dob'        => '2000-01-15',
                'gender'     => 'M',
                'club_id'    => $clubId,
                'nationality'=> 'NOR',
                'status'     => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
