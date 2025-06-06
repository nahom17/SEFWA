<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fixture;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    public function index()
    {
        $fixtures = Fixture::with(['homeTeam', 'awayTeam'])
            ->orderBy('match_date', 'asc')
            ->get();

        return response()->json($fixtures);
    }

    public function upcoming()
    {
        $fixtures = Fixture::with(['homeTeam', 'awayTeam'])
            ->where('is_completed', false)
            ->orderBy('match_date', 'asc')
            ->get();

        return response()->json($fixtures);
    }

    public function completed()
    {
        $fixtures = Fixture::with(['homeTeam', 'awayTeam'])
            ->where('is_completed', true)
            ->orderBy('match_date', 'desc')
            ->get();

        return response()->json($fixtures);
    }

    public function update(Request $request, Fixture $fixture)
    {
        $validated = $request->validate([
            'match_date' => 'required|date',
            'stadium' => 'required|string',
        ]);

        $fixture->update($validated);

        return response()->json($fixture->load(['homeTeam', 'awayTeam']));
    }
}
