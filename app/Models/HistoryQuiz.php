<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoryQuiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'player_id',
        'score',
        'points',
        'ads_watched_inters',
        'ads_watched_rewards',
        'category_id',
        'category_level',
        'total_quiz_points',
        'completed_option',
        'with_double_option',
        'description',
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
        return \Carbon\Carbon::parse($date)->timezone('Asia/Jakarta')->format('d F Y, H:i');
    }

    public function getUpdatedAtAttribute($date) {
        return \Carbon\Carbon::parse($date)->timezone('Asia/Jakarta')->format('d F Y, H:i');
    }

    protected $casts = [

    ];

    public function categoryQuiz()
    {
        return $this->belongsTo(CategoryQuiz::class, 'category_id');
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

}
