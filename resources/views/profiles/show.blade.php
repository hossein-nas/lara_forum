@extends('layouts.app');

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="page-header">
					<h2>
						{{ $profileUser->name }} <br>
					</h2>
					Since {{ $profileUser->created_at->diffForHumans() }}
				
				</div>
				
				@foreach( $threads as $thread )
				
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="level">
								<div class="flex">
									<a href="/profiles/{{ $profileUser->name }}">{{ $thread->creator->name }}</a> created :: 
									<a href="{{ $thread->path() }}">{{ $thread->title }}</a>
								</div>
								
								{{ $thread->created_at->diffForHumans() }}...
							</div>
						</div>
						<div class="panel-body">
							{{ $thread->body }}
						</div>
					</div>
				
				@endforeach
				{{ $threads->links() }}
			</div>
		</div>
	</div>	
@endsection