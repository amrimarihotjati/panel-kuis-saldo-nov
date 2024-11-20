<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'key',
        'status'
    ];

    protected $casts = [
    ];

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
}
