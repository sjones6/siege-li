@extends ('layouts.app')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<form method="POST" action="{{ route('{{model_slug}}.store', ['{{model_slug}}' => ${{model_camel}}->getKey()]) }}">
					

					{{ csrf_field() }}
					<button type="submit" class="btn btn-primary">Submit</button>

				</form>
			</div>
		</div>
	</div>
	

@endsection