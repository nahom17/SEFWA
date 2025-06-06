<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_id',
        'name',
        'position',
        'photo'
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function getTotalGoalsAttribute()
    {
        return $this->goals->sum('pivot.goals');
    }

    public function getTotalAssistsAttribute()
    {
        return $this->assists->sum('pivot.assists');
    }

    public function goals()
    {
        return $this->belongsToMany(Fixture::class, 'goal_scorers')
            ->withPivot('goals', 'club_id')
            ->withTimestamps();
    }

    public function assists()
    {
        return $this->belongsToMany(Fixture::class, 'goal_scorers')
            ->withPivot('assists', 'club_id')
            ->withTimestamps();
    }
}
