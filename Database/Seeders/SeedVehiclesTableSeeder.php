<?php

namespace Plugins\Auto\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Plugins\Auto\Entities\Vehicle;
use Plugins\Auto\Entities\Event;


class SeedVehiclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        
        /*
         * Create vehicle with all attributes
         */
        $vehicle = factory(Vehicle::class)->states('vin', 'trim')->create();
        
        $vehicle->events()->save(factory(Event::class)->make());
        $vehicle->events()->save(factory(Event::class)->states('mileage')->make());
        $vehicle->events()->save(factory(Event::class)->states('mileage')->make());
        $vehicle->events()->save(factory(Event::class)->states('location')->make());
        $vehicle->events()->save(factory(Event::class)->states('notes')->make());
        $vehicle->events()->save(factory(Event::class)->states('oilChange')->make());
        $vehicle->events()->save(factory(Event::class)->states('tireRotation')->make());
        $vehicle->events()->save(factory(Event::class)->states('tireAlignment')->make());
        
        /*
         * Create simple vehicle with no added information
         */
        factory(Vehicle::class)->create();
    }
    
    /**
     * Creates a new EventType with the supplied information
     *
     * @param string $name
     * @param integer $interval
     * @return \Plugins\Auto\Entities\EventType
     */
    private function createEventType($name)
    {
        return EventType::create([
            'name' => $name
        ]);
    }
}