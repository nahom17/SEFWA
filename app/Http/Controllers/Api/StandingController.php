<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Standing;
use Illuminate\Http\Request;

class StandingController extends Controller
{
    public function index()
    {
        $standings = Standing::with('club')
            ->orderBy('points', 'desc')
            ->orderBy('goals_difference', 'desc')
            ->get()
            ->map(function ($standing, $index) {
                return [
                    'id' => $standing->id,
                    'position' => $index + 1,
                    'club' => [
                        'id' => $standing->club->id,
                        'name' => $standing->club->name,
                        'logo' => $standing->club->logo
                    ],
                    'matches_played' => $standing->matches_played,
                    'wins' => $standing->wins,
                    'draws' => $standing->draws,
                    'losses' => $standing->losses,
                    'goals_difference' => $standing->goals_difference,
                    'points' => $standing->points
                ];
            });

        return response()->json($standings);
    }
}