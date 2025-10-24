@extends('layouts.app')

@section('content')

<form class="form-horizontal" action="{{ route('pool.update', $pool->id) }}" method="POST">
	@csrf
	@method('PATCH')

	@if (Session::has('success'))
		<script type="text/javascript">
			setTimeout(function() {
		        md.showNotification('top','center','success',"{{ Session::get('success') }}").trigger('click');
		    },100);
		</script>
	@endif

	<div class="col-md-12">
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
									<textarea class="form-control" name="text" rows="18" cols="50">{!! $pool->text !!}</textarea>
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
							<h4 class="card-title">Option Settings</h4>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<label class="col-sm-4 col-form-label">Option 1</label>
							<div class="col-sm-5">
								<div class="form-group">
									<input type="text" class="form-control" name="option_1" value="{!! $pool->option_1 !!}">
								</div>
							</div>
							<div class="col-sm-3 pt-4">Vote: <code>{{ $pool->vote_1 }}</code></div>
						</div>
						<div class="row">
							<label class="col-sm-4 col-form-label">Option 2</label>
							<div class="col-sm-5">
								<div class="form-group">
									<input type="text" class="form-control" name="option_2" value="{!! $pool->option_2 !!}">
								</div>
							</div>
							<div class="col-sm-3 pt-4">Vote: <code>{{ $pool->vote_2 }}</code></div>
						</div>
						<div class="row">
							<label class="col-sm-4 col-form-label">Option 3</label>
							<div class="col-sm-5">
								<div class="form-group">
									<input type="text" class="form-control" name="option_3" value="{!! $pool->option_3 !!}">
								</div>
							</div>
							<div class="col-sm-3 pt-4">Vote: <code>{{ $pool->vote_3 }}</code></div>
						</div>

					</div>
				</div>

				<div class="card ">
					<div class="card-header card-header-rose card-header-text">
						<div class="card-text">
							<h4 class="card-title">Publishing</h4>
						</div>
					</div>
					<div class="card-body ">
						<div class="col-md-12">
							<div class="row">
								<label class="col-sm-2 col-form-label">Start publishing</label>
								<div class="col-sm-8">
									<div class="form-group">
										<input name="start_date" type="text" class="form-control datetimepicker" placeholder="Start publishing" value="{{ $pool->start_date }}">
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
													<input name="p_status" class="form-check-input" type="radio" value="1" @if($pool->p_status==1) checked @endif> Active
													<span class="circle"><span class="check"></span></span>
												</label>
											</div>
											<div class="form-check">
												<label class="form-check-label">
													<input name="p_status" class="form-check-input" type="radio" value="0" @if($pool->p_status==0) checked @endif> Inactive
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