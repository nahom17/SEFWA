<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Club;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Services\FileScanner;

class Clubs extends Component
{
    use WithFileUploads;

    public $name;
    public $logo;
    public $editClubId;
    public $editName;
    public $editLogo;
    public $editLogoPath;

    protected $rules = [
        'name' => 'required|string|max:255',
        'logo' => 'nullable|image|max:2048',
        'editName' => 'required|string|max:255',
        'editLogo' => 'nullable|image|max:2048',
    ];

    public function addClub()
    {
        $this->validate([
            'name' => 'required',
            'logo' => 'nullable|image|max:2048',
        ]);
        
        
        // Sanitize filename
    $originalName = pathinfo($this->logo->getClientOriginalName(), PATHINFO_FILENAME);
    $sanitizedName = Str::slug($originalName);
    $extension = $this->logo->getClientOriginalExtension();
    $filename = $sanitizedName.'-'.uniqid().'.'.$extension;
    

        $logoPath = $this->logo->storeAs('logos', $filename, 'public');

        Club::create([
            'name' => $this->name,
            'logo' => $logoPath,
        ]);

        $this->reset(['name', 'logo']);
        session()->flash('message', 'ጋንታ ብዓቅቡ ተፈጢሩ!');
    }

    public function editClub($id)
{
    $club = Club::findOrFail($id);
    $this->editClubId = $club->id;
    $this->editName = $club->name;
    $this->editLogoPath = $club->logo;  // Make sure this is set correctly
}

   public function updateClub()
{
    $this->validate([
        'editName' => 'required',
        'editLogo' => 'nullable|image|max:2048',
    ]);

    $club = Club::findOrFail($this->editClubId);  // Correct variable name

    if ($this->editLogo) {
        // File scanning logic
        if ($club->logo) {
            Storage::disk('public')->delete($club->logo);
        }
        $club->logo = $this->editLogo->store('logos', 'public');
    }

    $club->name = $this->editName;
    $club->save();  // Changed from $this->club to $club

    $this->resetEditFields();
    session()->flash('message', 'Club updated successfully!');
}

    private function resetEditFields()
    {
        $this->reset(['editClubId', 'editName', 'editLogo', 'editLogoPath']);
    }

    public function deleteClub($id)
    {
        $club = Club::findOrFail($id);
        if ($club->logo) {
            Storage::disk('public')->delete($club->logo);
        }
        $club->delete();
    }

    public function render()
    {
        return view('livewire.clubs', [
            'clubs' => Club::all()
        ]);
    }
}