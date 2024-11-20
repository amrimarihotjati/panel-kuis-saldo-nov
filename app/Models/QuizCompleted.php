<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use \Carbon\Carbon;

class QuizCompleted extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'category_id',
        'category_level',
        'is_use_completed',
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

   public function categoryQuiz()
    {
        return $this->belongsTo(CategoryQuiz::class, 'category_id');
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

}
