<div class="event-row">
	<span class="event d-flex w-100 p-3 justify-content-between">
		<div>
			<label class="event-name font-weight-bold m-0 d-block text-truncate">{{ $event->name }}</label>
			<label class="event-date m-0 d-block">{{ Carbon\Carbon::parse($event->date)->format('d M Y') }}</label>
			
			<input type="hidden" class="event-id" value="{{ $event->id }}" />
			<input type="hidden" class="event-mileage" value="{{ $event->mileage }}" />
			<input type="hidden" class="event-location" value="{{ $event->location }}" />
			<input type="hidden" class="event-notes" value="{{ $event->notes }}" />
		</div>
		<span class="fas fa-chevron-right py-3"></span>
	</span>
</div>