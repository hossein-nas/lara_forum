@extends('layouts.app')

@section('content')
    <thread-view inline-template :initial-replies-count="{{ $thread->replies_count }}">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                                <span class="flex">
                                    <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }} </a> posted:: 
                                    {{ $thread->title }}
                                </span>
                                @can('update', $thread)
                                    <form action="{{ $thread->path() }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger">DELETE Thread</button>
                                    </form>
                                @endcan
                            </div>
        
                        </div>
        
                        <div class="panel-body">
                            {{ $thread->body }}
                        </div>
                    </div>

                    <replies :data="{{ $thread->replies }}" 
                        @added="replies_count++"
                        @removed="replies_count--"
                        >
                            
                    </replies>

{{--                     @if( auth()->check() ) 
                        <form action="{{ $thread->path() . '/replies' }}" method="POST" >
                            {{ csrf_field() }}
                            <div class="form-group">
                                <textarea name="body" id="body" cols="30" rows="5" class="form-control" placeholder="Have something to say?"></textarea>
                            </div>
                            <button class="btn btn-default" type="submit">POST</button>
                            
                        </form>
                    @else
                        <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this dicussion.</p>
                    @endif
 --}}        
                </div>
        
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Meta Info</div>
                        <div class="panel-body">
                            This thread was published <strong>{{ $thread->created_at->diffForHumans()}}  </strong> <br/>
                            <strong>By :</strong> <a href="/user/JohnDoe">{{ $thread->creator->name }}</a> <br/>
                            Currently has <strong v-text="repliesCount"></strong>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
    </thread-view>
@endsection
