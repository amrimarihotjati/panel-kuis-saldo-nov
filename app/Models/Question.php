<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'question',
        'true_answer',
        'false_answer1',
        'false_answer2',
        'false_answer3',
        'level',
        'points',
        'category_id'
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

    
}
