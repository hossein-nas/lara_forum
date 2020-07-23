<template v-cloak>
    <div class="panel panel-default" v-if="editing">
        <div class="panel-heading">
            <div class="form-group">
                <input type="text" class="form-control" v-model="form.title">
            </div>
        </div>
    
        <div class="panel-body">
            <div class="form-group">
                <wysiwyg  v-model="form.body"></wysiwyg>
            </div>
        </div>
    
        <div class="panel-footer">
            <div class="level">
                <button class="btn btn-xs btn-primary mr-1" @click="update">Update</button>
                <button class="btn btn-xs btn-warning" @click="resetForm">Cancel</button>

                @can('update', $thread)
                    <form action="{{ $thread->path() }}" method="POST" class="ml-a">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger btn-sm">DELETE Thread</button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
    
    <div class="panel panel-default" v-else>
        <div class="panel-heading">
            <div class="level">
                <img src="{{ $thread->creator->avatar_path }}" alt="{{ $thread->creator->name }}" height="25" class="mr-1">
    
                <span class="flex">
                    <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }} </a> posted::
                    <span v-text="form.title"></span>
                </span>
            </div>
    
        </div>
    
        <div class="panel-body" v-html="form.body">
        </div>
    
        <div class="panel-footer" v-if="authorize('owns', thread)">
            <button @click=" editing = true " class="btn btn-xs">Edit</button>
        </div>
    </div>
</template>
