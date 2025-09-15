<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DisciplineSeeder extends Seeder
{
    public function run(): void
    {
        // Minimal katalog – utvides etter behov
        $rows = [
            ['code' => '100m', 'name' => '100 meter', 'type' => 'track', 'unit' => 's',  'has_wind' => true,  'is_relay' => false, 'default_implement' => null],
            ['code' => '200m', 'name' => '200 meter', 'type' => 'track', 'unit' => 's',  'has_wind' => true,  'is_relay' => false, 'default_implement' => null],
            ['code' => '1500m','name' => '1500 meter','type' => 'track','unit' => 's',  'has_wind' => false, 'is_relay' => false, 'default_implement' => null],
            ['code' => 'LJ',  'name' => 'Lengde',    'type' => 'field', 'unit' => 'm',  'has_wind' => true,  'is_relay' => false, 'default_implement' => null],
            ['code' => 'SP',  'name' => 'Kule',      'type' => 'field', 'unit' => 'm',  'has_wind' => false, 'is_relay' => false, 'default_implement' => '7.26kg'],
            ['code' => '10K', 'name' => '10 km',     'type' => 'road',  'unit' => 'km', 'has_wind' => false, 'is_relay' => false, 'default_implement' => null],
            ['code' => 'MAR', 'name' => 'Maraton',   'type' => 'road',  'unit' => 'km', 'has_wind' => false, 'is_relay' => false, 'default_implement' => null],
        ];

        foreach ($rows as $r) {
            DB::table('disciplines')->updateOrInsert(['code' => $r['code']], $r + ['created_at' => now(), 'updated_at' => now()]);
        }
    }
}
