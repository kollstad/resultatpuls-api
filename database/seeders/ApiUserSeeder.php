<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'admin@friidrett.local'],
            [
                'name' => 'API Admin',
                'password' => Hash::make('secret123'), // bytt til noe sikkert
            ]
        );

        // Utsted et Personal Access Token
        $token = $user->createToken('default', ['districts:write','clubs:write','athletes:write','events:write','performances:write']);

        // Print til konsoll
        $this->command->info("API-token for {$user->email}:");
        $this->command->line($token->plainTextToken);
    }
}
