@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-12">

		@if (Session::has('success'))
			<script type="text/javascript">
				setTimeout(function() {
			        md.showNotification('top','center','danger',"{{ Session::get('success') }}").trigger('click');
			    },100);
			</script>
		@endif

		<div class="card">
			<div class="card-header card-header-primary card-header-icon">
				<div class="card-icon">
					<i class="material-icons">assignment</i>
				</div>
				<h4 class="card-title">Menu List <a href="{{ url('admin/menu/create') }}" class="btn btn-primary btn-sm pull-right">Add New</a></h4>
			</div>
			<div class="card-body">
				<div class="material-datatables">
					<table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
						<thead>
							<tr>
								<th>Id. No</th>
								<th>Order</th>
								<th>Edition</th>
								<th>Name</th>
								<th>Slug</th>
								<th>Parent Menu</th>
								<th>Status</th>
								<th>Created By</th>
								<th>Updated By</th>
								<th class="disabled-sorting text-right" width="10%">Actions</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Id. No</th>
								<th>Order</th>
								<th>Edition</th>
								<th>Name</th>
								<th>Slug</th>
								<th>Parent Menu</th>
								<th>Status</th>
								<th>Created By</th>
								<th>Updated By</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach($Menus as $row)
							<tr>
								<td class="text-info">{{ $row->m_id }}</td>
								<td class="text-info">{{ $row->m_order }}</td>
								<td class="text-info">{{ $row->m_edition }}</td>
								<td class="text-primary">{{ $row->m_name }}</td>
								<td class="text-info">{{ $row->slug }}</td>
								<td class="text-primary">{{ $row->m_parent ? $Menus->where('m_id',$row->m_parent)->first()->m_name : ''}}</td>
								<td>
									@if($row->m_status==1)
										<span class="badge badge-pill badge-success">Active</span>
									@else
										<span class="badge badge-pill badge-danger">Inactive</span>
									@endif
								</td>
								<td class="text-danger">{{ $row->createdBy->name }}</td>
								<td class="text-danger">@if($row->updatedBy) {{ $row->updatedBy->name }} @endif</td>
								<td class="text-right">
									<a href="{{ url('admin/menu/'.$row->m_id.'/edit') }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit_note</i></a>
									<form class="pull-right" method="POST" action="{{ route('menu.destroy', $row->m_id) }}">
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
	<title>{{ config('app.name', 'Laravel') }}</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
@endpush