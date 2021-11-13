@extends('layouts.app')

@section('title', 'Edit Torrent - Torrentur')

@section("content")

@push('scripts')
<script type="text/javascript">
$(document).ready(function() {

	/* Edit Form */
	$("#edit-form").submit(function() {
		$.ajax({
			url: "/admin/torrent/update/{{$torrent->id}}",
			type: "POST",
			data: $("#edit-form").serialize(),
			success: function(data) {
				alert(data);
			},
			error: function(data){
				var errors = data.responseJSON;
				console.log(errors);
				for(var error in errors) alert(error);
				// Render the errors with js ...
			}
		})
		return false;
	});

});
</script>
@endpush

<!-- main-container start -->
<!-- ================ -->
<section class="main-container">
	<div class="container">
		<div class="row">
			<!-- main start -->
			<!-- ================ -->
			<div class="main col-md-12">
				<!-- page-title start -->
				<!-- ================ -->
				<h1 class="page-title"><i class="fa fa-money"></i> Torrent #{{$torrent->id}}</h1>
				<div class="separator-2"></div>
				<!-- page-title end -->

				@if (count($errors) > 0)
				    <div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif

				<form role="form" id="edit-form" class="margin-clear">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-group has-feedback">
						<label for="name3">Title</label>
						<input type="text" class="form-control" name="title" style="padding-right: 0px;" value="{{$torrent->title}}">
					</div>
					<div class="form-group has-feedback">
						<label for="name3">Description</label>
						<input type="text" class="form-control" name="description" style="padding-right: 0px;" value="{{$torrent->description}}">
					</div>
					<div class="form-group has-feedback">
						<label for="name3">Torrent URL</label>
						<input type="text" class="form-control" name="torrent_url" style="padding-right: 0px;" value="{{$torrent->torrent_url}}">
					</div>
					<div class="form-group">
						<label>Category</label>
						<select class="form-control" name="category_id">
							<option value="92">Videos</option>
							<option value="93">Audio</option>
							<option value="94">Application</option>
							<option value="95">Games</option>
							<option value="96">Porn</option>
							<option value="97">Other</option>
							<option value="98">Movies</option>
							<option value="99">TV Shows</option>

						</select>
					</div>
					<input type="submit" value="Submit" class="submit-button btn btn-default">
				</form>

			</div>
			<!-- main end -->

		</div>
	</div>
</section>
<!-- main-container end -->

@endsection
