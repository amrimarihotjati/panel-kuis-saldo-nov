<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdrawal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'player_id',
        'amount',
        'points',
        'currency',
        'status',
        'payment_method',
        'payment_account',
        'payment_message',
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
        return \Carbon\Carbon::parse($date)->timezone('Asia/Jakarta')->format('d F Y, H:i');
    }

    public function getUpdatedAtAttribute($date) {
        return \Carbon\Carbon::parse($date)->timezone('Asia/Jakarta')->format('d F Y, H:i');
    }


    public function count()
    {
        return count($this->items);
    }

    protected $casts = [

    ];

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method');
    }

}
