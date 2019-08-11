<?php

namespace Plugins\Auto\Http\Controllers;

use Plugins\Auto\Services\EventService;
use Plugins\Auto\Http\Requests\Event\CreateEventRequest;
use Plugins\Auto\Services\VehicleService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    private $eventService;
    private $vehicleService;
    
    public function __construct(EventService $eventService, VehicleService $vehicleService)
    {
        $this->eventService = $eventService;
        $this->vehicleService = $vehicleService;
        
        $this->middleware('auth');
    }
    
    public function create(CreateEventRequest $request, $vehicle_id)
    {
        $user = Auth::user();
        $input = $request->all();
        
        //get vehicle
        $vehicle = $this->vehicleService->getVehicle($vehicle_id);
        if($vehicle && $vehicle->user->id == $user->id)
        { 
            //create event
            $event = $this->eventService->createEvent($input, $vehicle->id);
            if($event)
            {
                return $event; //ajax handles redirect
            }
            else
            {
                throw new Exception('Sorry. Please try again later...');
            }
        }
    }
    
    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CreateEventRequest $request, $vehicle, $event)
    {
        $user = Auth::user();
        $event = $this->eventService->getEvent($event);
        $vehicle = $this->vehicleService->getVehicle($vehicle);
        
        $input = $request->all();
        
        if($event)
        {
            if($vehicle && $vehicle->user->id == $user->id)
            {
                $event = $this->eventService->updateEvent($input, $event->id);
                if($vehicle)
                {
                    return redirect(route('auto.vehicle', ['id' => $vehicle->id]))->with('success', 'Event updated');
                }
                else
                {
                    throw new Exception('Could not update the vehicle at this time. Please try again later...');
                }
            }
            
            throw new Exception("Sorry, you do not have access to that resource");
        }
        
        throw new Exception("Sorry, that resource does not exist");
    }
    
    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function delete($id)
    {
        $user = Auth::user();
        $event = $this->eventService->getEvent($id);
        if($event)
        {
            $vehicle = $this->vehicleService->getVehicle($event->vehicle_id);
            if($vehicle && $vehicle->user->id == $user->id)
            {
                $delete = $this->eventService->deleteEvent($id);
                if($delete)
                {
                    return redirect(route('auto.vehicle', ['id' => $vehicle->id]))->with('success', 'Your event has been deleted');
                }
                else
                {
                    return back()->with('error', 'Could not delete the event at this time. Please try again later...');
                }
            }
            
            return back()->with('error', 'Sorry, you do not have access to that resource');
        }
        
        return back()->with('error', 'Sorry, that resource does not exist');
    }
}