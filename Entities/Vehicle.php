<?php

namespace Plugins\Auto\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\User;

class Vehicle extends Model
{
    /**
     * Model attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'year',
        'make',
        'model',
        'trim',
        'vin',
        'color'
    ];
    
    /**
     * Associates vehicle model with many Event models
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }
    
    /**
     * Associates vehicle model with owner
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Associates vehicle model with a license plate
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function plate()
    {
        return $this->hasOne(Plate::class);
    }
    
    public function hasVIN()
    {
        return !is_null($this->vin);
    }
    
    public function hasLicensePlate()
    {
        return !is_null($this->plate);
    }
}
