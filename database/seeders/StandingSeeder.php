<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Club;
use App\Models\Standing;

class StandingSeeder extends Seeder
{
    public function run()
    {
        $clubs = Club::all();

        foreach ($clubs as $club) {
            Standing::create([
                'club_id' => $club->id,
                'matches_played' => 0,
                'wins' => 0,
                'losses' => 0,
                'draws' => 0,
                'points' => 0,
                'goals_difference' => 0,
            ]);
        }
    }
}
