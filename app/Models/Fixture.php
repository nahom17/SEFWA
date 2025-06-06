<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'match_date',
        'home_score',
        'away_score',
        'is_completed',
        'stadium',
        'information',

    ];
    
    
    protected $dates = [
    'match_date',
    'created_at',
    'updated_at'
];

// OR for Laravel 7.15+ use casting:
protected $casts = [
    'match_date' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime'
];

    public function homeTeam()
    {
    return $this->belongsTo(Club::class, 'home_team_id');
    }

    public function awayTeam()
    {
    return $this->belongsTo(Club::class, 'away_team_id');
    }
   

   public function scorers()
    {
        return $this->belongsToMany(Player::class, 'goal_scorers', 'fixture_id', 'player_id')
                    ->withPivot('goals', 'assists', 'club_id')
                    ->withTimestamps();
    }
    
    public function goalScorers()
{
    return $this->hasMany(GoalScorer::class);
}

public function scorersWithAssists()
{
    return $this->hasMany(GoalScorer::class)
                ->where('goals', '>', 0)
                ->with('player');
}

public function assistants()
{
    return $this->hasMany(GoalScorer::class)
                ->where('assists', '>', 0)
                ->with('player');
}

}

