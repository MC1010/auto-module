<?php

namespace Plugins\Auto\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Plugins\Auto\Database\Seeders\SeedEventTypesTableSeeder;
use Plugins\Auto\Database\Seeders\SeedVehiclesTableSeeder;
use Plugins;

class AutoDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(SeedEventTypesTableSeeder::class);
        $this->call(SeedVehiclesTableSeeder::class);
    }
}
