<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Player;
use App\Models\Club;
use App\Models\Fixture;

class PlayerCards extends Component
{
    public $search = '';
    public $topScorers = [];
    public $topAssistants = [];

    public function mount()
    {
        $this->topScorers = Player::with('goals')
            ->get()
            ->sortByDesc(function($player) {
                return $player->goals->sum('pivot.goals');
            })
            ->take(10);

            $this->topAssistants = Player::with('assists')
            ->get()
            ->sortByDesc(function($player) {
                return $player->assists->sum('pivot.assists');
            })
            ->take(10);
    }
    public function render()
    {
        $players = Player::when($this->search, function($query) {
                $query->where('name', 'like', '%'.$this->search.'%');
            })
            ->with(['club', 'goals'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.player-cards', [
            'players' => $players,
            'topScorers' => $this->topScorers,
            'topAssistants' => $this->topAssistants,
            
        ]);
    }
}
