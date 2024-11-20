<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class WatchListPlayer extends Model
{

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'player_id',
        'reason',
        'player_pkg',
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
        $date = \Carbon\Carbon::parse($date);
        $date->locale('id');
        $elapsed = $date->format('d-m-Y H:i:s');
        return $elapsed;
    }

    public function getUpdatedAtAttribute($date) {
        $date = \Carbon\Carbon::parse($date);
        $date->locale('id');
        $elapsed = $date->format('d-m-Y H:i:s');
        return $elapsed;
    }

    protected $casts = [
        'reason' => 'json'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

}
