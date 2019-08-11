<?php

namespace Plugins\Auto\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Plugins\Auto\Services\VehicleService;
use Plugins\Auto\Services\EventService;
use Plugins\Auto\Http\Requests\Vehicle\CreateVehicleRequest;
use League\Flysystem\Exception;
use Plugins\Auto\Http\Requests\Vehicle\UpdateVehicleRequest;

class VehicleController extends Controller
{
    private $vehicleService;
    private $eventService;
    
    public function __construct(EventService $eventService, VehicleService $vehicleService)
    {
        $this->eventService = $eventService;
        $this->vehicleService = $vehicleService;
        
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $vehicles = $this->vehicleService->getUserVehicles($user);
        
        return view('auto::index', [
            'vehicles' => $vehicles,
            'user' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(CreateVehicleRequest $request)
    {
        $user = Auth::user();
        $input = $request->all();
        
        //create vehicle
        $vehicle = $this->vehicleService->createVehicle($input, $user->id);
        
        if($vehicle)
        {
            return redirect(route('auto.vehicle', ['id' => $vehicle->id]));
        }
        else 
        {
            return back()->withInput()->with('error', 'Sorry. Please try again later...');
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $vehicle = $this->vehicleService->getVehicle($id);
        $routineEvents = $this->eventService->getEventTypes();
        $specialEvents = $this->eventService->getCurrentRoutineEvents($id);
        $events = $this->eventService->getAllEvents($id);
        
        if($vehicle && $vehicle->user->id == $user->id)
        {   
            return view('auto::show', [
                'vehicle' => $vehicle,
                'routineEvents' => $routineEvents,
                'specialEvents' => $specialEvents,
                'events' => $events
            ]);
        }
        else
        {
            throw new Exception("Sorry, you do not have access to that resource");
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('auto::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateVehicleRequest $request, $id)
    {
        $user = Auth::user();
        $vehicle = $this->vehicleService->getVehicle($id);
        
        $input = $request->all();
        
        if($vehicle && $vehicle->user->id == $user->id)
        {
            $vehicle = $this->vehicleService->updateVehicle($input, $id);
            if($vehicle)
            {
                return redirect(route('auto.vehicle', ['id' => $vehicle->id]))->with('success', 'Vehicle updated');
            }
            else 
            {
                throw new Exception('Could not update the vehicle at this time. Please try again later...');
            }
        }
        
        throw new Exception("Sorry, you do not have access to that resource");
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function delete($id)
    {
        $user = Auth::user();
        $vehicle = $this->vehicleService->getVehicle($id);
        if($vehicle && $vehicle->user->id == $user->id)
        {
            $delete = $this->vehicleService->deleteVehicle($id);
            if($delete)
            {
                return redirect(route('auto.vehicles'))->with('success', 'Your vehicle has been deleted');
            }
            else 
            {
                return back()->with('error', 'Could not delete the vehicle at this time. Please try again later...');
            }
        }
        
        return back()->with('error', 'Sorry, you do not have access to that resource');
    }
}
