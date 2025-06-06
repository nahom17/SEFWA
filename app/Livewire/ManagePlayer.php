<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Player;
use App\Models\Club;
use Livewire\WithFileUploads;

class ManagePlayer extends Component
{
    use WithFileUploads;
    
    public $name, $number, $selectedClub, $position, $photo, $photoPath;
    public $playerId, $showEditModal = false; // Variables for editing

    public function addPlayer()
    {
        $this->validate([
            'selectedClub' => 'required|integer',
            'name' => 'required|string|max:255',
            'number' => 'required',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $photoPath = $this->photo ? $this->photo->store('photos', 'public') : null;

        Player::create([
            'club_id' => $this->selectedClub,
            'name' => $this->name,
            'number' => $this->number,
            'position' => $this->position,
            'photo' => $photoPath,
        ]);

        $this->resetFields();
        session()->flash('message', 'Player added successfully!');
    }

   public function editPlayer($id)
{
    $player = Player::find($id);
    if ($player) {
        $this->playerId = $player->id;
        $this->selectedClub = $player->club_id;
        $this->name = $player->name;
        $this->number = $player->number;
        $this->position = $player->position;
        $this->photoPath = $player->photo; // Store existing photo path
         $this->showEditModal = true;

        $this->editMode = true;
        
       $this->dispatch('openEditModal');
    }
}

public function updatePlayer()
{
    $this->validate([
        'selectedClub' => 'required|integer',
        'name' => 'required|string|max:255',
        'number' => 'required',
        'position' => 'required|string|max:255',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $player = Player::find($this->playerId);
    if ($player) {
        if ($this->photo) {
            $photoPath = $this->photo->store('photos', 'public'); // Upload new photo
            $player->photo = $photoPath;
        }

        $player->update([
            'club_id' => $this->selectedClub,
            'name' => $this->name,
            'number' => $this->number,
            'position' => $this->position,
        ]);

        $this->resetFields();
        $this->showEditModal = false;
        session()->flash('message', 'Player updated successfully!');
        
    }
}

 public function closeEditModal()
    {
        $this->showEditModal = false; // Manual close method
        $this->resetFields();
    }
    
    public function updatedShowEditModal($value)
{
    if (!$value) $this->resetFields();
}


    public function deletePlayer($id)
    {
        $player = Player::find($id);
        if ($player) {
            $player->delete();
            session()->flash('message', 'Player deleted successfully!');
        }
    }

    private function resetFields()
    {
        $this->reset(['name', 'number', 'position', 'photo', 'playerId', 'showEditModal']);
    }

    public function render()
    {
        return view('livewire.manage-player', [
            'players' => Player::with('club')->orderBy('club_id')->orderBy('name')->orderBy('number')->get(),
            'clubs' => Club::orderBy('name')->get(),
        ]);
    }
}
