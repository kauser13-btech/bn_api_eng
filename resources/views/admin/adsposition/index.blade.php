@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header card-header-primary card-header-icon">
				<div class="card-icon">
					<i class="material-icons">assignment</i>
				</div>
				<h4 class="card-title">Desktop Ad Position List <a href="{{ url('admin/adsposition/create?for=desktop') }}" class="btn btn-primary btn-sm pull-right">Add New</a></h4>
			</div>
			<div class="card-body">
				<div class="material-datatables">
					<table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
						<thead>
							<tr>
								<th>Sl. No</th>
								<th>Position Name</th>
								<th>Page</th>
								<th>Status</th>
								<th>Created By</th>
								<th>Updated By</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl. No</th>
								<th>Position Name</th>
								<th>Page</th>
								<th>Status</th>
								<th>Created By</th>
								<th>Updated By</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach($position->where('device','desktop') as $drow)
							<tr>
								<td class="text-info">{{ $loop->index }}</td>
								<td class="text-primary">{{ $drow->name }}</td>
								<td class="text-primary">{{ $drow->slug }}</td>
								<td>
									@if($drow->status==1)
										<span class="badge badge-pill badge-success">Active</span>
									@else
										<span class="badge badge-pill badge-danger">Inactive</span>
									@endif
								</td>
								<td class="text-danger">{{ $drow->createdBy->name }}</td>
								<td class="text-danger">@if($drow->updatedBy) {{ $drow->updatedBy->name }} @endif</td>
								<td class="text-right">
									<a href="{{ url('admin/adsposition/'.$drow->id.'/edit') }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit_note</i></a>
									<form class="pull-right" method="POST" action="{{ route('adsposition.destroy', $drow->id) }}">
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
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header card-header-primary card-header-icon">
				<div class="card-icon">
					<i class="material-icons">assignment</i>
				</div>
				<h4 class="card-title">Mobile Ad Position List <a href="{{ url('admin/adsposition/create?for=mobile') }}" class="btn btn-primary btn-sm pull-right">Add New</a></h4>
			</div>
			<div class="card-body">
				<div class="material-datatables">
					<table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
						<thead>
							<tr>
								<th>Sl. No</th>
								<th>Position Name</th>
								<th>Page</th>
								<th>Status</th>
								<th>Created By</th>
								<th>Updated By</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl. No</th>
								<th>Position Name</th>
								<th>Page</th>
								<th>Status</th>
								<th>Created By</th>
								<th>Updated By</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach($position->where('device','mobile') as $mrow)
							<tr>
								<td class="text-info">{{ $loop->index }}</td>
								<td class="text-primary">{{ $mrow->name }}</td>
								<td class="text-primary">{{ $mrow->slug }}</td>
								<td>
									@if($mrow->status==1)
										<span class="badge badge-pill badge-success">Active</span>
									@else
										<span class="badge badge-pill badge-danger">Inactive</span>
									@endif
								</td>
								<td class="text-danger">{{ $mrow->createdBy->name }}</td>
								<td class="text-danger">@if($mrow->updatedBy) {{ $mrow->updatedBy->name }} @endif</td>
								<td class="text-right">
									<a href="{{ url('admin/adsposition/'.$mrow->id.'/edit') }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit_note</i></a>
									<form class="pull-right" method="POST" action="{{ route('adsposition.destroy', $mrow->id) }}">
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
		</div>
	</div>
</div>

@endsection

@push('breadcrumbs') Ads Position @endpush

@push('meta')
	<title>{{ config('app.name', 'Laravel') }}</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
@endpush