@extends('layouts.app');

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="page-header">

					<div>
						<h2>
							{{ $profileUser->name }} <br>
						</h2>
						Since {{ $profileUser->created_at->diffForHumans() }}
					</div>

					@can('update', $profileUser)
						<form action="{{ route('avatar', $profileUser) }}" method="POST" enctype="multipart/form-data">
							{{  csrf_field() }}	
							<div class="form-group">
								<label for="avatarPhoto">Select Avatar</label>
								<input type="file" name="avatar" id="avatar">
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-small">Add Avatar</button>
							</div>
						</form>
					@endcan

					<img src="{{ asset($profileUser->avatar()) }}" alt="" width="200">
				</div>
				
				@forelse( $activities as  $date => $values)
					<div class="text-center page-header">
						{{ Carbon\Carbon::parse($date)->format('jS \of F Y')}}
					</div>
					@foreach($values as $activity)
						@if( view()->exists("activities.{$activity->type}"))
							@include("activities.{$activity->type}")
						@endif
					@endforeach

				@empty
					<p class="text-center">
					There is not activity for this user yet.
				</p>
				@endforelse
			</div>
		</div>
	</div>	
@endsection