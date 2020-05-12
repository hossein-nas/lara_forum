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
								<input type="text" class="form-control" id="title" name="title" >
							</div>

							<div class="form-group">
								<label for="body">Body: </label>
								<textarea name="body" id="body" cols="30" rows="5" class="form-control"></textarea>
							</div>

							<div class="form-group">
								<button class="btn btn-primary" type="submit" >Publish</button>
							</div>
						</form>
						
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection