<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fixture;
use App\Models\Standing;
use App\Models\Club;
use App\Models\Player;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UpdateStandings extends Component
{
    public $fixtures;
    public $completedFixtures;
    public $selectedFixtureId;
    public $homeTeamScore;
    public $awayTeamScore;
    public $homeScores = [];
    public $awayScores = [];
    public $homeAssists = [];
    public $awayAssists = [];
    public $availableHomePlayers = [];
    public $availableAwayPlayers = [];
    public $isEditMode = false;
    public $originalHomeScore;
    public $originalAwayScore;

    public function mount()
    {
        $this->loadFixtures();
        $this->loadCompletedFixtures();
        $this->resetScores();
    }

    public function loadFixtures()
    {
        $this->fixtures = Fixture::with(['homeTeam', 'awayTeam'])
            ->where('is_completed', false) // Show only uncompleted fixtures
            ->orderBy('match_date', 'asc')
            ->get();
    }

    public function loadCompletedFixtures()
    {
        $this->completedFixtures = Fixture::with(['homeTeam', 'awayTeam'])
            ->where('is_completed', true) // Show only completed fixtures
            ->orderBy('match_date', 'desc')
            ->get();
    }

    public function enableEditMode()
    {
        $this->isEditMode = true;
        $this->resetAll();
    }

    public function disableEditMode()
    {
        $this->isEditMode = false;
        $this->resetAll();
    }

    public function editFixture($fixtureId)
    {
        $this->isEditMode = true;
        $this->selectedFixtureId = $fixtureId;
        $this->loadFixtureData();
    }

    public function loadFixtureData()
    {
        $match = Fixture::with(['homeTeam.players', 'awayTeam.players'])->find($this->selectedFixtureId);
        
        if (!$match) {
            session()->flash('error', 'Fixture not found.');
            return;
        }

        // Load teams and scores
        $this->homeTeamScore = $match->home_score;
        $this->awayTeamScore = $match->away_score;
        $this->originalHomeScore = $match->home_score;
        $this->originalAwayScore = $match->away_score;
        
        $this->availableHomePlayers = $match->homeTeam->players;
        $this->availableAwayPlayers = $match->awayTeam->players;
        
        // Reset scorer and assist arrays
        $this->homeScores = [];
        $this->awayScores = [];
        $this->homeAssists = [];
        $this->awayAssists = [];
        
        // Get scorers from database
        // Using direct DB query to avoid relationship issues
        $scorers = DB::table('goal_scorers')
            ->where('fixture_id', $match->id)
            ->get();
            
        // Load existing scorers data
        foreach ($scorers as $scorer) {
            if ($scorer->club_id == $match->home_team_id) {
                if ($scorer->goals > 0) {
                    $this->homeScores[] = [
                        'player_id' => $scorer->player_id,
                        'goals' => $scorer->goals
                    ];
                }
                if ($scorer->assists > 0) {
                    $this->homeAssists[] = [
                        'player_id' => $scorer->player_id,
                        'assists' => $scorer->assists
                    ];
                }
            } else {
                if ($scorer->goals > 0) {
                    $this->awayScores[] = [
                        'player_id' => $scorer->player_id,
                        'goals' => $scorer->goals
                    ];
                }
                if ($scorer->assists > 0) {
                    $this->awayAssists[] = [
                        'player_id' => $scorer->player_id,
                        'assists' => $scorer->assists
                    ];
                }
            }
        }
        
        // Ensure there's at least one empty entry if no data exists
        if (empty($this->homeScores)) {
            $this->homeScores = [['player_id' => '', 'goals' => 0]];
        }
        if (empty($this->awayScores)) {
            $this->awayScores = [['player_id' => '', 'goals' => 0]];
        }
        if (empty($this->homeAssists)) {
            $this->homeAssists = [['player_id' => '', 'assists' => 0]];
        }
        if (empty($this->awayAssists)) {
            $this->awayAssists = [['player_id' => '', 'assists' => 0]];
        }
    }

    public function submitResult()
    {
        $this->validate([
            'homeTeamScore' => 'required|integer|min:0',
            'awayTeamScore' => 'required|integer|min:0',
            'homeScores.*.player_id' => 'required_if:homeTeamScore,>,0|exists:players,id',
            'homeScores.*.goals' => 'required_if:homeTeamScore,>,0|integer|min:1',
            'awayScores.*.player_id' => 'required_if:awayTeamScore,>,0|exists:players,id',
            'awayScores.*.goals' => 'required_if:awayTeamScore,>,0|integer|min:1',
            'homeAssists.*.player_id' => 'nullable|exists:players,id',
            'homeAssists.*.assists' => 'nullable|integer|min:0',
            'awayAssists.*.player_id' => 'nullable|exists:players,id',
            'awayAssists.*.assists' => 'nullable|integer|min:0',
        ]);

        $match = Fixture::find($this->selectedFixtureId);

        if (!$match) {
            session()->flash('error', 'Fixture not found.');
            return;
        }

        DB::beginTransaction();

        try {
            if ($this->isEditMode && $match->is_completed) {
                // If we're in edit mode and the scores have changed, adjust the standings
                if ($this->homeTeamScore != $this->originalHomeScore || $this->awayTeamScore != $this->originalAwayScore) {
                    // Revert previous standings
                    $this->revertStandings($match);
                    
                    // Update match scores
                    $match->update([
                        'home_score' => $this->homeTeamScore,
                        'away_score' => $this->awayTeamScore,
                    ]);
                    
                    // Update standings with new scores
                    $this->updateStandings($match);
                } else {
                    // Just update match scores if they haven't changed
                    $match->update([
                        'home_score' => $this->homeTeamScore,
                        'away_score' => $this->awayTeamScore,
                    ]);
                }
                
                // Update scorers and assists
                $this->saveScorersAndAssists($match);
                
                session()->flash('message', 'Match result and scorers updated successfully!');
            } else {
                // This is a new result submission
                $match->update([
                    'home_score' => $this->homeTeamScore,
                    'away_score' => $this->awayTeamScore,
                    'is_completed' => true,
                ]);

                // Save scorers and assists
                $this->saveScorersAndAssists($match);

                // Update standings
                $this->updateStandings($match);
                
                session()->flash('message', 'Match result and scorers saved successfully!');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'An error occurred: ' . $e->getMessage());
        }

        $this->resetAll();
    }

    private function revertStandings(Fixture $match)
    {
        $homeStanding = Standing::where('club_id', $match->home_team_id)->first();
        $awayStanding = Standing::where('club_id', $match->away_team_id)->first();

        if (!$homeStanding || !$awayStanding) {
            throw new \Exception('Standings records not found');
        }

        // Revert matches played (will be incremented again with updateStandings)
        $homeStanding->decrement('matches_played');
        $awayStanding->decrement('matches_played');

        // Revert previous result
        if ($this->originalHomeScore > $this->originalAwayScore) {
            // Home win case
            $homeStanding->decrement('wins');
            $awayStanding->decrement('losses');
            $homeStanding->decrement('points', 3);
        } elseif ($this->originalHomeScore < $this->originalAwayScore) {
            // Away win case
            $awayStanding->decrement('wins');
            $homeStanding->decrement('losses');
            $awayStanding->decrement('points', 3);
        } else {
            // Draw case
            $homeStanding->decrement('draws');
            $awayStanding->decrement('draws');
            $homeStanding->decrement('points');
            $awayStanding->decrement('points');
        }

        // Revert goal difference
        $homeStanding->decrement('goals_difference', $this->originalHomeScore - $this->originalAwayScore);
        $awayStanding->decrement('goals_difference', $this->originalAwayScore - $this->originalHomeScore);

        $homeStanding->save();
        $awayStanding->save();
    }

    private function saveScorersAndAssists(Fixture $match)
    {
        // Delete all existing scorers for this fixture
        DB::table('goal_scorers')->where('fixture_id', $match->id)->delete();
        
        // Array to hold all new records
        $insertData = [];

        // Process home players with goals
        foreach ($this->homeScores as $scorer) {
            if (!empty($scorer['player_id']) && $scorer['goals'] > 0) {
                $insertData[] = [
                    'fixture_id' => $match->id,
                    'player_id' => $scorer['player_id'],
                    'club_id' => $match->home_team_id,
                    'goals' => $scorer['goals'],
                    'assists' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Process home players with assists
        foreach ($this->homeAssists as $assist) {
            if (!empty($assist['player_id']) && $assist['assists'] > 0) {
                // Check if player already has goals
                $exists = false;
                foreach ($insertData as &$data) {
                    if ($data['player_id'] == $assist['player_id'] && $data['club_id'] == $match->home_team_id) {
                        $data['assists'] = $assist['assists'];
                        $exists = true;
                        break;
                    }
                }
                
                // If player doesn't exist, add a new record
                if (!$exists) {
                    $insertData[] = [
                        'fixture_id' => $match->id,
                        'player_id' => $assist['player_id'],
                        'club_id' => $match->home_team_id,
                        'goals' => 0,
                        'assists' => $assist['assists'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Process away players with goals
        foreach ($this->awayScores as $scorer) {
            if (!empty($scorer['player_id']) && $scorer['goals'] > 0) {
                $insertData[] = [
                    'fixture_id' => $match->id,
                    'player_id' => $scorer['player_id'],
                    'club_id' => $match->away_team_id,
                    'goals' => $scorer['goals'],
                    'assists' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Process away players with assists
        foreach ($this->awayAssists as $assist) {
            if (!empty($assist['player_id']) && $assist['assists'] > 0) {
                // Check if player already has goals
                $exists = false;
                foreach ($insertData as &$data) {
                    if ($data['player_id'] == $assist['player_id'] && $data['club_id'] == $match->away_team_id) {
                        $data['assists'] = $assist['assists'];
                        $exists = true;
                        break;
                    }
                }
                
                // If player doesn't exist, add a new record
                if (!$exists) {
                    $insertData[] = [
                        'fixture_id' => $match->id,
                        'player_id' => $assist['player_id'],
                        'club_id' => $match->away_team_id,
                        'goals' => 0,
                        'assists' => $assist['assists'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Insert all new records at once
        if (!empty($insertData)) {
            DB::table('goal_scorers')->insert($insertData);
        }
    }

    private function updateStandings(Fixture $match)
    {
        $homeStanding = Standing::firstOrCreate(['club_id' => $match->home_team_id]);
        $awayStanding = Standing::firstOrCreate(['club_id' => $match->away_team_id]);

        // Update matches played
        $homeStanding->increment('matches_played');
        $awayStanding->increment('matches_played');

        // Update results
        if ($match->home_score > $match->away_score) {
            $homeStanding->increment('wins');
            $awayStanding->increment('losses');
            $homeStanding->increment('points', 3);
        } elseif ($match->home_score < $match->away_score) {
            $awayStanding->increment('wins');
            $homeStanding->increment('losses');
            $awayStanding->increment('points', 3);
        } else {
            $homeStanding->increment('draws');
            $awayStanding->increment('draws');
            $homeStanding->increment('points');
            $awayStanding->increment('points');
        }

        // Update goal difference
        $homeStanding->increment('goals_difference', $match->home_score - $match->away_score);
        $awayStanding->increment('goals_difference', $match->away_score - $match->home_score);

        $homeStanding->save();
        $awayStanding->save();
    }

    public function updatedSelectedFixtureId($value)
    {
        $this->resetScores();
        $match = Fixture::find($value);

        if ($match) {
            $this->availableHomePlayers = $match->homeTeam->players;
            $this->availableAwayPlayers = $match->awayTeam->players;
            
            if ($this->isEditMode && $match->is_completed) {
                $this->loadFixtureData();
            }
        }
    }

    private function resetScores()
    {
        $this->homeScores = [['player_id' => '', 'goals' => 0]];
        $this->awayScores = [['player_id' => '', 'goals' => 0]];
        $this->homeAssists = [['player_id' => '', 'assists' => 0]];
        $this->awayAssists = [['player_id' => '', 'assists' => 0]];
    }

    private function resetAll()
    {
        $this->reset([
            'homeTeamScore',
            'awayTeamScore',
            'selectedFixtureId',
            'originalHomeScore',
            'originalAwayScore',
        ]);
        $this->resetScores();
        $this->loadFixtures();
        $this->loadCompletedFixtures();
    }
    
    
    public function addHomeScorer()
    {
        $this->homeScores[] = ['player_id' => '', 'goals' => 0];
    }

    public function addAwayScorer()
    {
        $this->awayScores[] = ['player_id' => '', 'goals' => 0];
    }

    public function removeHomeScorer($index)
    {
        unset($this->homeScores[$index]);
        $this->homeScores = array_values($this->homeScores);
    }

    public function removeAwayScorer($index)
    {
        unset($this->awayScores[$index]);
        $this->awayScores = array_values($this->awayScores);
    }

    public function addHomeAssist()
    {
        $this->homeAssists[] = ['player_id' => '', 'assists' => 0];
    }

    public function addAwayAssist()
    {
        $this->awayAssists[] = ['player_id' => '', 'assists' => 0];
    }

    public function removeHomeAssist($index)
    {
        unset($this->homeAssists[$index]);
        $this->homeAssists = array_values($this->homeAssists);
    }

    public function removeAwayAssist($index)
    {
        unset($this->awayAssists[$index]);
        $this->awayAssists = array_values($this->awayAssists);
    }

    /**
     * Get the team name for the selected fixture
     *
     * @param string $type 'home' or 'away'
     * @return string
     */
    public function getTeamName($type)
    {
        if (empty($this->selectedFixtureId)) {
            return '';
        }
        
        $fixture = null;
        
        // First check in uncompleted fixtures
        if (!$this->isEditMode) {
            foreach ($this->fixtures as $fix) {
                if ($fix->id == $this->selectedFixtureId) {
                    $fixture = $fix;
                    break;
                }
            }
        } 
        // Then check in completed fixtures
        else {
            foreach ($this->completedFixtures as $fix) {
                if ($fix->id == $this->selectedFixtureId) {
                    $fixture = $fix;
                    break;
                }
            }
        }
        
        if (!$fixture) {
            return '';
        }
        
        return $type === 'home' ? $fixture->homeTeam->name : $fixture->awayTeam->name;
    }
    
    public function render()
    {
        return view('livewire.update-standings', [
            'fixtures' => $this->fixtures,
            'completedFixtures' => $this->completedFixtures,
            'availableHomePlayers' => $this->availableHomePlayers,
            'availableAwayPlayers' => $this->availableAwayPlayers,
            'homeScores' => $this->homeScores,
            'awayScores' => $this->awayScores,
            'homeAssists' => $this->homeAssists,
            'awayAssists' => $this->awayAssists,
            'isEditMode' => $this->isEditMode
        ]);
    }
}