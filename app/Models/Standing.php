<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Club;

class Standing extends Model
{
    use HasFactory;
    protected $fillable = [
        'team_id',
        'matches_played',
        'wins',
        'draws',
        'losses',
        'points',
        'goal_difference',
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
