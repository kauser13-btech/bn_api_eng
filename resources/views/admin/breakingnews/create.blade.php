@extends('layouts.app')

@section('content')

<form class="form-horizontal" action="{{ route('breakingnews.store') }}" method="POST">
	@csrf
	<div class="col-md-12">
		@if (Session::has('success'))
			<script type="text/javascript">
				setTimeout(function() {
			        md.showNotification('top','center','success',"{{ Session::get('success') }}").trigger('click');
			    },100);
			</script>
		@endif
		<div class="row">
			<div class="col-md-7">
				<div class="card ">
					<div class="card-header card-header-rose card-header-text">
						<div class="card-text">
							<h4 class="card-title">Text</h4>
						</div>
					</div>
					<div class="card-body ">
						<div class="row">
							<label class="col-sm-2 col-form-label">Text</label>
							<div class="col-sm-9">
								<div class="form-group">
									<textarea class="form-control" name="text" rows="5" cols="50"></textarea>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

			<div class="col-md-5">
				<div class="card ">
					<div class="card-header card-header-rose card-header-text">
						<div class="card-text">
							<h4 class="card-title">Publishing</h4>
						</div>
					</div>
					<div class="card-body ">
						<div class="col-md-12">
							<div class="row">
								<label class="col-sm-2 col-form-label">Start At</label>
								<div class="col-sm-8">
									<div class="form-group">
										<input name="start_at" type="text" class="form-control datetimepicker" placeholder="Start publishing" value="{{ date('Y-m-d H:i:s') }}">
									</div>	
								</div>
								<label class="col-sm-2 label-on-right"><code>required</code></label>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row">
								<label class="col-sm-2 col-form-label">End At</label>
								<div class="col-sm-8">
									<div class="form-group">
										<input name="end_at" type="text" class="form-control datetimepicker" placeholder="End publishing">
									</div>	
								</div>
								<label class="col-sm-2 label-on-right"><code>required</code></label>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<div class="row">
									<label class="col-sm-2 col-form-label">Status</label>
									<div class="col-sm-8">
										<div class="form-group">
											<div class="form-check">
												<label class="form-check-label">
													<input class="form-check-input" type="radio" name="b_status" value="1" checked> Active
													<span class="circle"><span class="check"></span></span>
												</label>
											</div>
											<div class="form-check">
												<label class="form-check-label">
													<input class="form-check-input" type="radio" name="b_status" value="0"> Inactive
													<span class="circle"><span class="check"></span></span>
												</label>
											</div>
										</div>
									</div>
									<label class="col-sm-2 label-on-right"><code>required</code></label>
								</div>
							</div>
						</div>

					</div>
	                    
				</div>

			</div>
		</div>

		<div class="col-md-12">
			<div class="card-footer ml-auto mr-auto">
				<div class="col-md-12">
					<button type="submit" class="btn btn-rose">Submit</button>
				</div>
			</div>
		</div>
		
	</div>
</form>

@endsection

@push('breadcrumbs') News Add @endpush

@push('meta')
	<title>News Add</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
<script src="{{ asset('admin/ckeditor/ckeditor.js') }}"></script>
<script>
	var options = {
		filebrowserImageBrowseUrl: '/admin/news-filemanager?type=Images',
		filebrowserImageUploadUrl: '/admin/news-filemanager/upload?type=Images&_token=',
		filebrowserBrowseUrl: '/admin/news-filemanager?type=Files',
		filebrowserUploadUrl: '/admin/news-filemanager/upload?type=Files&_token='
	};
	CKEDITOR.replace('editor', options);
	
	</script>
@endpush