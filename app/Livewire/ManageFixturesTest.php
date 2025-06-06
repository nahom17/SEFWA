<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination; // Correct namespace for pagination
use Carbon\Carbon;
use App\Models\Club;
use App\Models\Fixture;
use App\Models\Matches;
use Illuminate\Support\Facades\Auth;

class ManageFixturesTest extends Component
{
    use WithPagination;

    public $editFixtureId = null; // For editing a fixture
    public $newMatchDate = null; // Holds the new match date during editing
    public $newStadium = null;

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
            ]);

            $this->editFixtureId = null;
            $this->newMatchDate = null;
            $this->newStadium = null;

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
    // Get current week's Sunday
    $today = Carbon::today();
    $currentSunday = $today->isSunday() 
        ? $today 
        : $today->copy()->next(Carbon::SUNDAY);

    return view('livewire.manage-fixtures-test', [
        'upcomingFixtures' => Fixture::with(['homeTeam', 'awayTeam'])
            ->whereDate('match_date', $currentSunday)
            ->where('is_completed', false)
            ->orderBy('match_date')
            ->get(),
            
        'completedFixtures' => Fixture::with(['homeTeam', 'awayTeam'])
            ->where('is_completed', true)
            ->orderByDesc('match_date')
            ->paginate(10),
            
        'currentSunday' => $currentSunday->format('d-m-Y')
    ]);
}
}
