<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fixture;
use App\Models\Standing;
use Carbon\Carbon;
use App\Models\Player;

class UserController extends Controller
{  /**
     * The top scorers.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    protected $topScorers;

    /**
     * The search term.
     *
     * @var string|null
     */
    protected $search;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $topAssistants;

    public function __construct()
    {
        $this->search = request()->input('search');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $fixtures = Fixture::with(['homeTeam', 'awayTeam'])
            ->orderBy('match_date', 'asc')->get();
            $standings = Standing::with('club')->orderBy('points', 'desc')->get();

            $this->topScorers = Player::with('goals')
            ->get()
            ->sortByDesc(function($player) {
                return $player->goals->sum('pivot.goals');
            })
            ->take(5);

            $topScorers = $this->topScorers;

            $this->topAssistants = Player::with('assists')
            ->get()
            ->sortByDesc(function($player) {
                return $player->assists->sum('pivot.assists');
            })
            ->take(5);
            $topAssistants = $this->topAssistants;

        $players = Player::when($this->search, function($query) {
        $query->where('name', 'like', '%'.$this->search.'%');
    })
    ->with(['club', 'goals', 'assists'])
    ->orderBy('club_id', 'desc')
    ->get();




        return view('user', compact('fixtures', 'standings', 'topScorers', 'players', 'topAssistants'));
    }
}