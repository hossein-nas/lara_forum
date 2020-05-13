@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						Create New Thread	
					</div>

					<div class="panel-body">
						<form action="/threads" method="POST">
							{{ csrf_field() }}
							<div class="form-group">
								<label for="title">Title: </label>
								<input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" >
							</div>

							<div class="form-group">
								<label for="title">Channel: </label>
								<select name="channel_id" id="channel_id" class="form-control">
									<option value="">-- SELECT ONE ITEM --</option>
									@foreach(App\Channel::all() as $channel )
										<option value="{{ $channel->id }}" 
											{{ $channel->id == old('channel_id')? 'selected' : '' }}
											>
												{{ $channel->name }}
											</option>
									@endforeach
								</select>
							</div>

							<div class="form-group">
								<label for="body">Body: </label>
								<textarea name="body" id="body" cols="30" rows="5" class="form-control">{{ old('body') }}</textarea>
							</div>

							<div class="form-group">
								<button class="btn btn-primary" type="submit" >Publish</button>
							</div>
						</form>

						@if( count($errors) )
							<div class="alert alert-danger">
								@foreach( $errors->all() as $error )
									<p>{{ $error }}</p>
								@endforeach	
							</div>
						@endif

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection