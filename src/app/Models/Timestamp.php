<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timestamp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_work',
        'punchIn',
        'punchOut',
        'work_total',
        'rest_total',
    ];

    public function rests(){
        return hasMany(Rest::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
