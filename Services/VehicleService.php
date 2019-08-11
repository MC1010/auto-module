<?php
namespace Plugins\Auto\Services;

use Plugins\Auto\Repositories\VehicleRepository;
use App\Entities\User;
use Illuminate\Support\Facades\Log;

class VehicleService
{
    private $vehicleRepository;
    
    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }
    
    public function getUserVehicles(User $user)
    {
        return $this->vehicleRepository->getUserVehicles($user);
    }
    
    public function getVehicle($id)
    {
        return $this->vehicleRepository->getVehicle($id);
    }
    
    public function createVehicle($data, $user_id)
    {
        $vehicleAttributes = [
            'year' => $data['year'],
            'make' => $data['make'],
            'model' => $data['model'],
            'color' => $data['color']
        ];
        
        if($data['vin'])
            $vehicleAttributes['vin'] = $data['vin'];
        
        $vehicle = $this->vehicleRepository->createVehicle($data, $user_id);
        if($vehicle)
        {
            if($data['state'] && $data['plate'])
            {
                $plateAttributes = [
                    'state' => $data['state'],
                    'plate' => $data['plate']
                ];
                
                $plate = $this->createPlate($plateAttributes, $vehicle->id);
                if($plate)
                {
                    //refresh the vehicle w/ plate
                    $vehicle = $this->getVehicle($vehicle->id);
                }
            }
        }
        
        return $vehicle;
    }
    
    public function createPlate($data, $vehicle_id)
    {
        $plateAttributes = [
            'state' => $data['state'],
            'number' => $data['plate']
        ];
        
        return $this->vehicleRepository->createPlate($plateAttributes, $vehicle_id);
    }
    
    public function deleteVehicle($id)
    {
        return $this->vehicleRepository->deleteVehicle($id);
    }
    
    public function updatePlate($data, $plate_id)
    {
        $plateAttributes = [
            'state' => $data['state'],
            'number' => $data['plate']
        ];
        
        Log::debug($plateAttributes);
        
        return $this->vehicleRepository->updatePlate($plateAttributes, $plate_id);
    }
    
    public function updateVehicle($data, $vehicle_id)
    {
        $vehicleAttributes = [
            'year' => $data['year'],
            'make' => $data['make'],
            'model' => $data['model'],
            'color' => $data['color']
        ];
        
        if($data['vin'])
            $vehicleAttributes['vin'] = $data['vin'];
            
        $vehicle = $this->vehicleRepository->updateVehicle($vehicleAttributes, $vehicle_id);
        if($vehicle)
        {
            if($data['state'] && $data['plate'])
            {
                $plateAttributes = [
                    'state' => $data['state'],
                    'plate' => $data['plate'] //hacky fix later
                ];
                
                if($vehicle->hasLicensePlate())
                    $plate = $this->updatePlate($plateAttributes, $vehicle->plate->id);
                else 
                    $plate = $this->createPlate($plateAttributes, $vehicle->id);
                
                if($plate)
                {
                    //refresh the vehicle w/ plate
                    $vehicle = $this->getVehicle($vehicle->id);
                }
            }
        }
        
        return $vehicle;
    }
}