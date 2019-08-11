<?php
namespace Plugins\Auto\Repositories;

use Plugins\Auto\Entities\Vehicle;
use App\Entities\User;
use Plugins\Auto\Entities\Plate;

class VehicleRepository
{
    /**
     * Gets all the vehicles associated with a given user
     * 
     * @param User $user
     * @return 
     */
    public function getUserVehicles(User $user)
    {
        return $user->vehicles()->get();
    }
    
    public function getVehicle($id)
    {
        return Vehicle::find($id);
    }
    
    public function getPlate($id)
    {
        return Plate::find($id);
    }
    
    public function createVehicle($data, $user_id)
    {
        $vehicle = new Vehicle($data);
        $vehicle->user_id = $user_id;
        $vehicle->save();
        
        return $vehicle;
    }
    
    public function createPlate($data, $vehicle_id)
    {
        $plate = new Plate($data);
        $plate->vehicle_id = $vehicle_id;
        $plate->save();
        
        return $plate;
    }
    
    public function deleteVehicle($vehicle_id)
    {
        $vehicle = $this->getVehicle($vehicle_id);
        return $vehicle->delete();
    }
    
    public function updatePlate($data, $plate_id)
    {
        $plate = $this->getPlate($plate_id);
        $plate->number = $data['number'];
        $plate->state = $data['state'];
        $plate->save();
        
        return $plate;
    }
    
    public function updateVehicle($data, $id)
    {
        
        $vehicle = $this->getVehicle($id);
        $vehicle->fill($data);
        $vehicle->save();
        
        return $vehicle;
    }
}