<?php
namespace App\Livewire;

use App\Models\Club;
use App\Models\Fixture; // Correct namespace for pagination
use Livewire\Component;
use Livewire\WithPagination;

class ManageFixtures extends Component
{
    use WithPagination;

    public $editFixtureId  = null; // For editing a fixture
    public $newMatchDate   = null; // Holds the new match date during editing
    public $newStadium     = null;
    public $newInformation = null;

    public function mount()
    {
        //
    }

    public function startEditing($fixtureId, $currentDate)
    {
        $this->editFixtureId = $fixtureId;
        $this->newMatchDate  = $currentDate;
    }

    public function updateMatchDate()
    {
        $fixture = Fixture::find($this->editFixtureId);

        if ($fixture) {
            $fixture->update([
                'match_date'  => $this->newMatchDate,
                'stadium'     => $this->newStadium,
                'information' => $this->newInformation,
            ]);

            $this->editFixtureId  = null;
            $this->newMatchDate   = null;
            $this->newStadium     = null;
            $this->newInformation = null;

            session()->flash('message', 'Fixture date  and stadium updated successfully!');
        } else {
            session()->flash('error', 'Fixture not found!');
        }
    }

    public function generateFixtures()
    {
        // Clear existing fixtures
        //Fixture::truncate();

        // Get or create teams
        $teams = [
            'dekemhare' => Club::firstOrCreate(['name' => 'Dekemhare']),
            'mendefera' => Club::firstOrCreate(['name' => 'Mendefera']),
            'keren'     => Club::firstOrCreate(['name' => 'Keren']),
            'adi_keyh'  => Club::firstOrCreate(['name' => 'Adi Keyh']),
            'senafe'    => Club::firstOrCreate(['name' => 'Senafe']),
            'segeneyti' => Club::firstOrCreate(['name' => 'Segeneyti']),
            'asmara'    => Club::firstOrCreate(['name' => 'Asmara']),
            'mayani'    => Club::firstOrCreate(['name' => 'Mayani']),
            'barentu'   => Club::firstOrCreate(['name' => 'Barentu']),
            'meraguz'   => Club::firstOrCreate(['name' => 'Meraguz']),
            'adi_quala' => Club::firstOrCreate(['name' => 'Adi Quala']),
        ];

        $fixtures = [
            // Round 1
            ['dekemhare', 'mendefera'],
            ['keren', 'adi_keyh'],
            ['senafe', 'segeneyti'],
            ['asmara', 'mayani'],
            ['barentu', 'meraguz'],
            // Round 2
            ['adi_quala', 'keren'],
            ['segeneyti', 'dekemhare'],
            ['adi_keyh', 'asmara'],
            ['meraguz', 'senafe'],
            ['mayani', 'barentu'],
            // Round 3
            ['mendefera', 'segeneyti'],
            ['asmara', 'adi_quala'],
            ['dekemhare', 'meraguz'],
            ['barentu', 'adi_keyh'],
            ['senafe', 'mayani'],
            // Round 4
            ['keren', 'asmara'],
            ['meraguz', 'mendefera'],
            ['adi_quala', 'barentu'],
            ['mayani', 'dekemhare'],
            ['adi_keyh', 'senafe'],
            // Round 5
            ['segeneyti', 'meraguz'],
            ['barentu', 'keren'],
            ['mendefera', 'mayani'],
            ['senafe', 'adi_quala'],
            ['dekemhare', 'adi_keyh'],
            // Round 6
            ['barentu', 'asmara'],
            ['segeneyti', 'mayani'],
            ['senafe', 'keren'],
            ['mendefera', 'adi_keyh'],
            ['dekemhare', 'adi_quala'],
            // Round 7
            ['mayani', 'meraguz'],
            ['asmara', 'senafe'],
            ['adi_keyh', 'segeneyti'],
            ['keren', 'dekemhare'],
            ['adi_quala', 'mendefera'],
            // Round 8
            ['senafe', 'barentu'],
            ['meraguz', 'adi_keyh'],
            ['dekemhare', 'asmara'],
            ['segeneyti', 'adi_quala'],
            ['mendefera', 'keren'],
            // Round 9
            ['adi_keyh', 'mayani'],
            ['barentu', 'dekemhare'],
            ['adi_quala', 'meraguz'],
            ['asmara', 'mendefera'],
            ['keren', 'segeneyti'],
            // Round 10
            ['dekemhare', 'senafe'],
            ['mayani', 'adi_quala'],
            ['mendefera', 'barentu'],
            ['meraguz', 'keren'],
            ['segeneyti', 'asmara'],
            // Round 11
            ['adi_quala', 'adi_keyh'],
            ['senafe', 'mendefera'],
            ['keren', 'mayani'],
            ['barentu', 'segeneyti'],
            ['asmara', 'meraguz'],
        ];

        $matchDate = now();

        foreach ($fixtures as $index => $fixture) {
            if ($index % 5 == 0) {
                // Add 7 days for each new round
                $matchDate = $matchDate->addDays(14);
            }

            Fixture::create([
                'home_team_id' => $teams[$fixture[0]]->id,
                'away_team_id' => $teams[$fixture[1]]->id,
                'match_date'   => $matchDate,
                'is_completed' => false,
            ]);
        }

        session()->flash('message', 'Fixtures generated successfully!');
    }

    public function render()
    {
        $results = Fixture::where('is_completed', true)
            ->with(['homeTeam', 'awayTeam', 'scorersWithAssists.player', 'assistants.player'])
            ->orderByDesc('match_date')
            ->get();
        $fixtures = Fixture::whereDate('match_date', '2025-03-02')->where('is_completed', false)->orderBy('match_date')->get();

        return view('livewire.manage-fixtures', [
            'results'  => $results,
            'fixtures' => $fixtures,
        ]);
    }
}