@extends ('layouts.app')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<form method="POST" action="{{ route('{{model_slug}}.update', ['{{model_slug}}' => ${{model_camel}}->getKey()]) }}">
					
					{{ csrf_field() }}
					{{ method_field('PATCH') }}
					<button type="submit" class="btn btn-primary">Submit</button>

				</form>
			</div>
		</div>
	</div>
	

@endsection