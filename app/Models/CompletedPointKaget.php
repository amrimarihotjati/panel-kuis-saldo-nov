<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

use \Carbon\Carbon;

class CompletedPointKaget extends Model
{
    use HasFactory;

    protected $fillable = [
        'rewardsadpoint_id',
        'player_id',
        'task_count',
        'bonus_points',
        'is_claimmed',
        'ads_watched_inters_is_exist',
        'ads_watched_rewards_is_exist',
        'player_pkg'
    ];

    protected static function boot() {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    public function count()
    {
        return count($this->items);
    }

    public function getCreatedAtAttribute($date) {
        $date = Carbon::parse($date)->timezone('Asia/Jakarta');
        $date->locale('id');
        $elapsed = $date->format('d-m-Y H:i:s');
        return $elapsed;
    }

    public function getUpdatedAtAttribute($date) {
        $date = Carbon::parse($date)->timezone('Asia/Jakarta');
        $date->locale('id');
        $elapsed = $date->format('d-m-Y H:i:s');
        return $elapsed;
    }

    public function rewardsAdPoints()
    {
        return $this->belongsTo(RewardsAdPoints::class, 'rewardsadpoint_id');
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
