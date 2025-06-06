<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Standing;

class ManageStandings extends Component
{
    public function render()
    {
        return view('livewire.manage-standings',[
            'standings' => Standing::with('club')
                ->orderBy('points', 'desc')
                ->orderBy('goals_difference','desc')
                ->orderBy('club_id', 'asc')
                ->get(),
        ]);
    }
}
