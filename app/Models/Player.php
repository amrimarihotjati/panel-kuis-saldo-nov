<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'image_url',
        'points',
        'points_collected',
        'score',
        'referral_code',
        'password',
        'player_pkg',
        'status',
        'real_player',
        'badge_player',
        'badge_primary',
        'device_name',
        'device_id',
        'token',
        'reset_token_password'
    ];

    protected $casts = [
        'badge_player' => 'json',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($player) {
            if (is_null($player->badge_player)) {
                $player->badge_player = ['93ced448-732b-4008-a17f-b8a89a294097'];
            }
        });
    }

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

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'player_id');
    }

    public function completedArticlePoint()
    {
        return $this->hasMany(completedArticlePoint::class, 'player_id');
    }

    public function historyCollectedPoints()
    {
        return $this->hasMany(HistoryCollectedPoint::class, 'player_id');
    }

    public function registeredReferrals()
    {
        return $this->hasMany(RefferalPlayer::class, 'refferaled_registered_player', 'id');
    }

    public function fromReferrals()
    {
        return $this->hasMany(RefferalPlayer::class, 'refferaled_from_player', 'id');
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class);
    }

    public function historyExchangeBadge()
    {
        return $this->hasMany(HistoryExchangeBadgePlayer::class);
    }

    public function watchListPlayer()
    {
        return $this->hasMany(WatchListPlayer::class);
    }

    public function adsCounterTemporarie()
    {
        return $this->hasMany(AdsCounterTemporary::class);
    }

}
