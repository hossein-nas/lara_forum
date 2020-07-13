@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
    <thread-view inline-template :initial-replies-count="{{ $thread->replies_count }}">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                                <img src="{{ $thread->creator->avatar_path }}" alt="{{ $thread->creator->name }}" height="25" class="mr-1">

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

                    <replies @added="replies_count++"
                             @removed="replies_count--"
                        >
                            
                    </replies>

                </div>
        
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Meta Info</div>
                        <div class="panel-body">
                            This thread was published <strong>{{ $thread->created_at->diffForHumans()}}  </strong> <br/>
                            <strong>By :</strong> <a href="/user/JohnDoe">{{ $thread->creator->name }}</a> <br/>
                            Currently has <strong v-text="repliesCount"></strong>
                            
                            <div>
                                <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        
        </div>
    </thread-view>
@endsection
