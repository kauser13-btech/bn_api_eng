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
		<div class="card">
			<div class="card-header card-header-primary card-header-icon">
				<div class="card-icon">
					<i class="material-icons">assignment</i>
				</div>
				<h4 class="card-title">Photo gallery</h4>
			</div>
			<div class="card-body">
				<div class="material-datatables">
					<table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
						<thead>
							<tr>
								<th>Sl. No</th>
								<th>Album</th>
								<th>Status</th>
								<th>Category</th>
								<th>Post By / Post Time</th>
								<th>Edit By / Edit Time</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl. No</th>
								<th>Album</th>
								<th>Status</th>
								<th>Category</th>
								<th>Post By / Post Time</th>
								<th>Edit By / Edit Time</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach($photo as $prow)
							<tr>
								<td class="text-info">{{ $loop->index }}</td>
								<td><a href="#" class="text-primary">{{ $prow->name }}</a></td>
								<td>
									@if($prow->status==1)
										<span class="badge badge-pill badge-success">Active</span>
									@else
										<span class="badge badge-pill badge-danger">Inactive</span>
									@endif
								</td>
								<td class="text-danger">{{ $prow->catName->name }}</td>
								<td class="text-danger">{{ $prow->createdBy->name }} <span class="text-warning">{{ $prow->start_at }}</span></td>
								<td class="text-danger">{{ $prow->updatedBy->name }} <span class="text-warning">{{ $prow->edit_at }}</span></td>
								<td class="text-right">
									<a href="{{ url('admin/gallery/'.$prow->id.'/edit') }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit_note</i></a>
									<form class="pull-right" method="POST" action="{{ route('gallery.destroy', $prow->id) }}">
										@csrf @method('DELETE')
										<button type="submit" class="btn btn-link btn-danger btn-just-icon remove" onclick="return confirm('Are you sure you want to delete this item?');"><i class="material-icons">close</i></button>
									</form>

								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer">
				{{ $photo->links() }}
			</div>
		</div>

		<div class="card">
			<div class="card-header card-header-primary card-header-icon">
				<div class="card-icon">
					<i class="material-icons">assignment</i>
				</div>
				<h4 class="card-title">Video gallery</h4>
			</div>
			<div class="card-body">
				<div class="material-datatables">
					<table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
						<thead>
							<tr>
								<th>Sl. No</th>
								<th>Album</th>
								<th>Status</th>
								<th>Is Home</th>
								<th>Category</th>
								<th>Post By / Post Time</th>
								<th>Edit By / Edit Time</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl. No</th>
								<th>Album</th>
								<th>Status</th>
								<th>Is Home</th>
								<th>Category</th>
								<th>Post By / Post Time</th>
								<th>Edit By / Edit Time</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach($video as $prow)
							<tr>
								<td class="text-info">{{ $loop->index }}</td>
								<td><a href="#" class="text-primary">{{ $prow->name }}</a></td>
								<td>
									@if($prow->status==1)
										<span class="badge badge-pill badge-success">Active</span>
									@else
										<span class="badge badge-pill badge-danger">Inactive</span>
									@endif
								</td>
								<td>
									<span class="badge badge-pill badge-warning">{{ $prow->special_video == 1 ? 'yes' : '' }}</span>
								</td>
								<td class="text-danger">{{ $prow->catName->name }}</td>
								<td class="text-danger">{{ $prow->createdBy->name }} <span class="text-warning">{{ $prow->start_at }}</span></td>
								<td class="text-danger">{{ $prow->updatedBy->name }} <span class="text-warning">{{ $prow->edit_at }}</span></td>
								<td class="text-right">
									<a href="{{ url('admin/gallery/'.$prow->id.'/edit') }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit_note</i></a>
									<form class="pull-right" method="POST" action="{{ route('gallery.destroy', $prow->id) }}">
										@csrf @method('DELETE')
										<button type="submit" class="btn btn-link btn-danger btn-just-icon remove" onclick="return confirm('Are you sure you want to delete this item?');"><i class="material-icons">close</i></button>
									</form>

								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer">
				{{ $video->links() }}
			</div>
		</div>
	
	</div>
</div>
		
@endsection

@push('breadcrumbs') Gallery @endpush

@push('meta')
	<title>{{ config('app.name', 'Laravel') }}</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
@endpush