<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventAndPerformanceSeeder extends Seeder
{
    public function run(): void
    {
        // Hent id-er vi lagde i forrige seeder
        $club    = DB::table('clubs')->where('short_name', 'KIF')->first();
        $athlete = DB::table('athletes')->where('sports_id', 'NOR-000001')->first();
        $disc    = DB::table('disciplines')->where('code', '100m')->first();

        if (!$club || !$athlete || !$disc) {
            $this->command->warn('Avhengigheter mangler. Kjør DistrictClubAthleteSeeder og DisciplineSeeder først.');
            return;
        }

        // Lag et stevne
        $eventId = (string) Str::uuid();
        DB::table('events')->insert([
            'id'             => $eventId,
            'name'           => 'Sommerstevnet Kristiansand',
            'type'           => 'outdoor',
            'start_date'     => now()->toDateString(),
            'end_date'       => now()->toDateString(),
            'city'           => 'Kristiansand',
            'venue'          => 'Kristiansand stadion',
            'sanction_level' => 'Regional',
            'course_cert'    => null,
            'elevation_gain' => null,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        // Knytt disiplin til stevnet
        $edId = (string) Str::uuid();
        DB::table('event_disciplines')->insert([
            'id'               => $edId,
            'event_id'         => $eventId,
            'discipline_code'  => $disc->code,
            'age_category'     => 'Senior',
            'round'            => 'finale',
            'timing_method'    => 'auto',
            'implement_weight' => null,
            'is_team_scored'   => false,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        // Registrer et resultat (10.87 på 100m, lovlig)
        $versionGroupId = (string) Str::uuid();
        DB::table('performances')->insert([
            'id'                  => (string) Str::uuid(),
            'event_discipline_id' => $edId,
            'athlete_id'          => $athlete->id,
            'relay_team_id'       => null,
            'mark_raw'            => 10870,                 // ms (10.87s)
            'mark_display'        => '10.87',
            'unit'                => 's',
            'position'            => 1,
            'wind'                => 0.8,
            'status'              => 'OK',
            'is_legal'            => true,
            'splits_json'         => json_encode(null),
            'device_meta_json'    => json_encode(['timing' => 'FAT']),
            'version_group_id'    => $versionGroupId,
            'is_current'          => true,
            'submitted_by'        => null,
            'submitted_at'        => now(),
            'signature_id'        => null,
            'hash'                => null,
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);
    }
}
