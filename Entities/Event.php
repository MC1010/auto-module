<?php

namespace Plugins\Auto\Entities;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'date',
        'mileage',
        'location',
        'type',
        'notes'
    ];
    
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
