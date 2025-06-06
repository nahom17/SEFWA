<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination; // Correct namespace for pagination
use Carbon\Carbon;
use App\Models\Club;
use App\Models\Fixture;
use App\Models\Matches;
use Illuminate\Support\Facades\Auth;

class ManageFixtures extends Component
{
    use WithPagination;

    public $editFixtureId = null; // For editing a fixture
    public $newMatchDate = null; // Holds the new match date during editing
    public $newStadium = null;
    public $newInformation = null;

    public function mount()
    {
        //
    }

    public function startEditing($fixtureId, $currentDate)
    {
        $this->editFixtureId = $fixtureId;
        $this->newMatchDate = $currentDate;
    }

    public function updateMatchDate()
    {
        $fixture = Fixture::find($this->editFixtureId);

        if ($fixture) {
            $fixture->update([
                'match_date' => $this->newMatchDate,
                'stadium' => $this->newStadium,
                'information' => $this->newInformation,
            ]);

            $this->editFixtureId = null;
            $this->newMatchDate = null;
            $this->newStadium = null;
            $this->newInformation= null;

            session()->flash('message', 'Fixture date  and stadium updated successfully!');
        } else {
            session()->flash('error', 'Fixture not found!');
        }
    }

    public function generateFixtures()
    {
        // Check if the system has exactly 12 teams
        $teams = Club::count();
        if ($teams !== 12) {
            session()->flash('error', 'This system is designed for exactly 12 teams.');
            return;
        }
        // Generate fixtures
        $teams = Club::all();
        $teamIds = $teams->pluck('id')->toArray();
        $teamCount = count($teamIds);

        if ($teamCount !== 12) {
            session()->flash('error', 'This system is designed for exactly 12 teams.');
            return;
        }

        $now = now();

        // Generate single round-robin fixtures
        for ($i = 0; $i < $teamCount - 1; $i++) {
            for ($j = $i + 1; $j < $teamCount; $j++) {
                $homeTeamId = $teamIds[$i];
                $awayTeamId = $teamIds[$j];

                $matchDate = $now->addDays(rand(1, 5)); // Random date within 30 days

                Fixture::create([
                    'home_team_id' => $homeTeamId,
                    'away_team_id' => $awayTeamId,
                    'match_date' => $matchDate,
                ]);


            }
        }

        session()->flash('message', '66 fixtures generated successfully!');
    }

   public function render()
{
    $results = Fixture::where('is_completed', true)
        ->with(['homeTeam', 'awayTeam', 'scorersWithAssists.player', 'assistants.player'])
        ->orderByDesc('match_date')
        ->get();
    $fixtures = Fixture::whereDate('match_date', '2025-03-02')->where('is_completed', false)->orderBy('match_date')->get();

    return view('livewire.manage-fixtures', [
        'results' => $results,
        'fixtures' => $fixtures,
    ]);
}
}
