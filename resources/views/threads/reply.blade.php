<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div class="panel panel-default" id="reply-no-{{ $reply->id }}">
        <div class="panel-heading">

            <div class="level">
            	<span class="flex">
            		<a href="{{ route('profile', $reply->owner->name) }}" >
            		    {{ $reply->owner->name }}
            		</a> said {{ $reply->created_at->diffForHumans() }}...
            	</span>

            	<div>
                    <favorite :reply="{{ $reply }}"></favorite>
            	</div>
            </div>
        </div>

        <div class="panel-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" name="reply-body" id="reply-body" v-model="body"> </textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-xs" @click="submitUpdate">Update</button>
                    <button class="btn btn-link btn-xs" @click="editing = false ">Cancel</button>
                </div>
            </div>
            <div v-else="!editing" v-text="body">
            </div>
        </div>

        @can('update', $reply)
            <div class="panel-footer level" v-if="!editing">
                <button class="btn btn-xs mr-1" @click="editing = !editing ">Edit</button>
                <button class="btn btn-danger btn-xs mr-1" @click="destroy">Delete</button>
            </div>
        @endcan
    </div>
</reply>