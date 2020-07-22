@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @include('threads._list')
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        :: Searching Panel ::
                    </div>
                    <div class="panel-body">
                        <form action="/threads/search" method="GET">
                            <div class="form-inline">
                                <div class="form-group">
                                    <input type="text" name="q" class="form-control" placeholder="Search something...">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if( count($trending) ) 
                <div class="panel panel-default">
                    <div class="panel-heading">
                        :: Trending Threads ::
                    </div>
                    <div class="panel-body">
                        <ul class="list-group">
                            @foreach ($trending as $thread)
                            <li class="list-group-item">
                                <a href="{{ url($thread->path) }}">{{ $thread->title }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
