<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'movement_id',
        'value',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function movement(){
        return $this->belongsTo('App\Models\Movement', 'movement_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
