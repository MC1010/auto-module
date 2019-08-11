<?php

namespace Plugins\Auto\Entities;

use Illuminate\Database\Eloquent\Model;

class Plate extends Model
{
    protected $fillable = [
        'state',
        'number'
    ];
    
    public function getStateAttribute($state)
    {
        return strtoupper($state);
    }
    
    public function getNumberAttribute($number)
    {
        return strtoupper($number);
    }
}
