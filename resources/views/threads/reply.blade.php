<div class="panel panel-default">
    <div class="panel-heading">

        <div class="level">
        	<span class="flex">
        		<a href="#" >
        		    {{ $reply->owner->name }}
        		</a> said {{ $reply->created_at->diffForHumans() }}...
        	</span>

        	<div>
        		@if(! $reply->isFavorited())
	        		<form method="POST" action="/replies/{{ $reply->id }}/favorites">
	        			{{ csrf_field() }}
	        			<button type="submit" class="btn btn-default">
	        				{{ $reply->favorites()->count() }} {{ str_plural('Favorite', $reply->favorites()->count() )}}
	        			</button>
	        		</form>

	        	@else
        			<button type="submit" class="btn btn-default" disabled="disabled">
        				 Favorited ({{ $reply->favorites()->count() }})
        			</button>
	        	@endif
        	</div>
        </div>
    </div>

    <div class="panel-body">
        {{ $reply->body }}
    </div>
</div>
