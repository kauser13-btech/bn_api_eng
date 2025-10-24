@extends('layouts.app')

@section('content')


<div class="row">
	<div class="col-md-12">

		@if (Session::has('success'))
			<script type="text/javascript">
				setTimeout(function() {
			        md.showNotification('top','center','success',"{{ Session::get('success') }}").trigger('click');
			    },100);
			</script>
		@endif

		<form class="form-horizontal" action="{{ route('adsposition.update', $position->id) }}" method="POST">
			@csrf
			@method('PATCH')

			<div class="card ">
				<div class="card-header card-header-rose card-header-text">
					<div class="card-text">
						<h4 class="card-title">Create New Ads Position</h4>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<label class="col-sm-2 col-form-label">Position Name</label>
						<div class="col-sm-7">
							<div class="form-group">
								<input class="form-control" type="text" name="name" required="true" value="{{ $position->name }}" />
							</div>
							@error('name')
								<p class="text-danger">{{ $message }}</p>
							@enderror
						</div>
						<label class="col-sm-3 label-on-right"><code>required</code></label>
					</div>
					<div class="row">
						<label class="col-sm-2 col-form-label">Position Slug</label>
						<div class="col-sm-7">
							<div class="form-group">
								<input class="form-control" type="text" name="slug" required="true" placeholder="device-page-slug" value="{{ $position->slug }}" />
							</div>
							@error('slug')
								<p class="text-danger">{{ $message }}</p>
							@enderror
						</div>
						<label class="col-sm-3 label-on-right"><code>required</code></label>
					</div>
					<div class="row">
						<label class="col-sm-2 col-form-label">Page</label>
						<div class="col-sm-7">
							<div class="form-group">
								<select class="selectpicker" data-style="select-with-transition" title="Choose Page" data-size="7" name="page">
									<option @if($position->page=='home') selected @endif value="home">Home</option>
									<option @if($position->page=='category') selected @endif value="category">Category</option>
									<option @if($position->page=='details') selected @endif value="details">Details</option>
								</select>
							</div>
							@error('page')
								<p class="text-danger">{{ $message }}</p>
							@enderror
						</div>
						<label class="col-sm-3 label-on-right"><code>required</code></label>
					</div>
					<div class="row">
						<label class="col-sm-2 col-form-label">Device</label>
						<div class="col-sm-7">
							<div class="form-group">
								<select class="selectpicker" data-style="select-with-transition" title="Choose Version" data-size="7" name="device" readonly>
									<option value="desktop" @if($position->device=='desktop') selected @endif>Desktop</option>
									<option value="mobile" @if($position->device=='mobile') selected @endif>Mobile</option>
								</select>
							</div>
							@error('device')
								<p class="text-danger">{{ $message }}</p>
							@enderror
						</div>
						<label class="col-sm-3 label-on-right"><code>required</code></label>
					</div>
					<div class="row">
						<label class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-7">
							<div class="form-group">
								<select class="selectpicker" data-style="select-with-transition" title="Choose Status" data-size="7" name="status">
									<option @if($position->status=='1') selected @endif value="1">Active</option>
									<option @if($position->status=='0') selected @endif value="0">Inactive</option>
								</select>
							</div>
						</div>
						<label class="col-sm-3 label-on-right"><code>required</code></label>
					</div>
				</div>
				<div class="card-footer ml-auto mr-auto">
					<button type="submit" class="btn btn-rose">Update</button>
				</div>
			</div>
		</form>
	</div>
</div>
        

@endsection

@push('breadcrumbs') Ads Position Create @endpush

@push('meta')
	<title>{{ config('app.name', 'Laravel') }}</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
@endpush