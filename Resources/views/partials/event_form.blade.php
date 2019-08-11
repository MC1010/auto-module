@if($form == 'edit')
    <div id="{{ $form }}_event_errors_{{ $event->id }}" class="alert alert-danger hide-on-submit" style="display: none" role="alert">
    	<p class="m-0"></p>
    </div>
@else
    <div id="{{ $form }}_event_errors" class="alert alert-danger hide-on-submit" style="display: none" role="alert">
    	<p class="m-0"></p>
    </div>
@endif
<ul>
	<li class="pb-2">
		<label class="font-weight-bold">Name</label>
		<input type="text" class="form-control" name="name" @if($event) value="{{ $event->name }}" @endif />
		@if($form == 'edit')
			<label class="edit_event_name text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
        @else
			<label id="{{ $form }}_event_name" class="text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
        @endif
	</li>
	<li class="pb-2">
		<label class="font-weight-bold">Date</label>
		<input type="text" class="form-control" name="date" placeholder="mmddyyyy" @if($event) value="{{ \Carbon\Carbon::parse($event->date)->format('mdY') }}" @endif />
		@if($form == 'edit')
			<label class="edit_event_date text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
        @else
			<label id="{{ $form }}_event_date" class="text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
        @endif
	</li>
	<li class="pb-2">
		<label class="font-weight-bold">Mileage</label>
		<input type="text" class="form-control" name="mileage" @if($event && $event->mileage) value="{{ $event->mileage }}" @endif />
		@if($form == 'edit')
			<label class="edit_event_mileage text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
        @else
			<label id="{{ $form }}_event_mileage" class="text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
        @endif
	</li>
	<li class="pb-2">
		<label class="font-weight-bold">Location</label>
		<input type="text" class="form-control" name="location" @if($event && $event->location) value="{{ $event->location }}" @endif />
		@if($form == 'edit')
			<label class="edit_event_location text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
        @else
			<label id="{{ $form }}_event_location" class="text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
        @endif
	</li>
	<li class="pb-2">
		<label class="font-weight-bold">Special Type</label>
    	<select class="form-control" name="type">
    		<option value="0">No Special Type</option>
    		@foreach($types as $type)
    			<option value="{{ $type->id }}" @if($event && $type->id == $event->type)selected @endif>{{ ucwords($type->name) }}</option>
    		@endforeach
    	</select>
		@if($form == 'edit')
			<label class="edit_event_type text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
        @else
			<label id="{{ $form }}_event_type" class="text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
        @endif
	</li>
	<li class="pb-2">
		<label class="font-weight-bold">Notes</label>
		<textarea class="form-control" name="notes">@if($event && $event->notes){{ $event->notes }}@endif</textarea>
		@if($form == 'edit')
			<label class="edit_event_notes text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
        @else
			<label id="{{ $form }}_event_notes" class="text-danger font-weight-bold m-0 hide-on-submit" style="display: none"></label>
        @endif
	</li>
</ul>