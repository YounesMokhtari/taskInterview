<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'url',
        'interval',
        'method',
        'body',
        'last_run_at',
        'should_run_at'
    ];
    protected $casts=[
        'last_run_at'=>'datetime',
        'should_run_at'=>'datetime'
    ];
    public function histories(){
        return $this->hasMany(History::class);
    }
}
