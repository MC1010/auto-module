@extends('layouts.auth')

@section('title', 'Vehicle')

@section('plugin-name', 'Automotive')

@section('page-title')
	{{ ucfirst($vehicle->year) }} {{ ucfirst($vehicle->make) }} {{ ucfirst($vehicle->model) }} - {{ ucfirst($vehicle->color) }}
@endsection

@section('styles')
	<link rel="stylesheet" href="{{ mix('css/auto.css') }}">
@endsection

@section('sidebar-menu')
    <!-- Nav Item - Vehicles -->
	@include('partials.parts.sidebar-menu-item', ['label' => "Vehicles", 'icon' => "fa-car", 'url' => route('auto.vehicles')])
@endsection

@section('page-header-button')
<div class="text-right">
	<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#vehicle_options_modal">Options</button>
</div>
@endsection

@section('page')
<div id="vehicle-{{ $vehicle->id }}" class="vehicle-summary">
	<div class="row">
	
		@if(session('success'))
			<div class="col-12">
            	<div class="alert alert-success" role="alert">
                	<p class="m-0">{{ session('success') }}</p>
                </div>
            </div>
		@endif
	
		@if(session('error'))
			<div class="col-12">
            	<div class="alert alert-danger" role="alert">
                	<p class="m-0">{{ session('error') }}</p>
                </div>
            </div>
		@endif
		
		<div class="col-lg-9">
			<div class="card">
    			<div class="card-header text-primary font-weight-bold">Routine Maintenance</div>
    			<div class="card-body py-3">
    				<ul>
        				@foreach($routineEvents as $event)
        					<li @if(!$loop->last) class="border-bottom" @endif>
        						<div class="row">
            						<div class="col-md-8">
            							<div class="p-2 d-flex">
                							<div class="event-icon-background d-none d-sm-block">
                								<span class="d-block"><i class="fas {{ $event->icon }}"></i></span>
                							</div>
                							<div class="event-header-info">
                								<h4 class="event-header-title">{{ $event->name }}</h4>
                								<p class="event-header-mileage">
                									@if(isset($specialEvents[ $event->id ]))
                										@if(isset($specialEvents[ $event->id ]->mileage))
                											{{ $specialEvents[ $event->id ]->mileage }} miles
                										@else
                											No Mileage Provided
                										@endif
                									@else
                										No Mileage Information
                									@endif
                								</p>
                							</div>
                						</div>
            						</div>
            						<div class="col-md-4">
            							<div class="px-2">
            								<h5 class="event-header-date">
            									@if(isset($specialEvents[ $event->id ]))
            										@if(isset($specialEvents[ $event->id ]->date))
            											{{ \Carbon\Carbon::parse($specialEvents[ $event->id ]->date)->format('d M Y') }}
            										@else
            											Unknown
            										@endif
            									@else
            										No Event
            									@endif
                							</h5>
            							</div>
            						</div>
            					</div>
        					</li>
        				@endforeach
        			</ul>
    			</div>
			</div>
			<div class="card my-4">
    			<div class="card-header text-primary font-weight-bold">
    				Repair & Maintenance
    				
    				<button class="btn btn-card-header btn-primary float-right" data-toggle="modal" data-target="#new_event_modal">New Event</button>
    			</div>
    			<div class="card-body">
    				<ul>
    					@forelse($events as $event)
    						<li class="border-bottom">
            					@include('auto::partials.event_row', ['event' => $event])
    						</li>
    					@empty
    						<li class="text-center"><h4>No vehicle events</h4>
    					@endforelse
    				</ul>
    			</div>
    		</div>
		</div>
		<div class="col-lg-3">
			<div class="card">
    			<div class="card-header text-primary font-weight-bold">Information</div>
    			<div class="card-body">
    				<ul>
    					<li class="text-center pb-2">
    						<h4>VIN Number</h4>
							@if($vehicle->hasVIN())
								<p class="m-0">{{ $vehicle->vin }}</p>
							@else
								<p class="m-0">No VIN Number</p>
							@endif
						</li>
    					<li class="text-center">
    						<h4>License Plate</h4>
							@if($vehicle->hasLicensePlate())
								<p class="m-0">{{ $vehicle->plate->state }} | {{ $vehicle->plate->number }}</p>
							@else
								<p class="m-0">No License Plate</p>
							@endif
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('modals')
<div id="vehicle_options_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<h5 class="modal-title font-weight-bold">Options</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<button type="button" class="btn btn-block btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#vehicle_edit_modal">Edit vehicle</button>
            	<button type="button" class="btn btn-block btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#vehicle_delete_confirm_modal">Delete vehicle</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="vehicle_delete_confirm_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<h5 class="modal-title font-weight-bold">Confirm Action</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	Are you sure you want to delete this vehicle? This action cannot be undone.	
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            	<form action="{{ route('auto.vehicle.delete', ['id' => $vehicle->id]) }}" method="post">
            		@method('DELETE')
            		@csrf
                	<button type="submit" class="btn btn-danger">Delete</button>
            	</form>
            </div>
        </div>
    </div>
</div>
<div id="new_event_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<h5 class="modal-title font-weight-bold">New Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<form id="new_event_form" class="modal-form" action="{{ route('auto.event.create', ['vehicle' => $vehicle->id]) }}" method="post">
            		@csrf
            		@include('auto::partials.event_form', ['types' => $routineEvents, 'event' => null, 'form' => 'new'])
            	</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="new_event_form_submit">Save</button>
            </div>
        </div>
    </div>
</div>
<div id="edit_event_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<h5 class="modal-title font-weight-bold">Edit Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	@foreach($events as $event)
            		<div class="edit_event_form d-none">
                    	<form class="modal-form event-form" id="edit_event_{{ $event->id }}_form" action="{{ route('auto.event.update', ['vehicle' => $vehicle->id, 'event' => $event->id]) }}" method="post">
                    		@csrf
                    		@method('PUT')
                    		@include('auto::partials.event_form', ['types' => $routineEvents, 'event' => $event, 'form' => 'edit'])
                    	</form>
                    	<form action="{{ route('auto.event.delete', ['id' => $event->id]) }}" method="post">
                    		@method('DELETE')
                    		@csrf
                			<button type="submit" class="btn btn-block btn-danger">Delete Event</button>
                    	</form>
                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="edit_event_form_submit">Save</button>
            </div>
        </div>
    </div>
</div>
<div id="vehicle_edit_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<h5 class="modal-title font-weight-bold">Edit Vehicle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<div id="form_errors" class="alert alert-danger hide-on-submit" style="display: none" role="alert">
                	<p class="m-0"></p>
                </div>
          		<form id="edit_vehicle_form" class="modal-form" method="post">
          			@method('PUT')
          			@csrf
          			<ul>
          				<li class="pb-2">
          					<label class="font-weight-bold">Year</label>
          					<select class="form-control" name="year">
          						@for($y = date('Y'); $y > 1990; $y--)
          							<option value="{{ $y }}" @if($vehicle->year == $y)selected @endif>{{ $y }}</option>
          						@endfor
          					</select>
          				</li>
          				<li class="pb-2">
          					<label class="font-weight-bold">Make</label>
          					<select class="form-control" name="make">
          						<option value="bmw" @if($vehicle->make == "bmw")selected @endif>BMW</option>
          						<option value="dodge" @if($vehicle->make == "dodge")selected @endif>Dodge</option>
          						<option value="ford" @if($vehicle->make == "ford")selected @endif>Ford</option>
          						<option value="mercedes" @if($vehicle->make == "mercedes")selected @endif>Mercedes</option>
          						<option value="nissan" @if($vehicle->make == "nissan")selected @endif>Nissan</option>
          						<option value="toyota" @if($vehicle->make == "toyota")selected @endif>Toyota</option>
          					</select>
          				</li>
          				<li class="pb-2">
          					<label class="font-weight-bold">Model</label>
          					<input type="text" class="form-control" name="model" value="{{ $vehicle->model }}" />
          					<label id="edit_vehicle_model" class="text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
          				</li>
          				<li class="pb-2">
          					<label class="font-weight-bold">Color</label>
          					<select class="form-control" name="color">
          						<option value="red" @if($vehicle->color == "red")selected @endif>Red</option>
          						<option value="orange" @if($vehicle->color == "orange")selected @endif>Orange</option>
          						<option value="yellow" @if($vehicle->color == "yellow")selected @endif>Yellow</option>
          						<option value="green" @if($vehicle->color == "green")selected @endif>Green</option>
          						<option value="blue" @if($vehicle->color == "blue")selected @endif>Blue</option>
          						<option value="black" @if($vehicle->color == "black")selected @endif>Black</option>
          						<option value="white" @if($vehicle->color == "white")selected @endif>White</option>
          						<option value="gray" @if($vehicle->color == "gray")selected @endif>Gray</option>
          					</select>
          				</li>
          				<li class="pb-2">
          					<label class="font-weight-bold">State</label>
          					<input type="text" class="form-control" name="state" placeholder="e.g. MA" @if($vehicle->hasLicensePlate()) value="{{ $vehicle->plate->state }}" @endif />
          					<label id="edit_vehicle_state" class="text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
          				</li>
          				<li class="pb-2">
          					<label class="font-weight-bold">License Plate</label>
          					<input type="text" class="form-control" name="plate" placeholder="e.g. H76 EDT" @if($vehicle->hasLicensePlate()) value="{{ $vehicle->plate->number }}" @endif />
          					<label id="edit_vehicle_plate" class="text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
          				</li>
          				<li class="pb-2">
          					<label class="font-weight-bold">VIN Number</label>
          					<input type="text" class="form-control" name="vin" value="{{ $vehicle->vin }}" />
          					<label id="edit_vehicle_vin" class="text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
          				</li>
          			</ul>
          		</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="edit_vehicle_form_submit">Save</button>
            </div>
        </div>
    </div>
</div>
<div id="event_show_modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<h5 id="event_name" class="modal-title font-weight-bold"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<div class="py-1">
     				<label class="font-weight-bold d-inline">Date:</label>
     				<label id="event_date" class="d-inline"></label>
            	</div>
            	<div class="py-1">
     				<label class="font-weight-bold d-inline">Mileage:</label>
     				<label id="event_mileage" class="d-inline"></label>
            	</div>
            	<div class="py-1">
     				<label class="font-weight-bold d-inline">Location:</label>
     				<label id="event_location" class="d-inline"></label>
            	</div>
            	<div class="py-1">
     				<label class="font-weight-bold d-block">Notes:</label>
     				<label id="event_notes" class="d-block"></label>
            	</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#edit_event_modal">Edit</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
	<script>
		jQuery(document).ready(function($) {
			$('#edit_vehicle_form_submit').on('click', function(e) {
				e.preventDefault();

				var form = $('#edit_vehicle_form');
				var formData = $(form).serialize();

				$('.hide-on-submit').hide();

				$.ajax({
					method: 'POST',
				    data: formData,
				    success: function(response)	{
				        window.location.reload();
				    },
				    error: function(jqXHR, textStatus, errorThrown) {
					    var object = JSON.parse(jqXHR.responseText);
				        
						if(object.message) {
							$('#form_errors p').text(object.message);

							if(object.errors) {
								Object.keys(object.errors).forEach(function(key) {
						  			$('#edit_vehicle_' + key).text(object.errors[key][0]);
						  			$('#edit_vehicle_' + key).show();
								});
							}									
						} else {
							$('#form_errors p').text('Sorry the action could not be completed at this time.');
						}

						$('#form_errors').show();
				    }
				});
			});
		});
	</script>
	<script>
		jQuery(document).ready(function($) {
			$('#new_event_form_submit').on('click', function(e) {
				e.preventDefault();

				var form = $('#new_event_form');
				var formData = $(form).serialize();

				$('.hide-on-submit').hide();

				$.ajax({
					method: 'POST',
					url: $(form).attr('action'),
				    data: formData,
				    success: function(response)	{
				        window.location.reload();
				    },
				    error: function(jqXHR, textStatus, errorThrown) {
					    var object = JSON.parse(jqXHR.responseText);
				        
						if(object.message) {
							$('#new_event_errors p').text(object.message);

							if(object.errors) {
								Object.keys(object.errors).forEach(function(key) {
						  			$('#new_event_' + key).text(object.errors[key][0]);
						  			$('#new_event_' + key).show();
								});
							}									
						} else {
							$('#new_event_errors p').text('Sorry the action could not be completed at this time.');
						}

						$('#new_event_errors').show();
				    }
				});
			});
		});
	</script>
	<script>
		jQuery(document).ready(function($) {
			$('#edit_event_form_submit').on('click', function(e) {
				e.preventDefault();

				var form = $('.edit_event_form.active .event-form');
				var formData = $(form).serialize();

				$('.hide-on-submit').hide();

				$.ajax({
					method: 'POST',
					url: $(form).attr('action'),
				    data: formData,
				    success: function(response)	{
				        window.location.reload();
				    },
				    error: function(jqXHR, textStatus, errorThrown) {
					    var object = JSON.parse(jqXHR.responseText);
				        
						if(object.message) {
							$($(form).attr('id') + ' .edit_event_errors p').text(object.message);

							if(object.errors) {
								Object.keys(object.errors).forEach(function(key) {
						  			$($(form).attr('id') + ' .edit_event_' + key).text(object.errors[key][0]);
						  			$($(form).attr('id') + ' .edit_event_' + key).show();
								});
							}									
						} else {
							$($(form).attr('id') + ' .edit_event_errors p').text('Sorry the action could not be completed at this time.');
						}

						$($(form).attr('id') + ' .edit_event_errors').show();
				    }
				});
			});
		});
	</script>
	<script>
    	jQuery(document).ready(function($) {
    		$('.event').on('click', function(e) {
        		$('#event_name').text($(this).find('.event-name').text());
        		$('#event_date').text($(this).find('.event-date').text());
        		$('#event_mileage').text($(this).find('.event-mileage').val());
        		$('#event_location').text($(this).find('.event-location').val());
        		$('#event_notes').text($(this).find('.event-notes').val());

        		$('.edit_event_form').removeClass('active').addClass('d-none');
        		$('#edit_event_' + $(this).find('.event-id').val() + '_form').parent().addClass('active').removeClass('d-none');
        		
				$('#event_show_modal').modal();
    		});
    	});
	</script>
@endsection