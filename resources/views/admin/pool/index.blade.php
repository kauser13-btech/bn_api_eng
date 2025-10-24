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
				<h4 class="card-title">Pool list <a href="{{ url('admin/pool/create') }}" class="btn btn-primary btn-sm pull-right">Add New</a></h4>
			</div>
			<div class="card-body">
				<div class="material-datatables">
					<table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
						<thead>
							<tr>
								<th>Sl. No</th>
								<th>Text</th>
								<th>Publish Date</th>
								<th>Status</th>
								<th>Created By</th>
								<th>Updated By</th>
								<th class="disabled-sorting text-right" width="10%">Actions</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl. No</th>
								<th>Text</th>
								<th>Publish Date</th>
								<th>Status</th>
								<th>Created By</th>
								<th>Updated By</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach($pool as $row)
								<tr>
									<td class="text-info">{{ $loop->index }}</td>
									<td class="text-primary">{{ $row->text }}</td>
									<td class="text-primary">{{ $row->start_date }}</td>
									<td>
										@if(date("Y-m-d",strtotime($row->start_date)) < date("Y-m-d"))
											<span class="badge badge-pill badge-danger">Expired</span>
										@elseif($row->p_status==1)
											<span class="badge badge-pill badge-success">Active</span>
										@else
											<span class="badge badge-pill badge-danger">Inactive</span>
										@endif
									</td>
									<td class="text-danger">{{ $row->createdBy->name }}</td>
									<td class="text-danger">{{ $row->updatedBy->name }}</td>
									<td class="text-right">
										<a href="{{ url('admin/pool/'.$row->id.'/edit') }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit_note</i></a>
										<form class="pull-right" method="POST" action="{{ route('pool.destroy', $row->id) }}">
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

@push('breadcrumbs') Menu List @endpush

@push('meta')
	<title>Menu List</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
@endpush