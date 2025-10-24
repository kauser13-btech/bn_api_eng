@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header card-header-primary card-header-icon">
				<div class="card-icon">
					<i class="material-icons">assignment</i>
				</div>
				<h4 class="card-title">Mob Home PopUp <a href="{{ url('admin/screen/create') }}" class="btn btn-primary btn-sm pull-right">Add New</a></h4>
			</div>
			<div class="card-body">
				<div class="material-datatables">
					<table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
						<thead>
							<tr>
								<th>Sl. No</th>
								<th>Page</th>
								<th>Cover Photo</th>
								<th>Date</th>
								<th>Created By</th>
								<th>Updated By</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl. No</th>
								<th>Page</th>
								<th>Cover Photo</th>
								<th>Date</th>
								<th>Created By</th>
								<th>Updated By</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach($list as $row)
							<tr>
								<td class="text-info">{{ $loop->index }}</td>
								<td class="text-info">{{ $row->type }}</td>
								<td class="text-primary text-center"><img src="{{ \App\Helpers\ImageStoreHelpers::showImage('screen',$row->s_date,$row->cover_photo,'thumb') }}"></td>
								<td class="text-primary">{{ $row->s_date }}</td>
								<td class="text-danger">{{ $row->createdBy->name }}</td>
								<td class="text-danger">{{ $row->updatedBy->name }}</td>
								<td class="text-right">
									<form class="pull-right" method="POST" action="{{ route('screen.destroy', $row->id) }}">
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