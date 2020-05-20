@component('activities.activity_panel')
	@slot('heading')
		<div class="level">
			<div class="flex">
				<a href="/profiles/{{ $activity->subject->creator->name }}">
					{{ $activity->subject->creator->name }}
				</a> created a thread :: 
				<a href="{{ $activity->subject->path() }}">{{ $activity->subject->title }}</a>
			</div>
			
			{{ $activity->subject->created_at->diffForHumans() }}...
		</div>
	@endslot

	@slot('body')
		{{ $activity->subject->body }}
	@endslot

@endcomponent
