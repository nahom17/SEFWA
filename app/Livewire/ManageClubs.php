<?php
namespace App\Livewire;

use App\Models\Club;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageClubs extends Component
{
    use WithFileUploads;

    public $name;
    public $logo;
    public $clubs;
    public $editingClub = null;

    public function mount()
    {
        $this->loadClubs();
    }

    public function loadClubs()
    {
        $this->clubs = Club::all();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:2',
            'logo' => 'nullable|image|max:1024',
        ]);

        if ($this->editingClub) {
            $club       = Club::find($this->editingClub);
            $club->name = $this->name;
        } else {
            $club       = new Club();
            $club->name = $this->name;
        }

        if ($this->logo) {
            $club->logo = $this->logo->store('logos', 'public');
        }

        $club->save();

        $this->reset(['name', 'logo', 'editingClub']);
        $this->loadClubs();
    }

    public function edit($id)
    {
        $club              = Club::find($id);
        $this->editingClub = $id;
        $this->name        = $club->name;
    }

    public function delete($id)
    {
        Club::destroy($id);
        $this->loadClubs();
    }

    public function render()
    {
        return view('livewire.manage-clubs');
    }
}
