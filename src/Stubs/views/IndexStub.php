@extends ('layouts.app')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				@foreach (${{model_camel}}s as ${{model_camel}})

				@endforeach
			</div>
		</div>
	</div>
	

@endsection