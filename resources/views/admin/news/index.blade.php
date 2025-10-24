@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header card-header-primary card-header-icon">
				<div class="card-icon">
					<i class="material-icons">assignment</i>
				</div>
				<h4 class="card-title">{{ Request::get('edition') }} Menu List @if(Request::get('edition')=='online')<a href="{{ url('admin/news/create?edition=online') }}" class="btn btn-primary btn-sm pull-right">Add New</a>@endif</h4>
			</div>
			<div class="card-body">
				<div class="material-datatables">
					<table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
						<thead>
							<tr>
								<th>Sl. No</th>
								<th>Name</th>
								<th>Slug</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl. No</th>
								<th>Name</th>
								<th>Slug</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach($menus as $row)
							<tr>
								<td class="text-info">{{ $loop->index }}</td>
								<td class="text-primary">{{ $row->m_name }}</td>
								<td class="text-info">{{ $row->slug }}</td>
								<td class="text-right">
									@if(Request::get('edition')=='online')
										<a href="{{ url('admin/news/create?edition=online&mid='.$row->m_id) }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">note_add</i></a>
										<a href="{{ url('admin/news/'.$row->m_id.'?edition=online') }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">view_list</i></a>
									@elseif(Request::get('edition')=='multimedia')
										<a href="{{ url('admin/news/create?edition=multimedia&mid='.$row->m_id) }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">note_add</i></a>
										<a href="{{ url('admin/news/'.$row->m_id.'?edition=multimedia') }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">view_list</i></a>
									@else
										<a href="{{ url('admin/news/create?edition=print&mid='.$row->m_id) }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">note_add</i></a>
										<a href="{{ url('admin/news/'.$row->m_id.'?edition=print') }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">view_list</i></a>
									@endif
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

@if(Request::get('edition')=='print')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header card-header-primary card-header-icon">
				<div class="card-icon">
					<i class="material-icons">assignment</i>
				</div>
				<h4 class="card-title">Magazine Manager</h4>
			</div>
			<div class="card-body">
				<div class="material-datatables">
					<table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
						<thead>
							<tr>
								<th>Sl. No</th>
								<th>Name</th>
								<th>Slug</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl. No</th>
								<th>Name</th>
								<th>Slug</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach($magazine as $Mrow)
							<tr>
								<td class="text-info">{{ $loop->index }}</td>
								<td class="text-primary">{{ $Mrow->m_name }}</td>
								<td class="text-info">{{ $Mrow->slug }}</td>
								<td class="text-right">
									<a href="{{ url('admin/news/create?edition=magazine&mid='.$Mrow->m_id) }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">note_add</i></a>
									<a href="{{ url('admin/news/'.$Mrow->m_id.'?edition=magazine') }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">view_list</i></a>
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
@endif

@endsection

@push('breadcrumbs') Menu List @endpush

@push('meta')
	<title>{{ config('app.name', 'Laravel') }}</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
@endpush