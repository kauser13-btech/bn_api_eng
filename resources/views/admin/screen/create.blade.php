@extends('layouts.app')

@section('content')

<form class="form-horizontal" action="{{ route('screen.store') }}" method="POST" enctype="multipart/form-data">
	@csrf

	<div class="col-md-12">
		<div class="row">
			<div class="col-md-7">
				<div class="card ">
					<div class="card-header card-header-rose card-header-text">
						<div class="card-text">
							<h4 class="card-title">Gallery Info</h4>
						</div>
					</div>
					<div class="card-body ">
						<div class="row">
							<label class="col-sm-2 col-form-label">Page</label>
							<div class="col-sm-10">
								<div class="form-group">
									<select id="Gtype" class="selectpicker" data-size="7" data-style="select-with-transition" name="type">
										<option value="e-paper">E-Paper</option>
										<option value="magazine">Magazine</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<label class="col-sm-2 col-form-label">Cover Photo</label>
							<div class="col-sm-9">
								<div class="form-group">
									<div class="fileinput fileinput-new text-center" data-provides="fileinput">
										<div class="fileinput-new thumbnail">
											<img src="{{ asset('admin/img/image_placeholder.jpg') }}" alt="...">
										</div>
										<div class="fileinput-preview fileinput-exists thumbnail"></div>
										<div>
											<span class="btn btn-rose btn-round btn-file">
												<span class="fileinput-new"><i class="material-icons">file_present</i></span>
												<span class="fileinput-exists">Change</span>
												<input type="file" name="cover_photo" />
											</span>
											<a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
										</div>
									</div>
								</div>
							</div>
						</div>

						{{-- <div class="row">
							<label class="col-sm-2 col-form-label">Date</label>
							<div class="col-sm-8">
								<div class="form-group">
									<input type="text" class="form-control datepicker" placeholder="Start publishing" name="start_at" value="{{ date('Y-m-d') }}">
								</div>
							</div>
							<label class="col-sm-2 label-on-right"><code>required</code></label>
						</div> --}}
						

					</div>
				</div>
			</div>

		</div>

		<div class="col-md-7">
			<div class="card-footer ml-auto mr-auto">
				<div class="col-md-12">
					<button type="submit" class="btn btn-rose">Submit</button>
				</div>
			</div>
		</div>
		
	</div>
</form>

@endsection

@push('breadcrumbs') screen Add @endpush

@push('meta')
	<title>Screen Add</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
@endpush