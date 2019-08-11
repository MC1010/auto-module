<?php
namespace Plugins\Auto\Services;

use Plugins\Auto\Repositories\EventRepository;
use Carbon\Carbon;

class EventService
{
    private $eventRepository;
    
    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }
    
    public function getEvent($id)
    {
        return $this->eventRepository->getEvent($id);
    }
    
    public function getEventTypes()
    {
        return $this->eventRepository->getEventTypes();
    }
    
    public function getCurrentRoutineEvents($id)
    {
        $routineEvents = $this->getEventTypes();
        
        //extract event type ids
        $eventIds = $routineEvents->map(function ($eventType) {
            return $eventType->only(['id']);
        });
        
        $currentEvents = $this->eventRepository->getCurrentRoutineEvents($id, $eventIds->toArray());
        
        $events = array();
        foreach($currentEvents as $event)
        {
           $events[ $event->type ] = $event;
        }
        
        return $events;
    }
    
    public function deleteEvent($id)
    {
        return $this->eventRepository->deleteEvent($id);
    }
    
    public function getAllEvents($id)
    {
        return $this->eventRepository->getAllEvents($id);
    }
    
    public function createEvent($data, $vehicle_id)
    {
        $eventAttributes = [
            'name' => $data['name'],
            'date' => Carbon::createFromFormat('mdY', $data['date'])->format('Y-m-d') //formatted for SQL
        ];
        
        if($data['mileage'])
            $eventAttributes['mileage'] = $data['mileage'];
            
        if($data['location'])
            $eventAttributes['location'] = $data['location'];
            
        if($data['type'])
            $eventAttributes['type'] = $data['type'];
        else
            $eventAttributes['type'] = 0; //default if no type listed
        
        if($data['notes'])
            $eventAttributes['notes'] = $data['notes'];
        
        return $this->eventRepository->createEvent($eventAttributes, $vehicle_id);
    }
    
    public function updateEvent($data, $event_id)
    {
        $eventAttributes = [
            'name' => $data['name'],
            'date' => Carbon::createFromFormat('mdY', $data['date'])->format('Y-m-d'), //formatted for SQL
            'mileage' => null,
            'location' => null,
            'type' => 0,
            'notes' => null
        ];
        
        if($data['mileage'])
            $eventAttributes['mileage'] = $data['mileage'];
            
        if($data['location'])
            $eventAttributes['location'] = $data['location'];
            
        if($data['type'])
            $eventAttributes['type'] = $data['type'];
        else
            $eventAttributes['type'] = 0; //default if no type listed
            
        if($data['notes'])
            $eventAttributes['notes'] = $data['notes'];
            
        return $this->eventRepository->updateEvent($eventAttributes, $event_id);
    }
}