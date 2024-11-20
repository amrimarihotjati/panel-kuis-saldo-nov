<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class HistoryCollectedPoint extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'player_id',
        'point_collected_from',
        'point_collected_value',
        'description',
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

    public function getCreatedAtAttribute($date) {
        $date = \Carbon\Carbon::parse($date)->timezone('Asia/Jakarta');
        $elapsed = $date->toDayDateTimeString();
        return $elapsed;
    }
    
    public function getUpdatedAtAttribute($date) {
        $date = \Carbon\Carbon::parse($date)->timezone('Asia/Jakarta');
        $elapsed = $date->toDayDateTimeString();
        return $elapsed;
    }

    public function count()
    {
        return count($this->items);
    }

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

}
