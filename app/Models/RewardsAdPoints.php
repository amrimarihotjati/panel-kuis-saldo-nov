<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class RewardsAdPoints extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'status',
        'time_claimed',
        'claimed',
        'point_value',
        'point_number',
        'watch_ads_value',
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
        'claimed' => 'json'
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

     public function historyCollectedRewardsAdPoints()
    {
        return $this->hasMany(HistoryCollectedRewardsAdPoint::class, 'rewardsadpoint_id');
    }

    public function completedPointKaget()
    {
        return $this->hasMany(CompletedPointKaget::class, 'rewardsadpoint_id');
    }
}
