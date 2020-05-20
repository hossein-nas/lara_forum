<div class="panel panel-default">
	<div class="panel-body">
		<div class="level">
			<span class="flex">
				<a href="/profiles/{{ $activity->subject->user->name }}">
					{{ $activity->subject->user->name }}
				</a>
					favorited REPLY of :: 
				<a href="/profiles/{{ $activity->subject->favorited->owner->name }}">
					{{ $activity->subject->favorited->owner->name  }}
				</a> 
				In ::
				<a href="{{ $activity->subject->favorited->thread->path()}}#reply-no-{{ $activity->subject->favorited->id }}">
					{{ $activity->subject->favorited->thread->title  }}
				</a>
			</span>	{{  $activity->created_at->diffForHumans() }}
		</div>
	</div>
</div>