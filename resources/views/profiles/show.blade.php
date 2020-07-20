@extends('layouts.app')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="page-header">
					<avatar-form :user="{{ $profileUser }}"></avatar-form>
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