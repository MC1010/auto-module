<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('auto')->group(function() {
    Route::get('/', 'VehicleController@index')->name('auto.vehicles');
    Route::get('/vehicle/{id}', 'VehicleController@show')->name('auto.vehicle');
    
    Route::post('/', 'VehicleController@create')->name('auto.vehicle.create');
    Route::post('/vehicle/{vehicle_id}/event', 'EventController@create')->name('auto.event.create');
    
    Route::put('/vehicle/{id}', 'VehicleController@update')->name('auto.vehicle.update');
    Route::put('/vehicle/{vehicle}/event/{event}', 'EventController@update')->name('auto.event.update');
    
    Route::delete('/vehicle/{id}', 'VehicleController@delete')->name('auto.vehicle.delete');
    Route::delete('/event/{id}', 'EventController@delete')->name('auto.event.delete');
});
