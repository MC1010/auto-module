<?php

namespace Plugins\Auto\Entities;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    public $timestamps = false;
    
    /**
     * Model attributes that can be mass assigned
     * @var array
     */
    protected $fillable = [
        'name',
        'icon'
    ];
}
