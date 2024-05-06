<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'status_code',
        'response',
    ];
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status_code' => 'integer'
    ];

    public function monitor()
    {
        return $this->belongsTo(Monitor::class);
    }
}
