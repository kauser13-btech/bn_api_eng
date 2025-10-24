@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header card-header-primary card-header-icon">
				<div class="card-icon">
					<i class="material-icons">assignment</i>
				</div>
				<h4 class="card-title">User List</h4>
			</div>
			<div class="card-body">
				<div class="material-datatables">
					<table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
						<thead>
							<tr>
								<th>Sl. No</th>
								<th>Name</th>
								<th>Email</th>
								<th>Role</th>
								<th>Type</th>
								<th>Status</th>
								<th>Created By</th>
								<th>Updated By</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl. No</th>
								<th>Name</th>
								<th>Email</th>
								<th>Role</th>
								<th>Type</th>
								<th>Status</th>
								<th>Created By</th>
								<th>Updated By</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach($User as $row)
							<tr>
								<td class="text-info">{{ $loop->index }}</td>
								<td class="text-primary">{{ $row->name }}</td>
								<td class="text-primary">{{ $row->email }}</td>
								<td class="text-primary">{{ $row->role }}</td>
								<td class="text-primary">{{ $row->type }}</td>
								<td>
									@if($row->status==1)
										<span class="badge badge-pill badge-success">Active</span>
									@else
										<span class="badge badge-pill badge-danger">Inactive</span>
									@endif
								</td>
								<td class="text-danger">{{ $row->createdBy->name }}</td>
								<td class="text-danger">@if($row->updatedBy) {{ $row->updatedBy->name }} @endif</td>
								<td class="text-right">
									<a href="{{ url('admin/user/'.$row->id.'/edit') }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit_note</i></a>
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

@push('breadcrumbs') User List @endpush

@push('meta')
	<title>{{ config('app.name', 'Laravel') }}</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
@endpush