<div class="panel panel-default">
    <div class="panel-heading">

        <div class="level">
        	<span class="flex">
        		<a href="{{ route('profile', $reply->owner->name) }}" >
        		    {{ $reply->owner->name }}
        		</a> said {{ $reply->created_at->diffForHumans() }}...
        	</span>

        	<div>
        		@if(! $reply->isFavorited())
	        		<form method="POST" action="/replies/{{ $reply->id }}/favorites">
	        			{{ csrf_field() }}
	        			<button type="submit" class="btn btn-default">
	        				{{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count )}}
	        			</button>
	        		</form>

	        	@else
        			<button type="submit" class="btn btn-default" disabled="disabled">
        				 Favorited ({{ $reply->favorites_count }})
        			</button>
	        	@endif
        	</div>
        </div>
    </div>

    <div class="panel-body">
        {{ $reply->body }}
    </div>
</div>
