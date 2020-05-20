@component('activities.activity_panel')
	@slot('heading')
		<div class="level">
			<div class="flex">
				<a href="/profiles/{{ $activity->subject->owner->name }}">
					{{ $activity->subject->owner->name }}
				</a> reply to a thread :: 
				<a href="{{ $activity->subject->thread->path() }}">{{ $activity->subject->thread->title }}</a>
			</div>
			{{ $activity->subject->created_at->diffForHumans() }}...
		</div>
	@endslot

	@slot('body')
		{{ $activity->subject->body }}
	@endslot

@endcomponent
