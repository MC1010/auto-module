<?php
namespace Plugins\Auto\Repositories;

use Plugins\Auto\Entities\EventType;
use Plugins\Auto\Entities\Event;
use Illuminate\Database\Eloquent\Collection;

class EventRepository
{
    public function getEventTypes()
    {
        return EventType::all();
    }
    
    public function getEvent($id)
    {
        return Event::find($id);
    }
    
    /**
     * 
     * @param unknown $vehicle_id
     * @param unknown $type
     * @return unknown
     */
    public function getCurrentRoutineEvents($vehicle_id, $type)
    {
        $query = Event::where('vehicle_id', '=', $vehicle_id);
        if(is_array($type))
        {
            $query = $query->whereIn('type', $type);
        }
        else
        {
            $query = $query->where('type', '=', $type);
        }
        
        return $query->orderBy('date')->get();
    }
    
    public function deleteEvent($event_id)
    {
        $event = $this->getEvent($event_id);
        return $event->delete();
    }
    
    public function updateEvent($data, $event_id)
    {
        $event = $this->getEvent($event_id);
        $event->fill($data);
        $event->save();
        
        return $event;
    }
    
    /**
     * Get all events for a given vehicle
     * 
     * @param integer $vehicle_id
     * @return Collection
     */
    public function getAllEvents($vehicle_id)
    {
        
        return Event::where('vehicle_id', '=', $vehicle_id)->orderBy('date', 'DESC')->get();
    }
    
    public function createEvent($data, $vehicle_id)
    {
        $event = new Event($data);
        $event->vehicle_id = $vehicle_id;
        $event->save();
        
        return $event;
    }
}