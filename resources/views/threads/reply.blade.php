<div class="panel panel-default" id="reply-no-{{ $reply->id }}">
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

    @can('update', $reply)
        <div class="panel-footer">
            <form action="/replies/{{ $reply->id }}" method="POST">
                {{  csrf_field() }}
                {{  method_field('DELETE') }}

                <button type="submit" class="btn btn-danger btn-xs">
                    Delete reply
            </form>
        </div>
    @endcan
</div>
