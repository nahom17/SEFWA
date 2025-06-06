<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Fixture;
use App\Models\Player;
use App\Models\Standing;

class Club extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'logo'
        ];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function homeMatches()
    {
        return $this->hasMany(Fixture::class, 'home_team_id');
    }

    public function awayMatches()
    {
        return $this->hasMany(Fixture::class, 'away_team_id');
    }

    public function standings()
    {
        return $this->hasOne(Standing::class);
    }

}
