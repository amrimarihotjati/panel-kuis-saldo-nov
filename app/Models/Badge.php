<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Badge extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'badge_name',
        'badge_icon',
        'badge_price',
        'badge_usage',
        'badge_level',
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

    protected $casts = [

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

    public function players()
    {
        return $this->belongsToMany(Player::class);
    }

    public function historyExchangeBadge()
    {
        return $this->belongsToMany(HistoryExchangeBadgePlayer::class);
    }
    
}
