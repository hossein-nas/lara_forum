@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection

@section('content')
    <thread-view inline-template :thread="{{ $thread }}">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @include('threads._question') 

                    <replies @added="replies_count++"
                             @removed="replies_count--"
                             :locked="locked"
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
                            
                            <div class="mt-1">
                                <subscribe-button v-show="signedIn" :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                                <button class="btn " 
                                        :class="locked ? 'btn-success' : 'btn-danger'"
                                        v-if="authorize('isAdmin')" 
                                        @click="toggleLock" 
                                        v-text="locked? 'Unlock' : 'Lock' "
                                ></button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        
        </div>
    </thread-view>
@endsection
