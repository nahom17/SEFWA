<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Club;
use App\Models\Player;

class AddClub extends Component
{
    use WithFileUploads;

    public $name;
    public $logo;

    protected $rules = [
        'name' => 'required|string|max:255',
        'logo' => 'nullable|image|max:1024', // Max 1MB
    ];

    public function addClub()
    {
        $this->validate();

        $logoPath = $this->logo ? $this->logo->store('logos', 'public') : null;

        $club = new Club;
        $club->name = $this->name;
            $club->logo = $logoPath;
            $club->save();

        session()->flash('message', 'Club added successfully!');
        $this->reset(['name', 'logo']);
    }

    public function render()
    {
        return view('livewire.clubs', [
            'players' => Player::with('club')->orderBy('club_id')->orderBy('name')->orderBy('number')->get(),
            'clubs' => Club::orderBy('name')->get(),
        ]);
    }
}
