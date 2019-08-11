<?php

namespace Plugins\Auto\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Plugins\Auto\Entities\EventType;

class SeedEventTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->createEventType('Oil Change', 'fa-oil-can');
        $this->createEventType('Tire Rotation', 'fa-sync-alt');
        $this->createEventType('Tire Alignment', 'fa-tools');
    }
    
    /**
     * Creates a new EventType with the supplied information
     * 
     * @param string $name
     * @param string $icon
     * @return \Plugins\Auto\Entities\EventType
     */
    private function createEventType($name, $icon)
    {
        return EventType::create([
            'name' => $name,
            'icon' => $icon
        ]);
    }
}
