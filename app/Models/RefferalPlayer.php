<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class RefferalPlayer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
       'refferaled_registered_player',
       'refferaled_from_player',
       'refferaled_coins_added_to_player',
       'player_pkg'
    ];

    public function getCreatedAtAttribute($date) {
        $date = \Carbon\Carbon::parse($date)->timezone('Asia/Jakarta');
        $elapsed = $date->diffForHumans();
        return $elapsed;
    }

    public function getUpdatedAtAttribute($date) {
        $date = \Carbon\Carbon::parse($date)->timezone('Asia/Jakarta');
        $elapsed = $date->diffForHumans();
        return $elapsed;
    }

    public function registeredPlayer()
    {
        return $this->belongsTo(Player::class, 'refferaled_registered_player', 'id');
    }

    public function fromPlayer()
    {
        return $this->belongsTo(Player::class, 'refferaled_from_player', 'id');
    }
}
