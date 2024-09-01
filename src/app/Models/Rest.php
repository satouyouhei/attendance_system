<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;

    protected $fillable = [
        'timestamp_id',
        'rest_start',
        'rest_end',
        'restTime'
    ];

    public function timestamp(){
        return $this->belongsTo(Timestamp::class);
    }
}
