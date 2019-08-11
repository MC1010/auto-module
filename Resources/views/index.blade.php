@extends('layouts.auth')

@section('title', 'Vehicles')

@section('plugin-name', 'Automotive')

@section('page-title', 'All Vehicles')

@section('styles')
	<link rel="stylesheet" href="{{ mix('css/auto.css') }}">
@endsection

@section('sidebar-menu')
    <!-- Nav Item - Vehicles -->
	@include('partials.parts.sidebar-menu-item', ['label' => "Vehicles", 'icon' => "fa-car", 'url' => route('auto.vehicles')])
@endsection

@section('page-header-button')
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#new_vehicle_modal">New Vehicle</button>
@endsection

@section('page')
<div id="applications">
	
	@if(session('success'))
    	<div class="alert alert-success" role="alert">
        	<p class="m-0">{{ session('success') }}</p>
        </div>
	@endif
	
	<ul class="m-0 p-0">
		@forelse($vehicles as $vehicle)
			<li class="list-group-item my-3 p-0">
				<a href="{{ route('auto.vehicle', ['id' => $vehicle->id]) }}" class="d-flex w-100 p-3 justify-content-between">
					<span>{{ ucfirst($vehicle->year) }} {{ ucfirst($vehicle->make) }} {{ ucfirst($vehicle->model) }} - {{ ucfirst($vehicle->color) }}</span>
					<span class="fas fa-chevron-right py-1"></span>
				</a>
			</li>
		@empty
			<label>Vehicles is empty</label>
		@endforelse
	</ul>
</div>
@endsection

@section('modals')
<div id="new_vehicle_modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<h5 class="modal-title">Register a new vehicle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                	<span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            	<div id="form_errors" class="alert alert-danger hide-on-submit" style="display: none" role="alert">
                	<p class="m-0"></p>
                </div>
          		<form id="new_vehicle_form" class="modal-form" method="post">
          			@csrf
          			<ul>
          				<li class="pb-2">
          					<label class="font-weight-bold">Year</label>
          					<select class="form-control" name="year">
          						@for($y = date('Y'); $y > 1990; $y--)
          							<option value="{{ $y }}">{{ $y }}</option>
          						@endfor
          					</select>
          				</li>
          				<li class="pb-2">
          					<label class="font-weight-bold">Make</label>
          					<select class="form-control" name="make">
          						<option value="bmw">BMW</option>
          						<option value="dodge">Dodge</option>
          						<option value="ford">Ford</option>
          						<option value="mercedes">Mercedes</option>
          						<option value="nissan">Nissan</option>
          						<option value="toyota">Toyota</option>
          					</select>
          				</li>
          				<li class="pb-2">
          					<label class="font-weight-bold">Model</label>
          					<input type="text" class="form-control" name="model" />
          					<label id="new_vehicle_model" class="text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
          				</li>
          				<li class="pb-2">
          					<label class="font-weight-bold">Color</label>
          					<select class="form-control" name="color">
          						<option value="red">Red</option>
          						<option value="orange">Orange</option>
          						<option value="yellow">Yellow</option>
          						<option value="green">Green</option>
          						<option value="blue">Blue</option>
          						<option value="black">Black</option>
          						<option value="white">White</option>
          						<option value="gray">Gray</option>
          					</select>
          				</li>
          				<li class="pb-2">
          					<label class="font-weight-bold">State</label>
          					<input type="text" class="form-control" name="state" placeholder="e.g. MA" />
          					<label id="new_vehicle_state" class="text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
          				</li>
          				<li class="pb-2">
          					<label class="font-weight-bold">License Plate</label>
          					<input type="text" class="form-control" name="plate" placeholder="e.g. H76 EDT" />
          					<label id="new_vehicle_plate" class="text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
          				</li>
          				<li class="pb-2">
          					<label class="font-weight-bold">VIN Number</label>
          					<input type="text" class="form-control" name="vin" />
          					<label id="new_vehicle_vin" class="text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
          				</li>
          			</ul>
          		</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="new_vehicle_form_submit">Register</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
	<script>
		jQuery(document).ready(function($) {
			$('#new_vehicle_form_submit').on('click', function(e) {
				e.preventDefault();

				var form = $('#new_vehicle_form');
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
						  			$('#new_vehicle_' + key).text(object.errors[key][0]);
						  			$('#new_vehicle_' + key).show();
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
@endsection