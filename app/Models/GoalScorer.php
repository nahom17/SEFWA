<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalScorer extends Model
{
    use HasFactory;

    protected $table = 'goal_scorers';

    protected $fillable = [
        'fixture_id',
        'player_id',
        'club_id',
        'goals',
        'assists'
    ];

    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}