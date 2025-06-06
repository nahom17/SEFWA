<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    public function index()
    {
        $players = Player::with(['club'])
            ->get();
        return response()->json($players);
    }

    public function topScorers()
    {
        $players = Player::with(['club'])
            ->select('players.*')
            ->addSelect(DB::raw('(
                SELECT COALESCE(SUM(gs.goals), 0)
                FROM goal_scorers gs
                WHERE gs.player_id = players.id
            ) as total_goals'))
            ->orderByDesc('total_goals')
            ->take(5)
            ->get()
            ->map(function ($player) {
                return [
                    'id' => $player->id,
                    'name' => $player->name,
                    'number' => $player->number,
                    'position' => $player->position,
                    'photo' => $player->photo,
                    'club' => $player->club,
                    'total_goals' => (int) $player->total_goals
                ];
            });

        return response()->json($players);
    }

    public function topAssists()
    {
        $players = Player::with(['club'])
            ->select('players.*')
            ->addSelect(DB::raw('(
                SELECT COALESCE(SUM(gs.assists), 0)
                FROM goal_scorers gs
                WHERE gs.player_id = players.id
            ) as total_assists'))
            ->orderByDesc('total_assists')
            ->take(5)
            ->get()
            ->map(function ($player) {
                return [
                    'id' => $player->id,
                    'name' => $player->name,
                    'number' => $player->number,
                    'position' => $player->position,
                    'photo' => $player->photo,
                    'club' => $player->club,
                    'total_assists' => (int) $player->total_assists
                ];
            });

        return response()->json($players);
    }
}