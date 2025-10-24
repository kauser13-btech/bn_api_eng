@extends('layouts.app')

@section('content')

<form class="form-horizontal" action="{{ route('gallery.categorystore') }}" method="POST">
	@csrf

	<div class="col-md-12">
		@if (Session::has('success'))
			<script type="text/javascript">
				setTimeout(function() {
			        md.showNotification('top','center','success',"{{ Session::get('success') }}").trigger('click');
			    },100);
			</script>
		@endif
		@if (Session::has('unauthorized'))
			<script type="text/javascript">
				setTimeout(function() {
			        md.showNotification('top','center','danger',"{{ Session::get('unauthorized') }}").trigger('click');
			    },100);
			</script>
		@endif
		<div class="row">
			<div class="col-md-6">
				<div class="card ">
					<div class="card-header card-header-rose card-header-text">
						<div class="card-text">
							<h4 class="card-title">Category Info</h4>
						</div>
					</div>
					<div class="card-body ">
						<div class="row">
							<label class="col-sm-2 col-form-label">Name</label>
							<div class="col-sm-8">
								<div class="form-group">
									<input type="text" class="form-control" name="name" required="">
								</div>
							</div>
							<label class="col-sm-2 label-on-right"><code>required</code></label>
						</div>
						<div class="row">
							<label class="col-sm-2 col-form-label">Type</label>
							<div class="col-sm-8">
								<div class="form-group">
									<select id="Gtype" class="selectpicker" data-size="7" data-style="select-with-transition" name="type">
										<option value="photo">Photo</option>
										<option value="video">Video</option>
									</select>
								</div>
							</div>
							<label class="col-sm-2 label-on-right"><code>required</code></label>
						</div>
						<div class="row">
							<label class="col-sm-2 col-form-label">Status</label>
							<div class="col-sm-8">
								<div class="form-group">
									<div class="form-check">
										<label class="form-check-label">
											<input class="form-check-input" type="radio" name="g_status" value="1" checked> Active
											<span class="circle"><span class="check"></span></span>
										</label>
									</div>
									<div class="form-check">
										<label class="form-check-label">
											<input class="form-check-input" type="radio" name="g_status" value="0"> Inactive
											<span class="circle"><span class="check"></span></span>
										</label>
									</div>
								</div>
							</div>
							<label class="col-sm-2 label-on-right"><code>required</code></label>
						</div>
					</div>

					<div class="card-footer">
						<button type="submit" class="btn btn-rose">Submit</button>
					</div>

				</div>
			</div>

			<div class="col-md-6">
				<div class="card ">
					<div class="card-header card-header-rose card-header-text">
						<div class="card-text">
							<h4 class="card-title">List</h4>
						</div>
					</div>
					<div class="card-body ">
						<table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
							<thead>
						        <tr>
						            <th class="text-center">#</th>
						            <th>Name</th>
						            <th>Type</th>
						            <th>Status</th>
						            <th class="text-right">Actions</th>
						        </tr>
						    </thead>
							<tfoot>
								<tr>
						            <th class="text-center">#</th>
						            <th>Name</th>
						            <th>Type</th>
						            <th>Status</th>
						            <th class="text-right">Actions</th>
						        </tr>
							</tfoot>
							<tbody>
								@foreach($catlist as $row)
						        <tr>
						            <td class="text-center">{{ $loop->index }}</td>
						            <td>{{ $row->name }}</td>
						            <td>{{ $row->type }}</td>
						            <td>
						            	@if($row->g_status==1)
											<span class="badge badge-pill badge-success">Active</span>
										@else
											<span class="badge badge-pill badge-danger">Inactive</span>
										@endif
						            </td>
						            <td class="td-actions text-right">
										<a href="{{ url('admin/gallery/category/'.$row->id.'/edit') }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit_note</i></a>
										<form class="pull-right" method="POST" action="{{ url('admin/gallery/category/destroy') }}">
											@csrf
											<input type="hidden" name="id" value="{{ $row->id }}">
											<button type="submit" class="btn btn-link btn-danger btn-just-icon remove" onclick="return confirm('Are you sure you want to delete this item?');"><i class="material-icons">close</i></button>
										</form>
									</td>
						        </tr>
						        @endforeach
						    </tbody>
						</table>

					</div>
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
@endpush