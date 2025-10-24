@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header card-header-primary card-header-icon">
				<div class="card-icon">
					<i class="material-icons">assignment</i>
				</div>
				<h4 class="card-title">Desktop Ad Position List <a href="{{ url('admin/ads/create?for=desktop') }}" class="btn btn-primary btn-sm pull-right">Add New</a><a href="{{ url('admin/ads/desktop') }}" class="btn btn-primary btn-sm pull-right">Show All</a></h4>
			</div>
			<div class="card-body">
				<div class="material-datatables">
					<table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
						<thead>
							<tr>
								<th>Sl. No</th>
								<th>Position Name</th>
								<th>Position Slug</th>
								<th>Page</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl. No</th>
								<th>Position Name</th>
								<th>Position Slug</th>
								<th>Page</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach($AdsPosition->where('device','desktop') as $drow)
							<tr>
								<td class="text-info">{{ $loop->index }}</td>
								<td class="text-primary">{{ $drow->name }}</td>
								<td class="text-primary">{{ $drow->slug }}</td>
								<td class="text-primary">{{ $drow->page }}</td>
								<td class="text-right">
									<a href="{{ url('admin/ads/desktop?position='.$drow->slug) }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">list</i></a>
									<a href="{{ url('admin/ads/create?for=desktop&page='.$drow->page.'&position='.$drow->slug) }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">add</i></a>
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
				<h4 class="card-title">Mobile Ad Position List <a href="{{ url('admin/ads/create?for=mobile') }}" class="btn btn-primary btn-sm pull-right">Add New</a><a href="{{ url('admin/ads/mobile') }}" class="btn btn-primary btn-sm pull-right">Show All</a></h4>
			</div>
			<div class="card-body">
				<div class="material-datatables">
					<table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
						<thead>
							<tr>
								<th>Sl. No</th>
								<th>Position Name</th>
								<th>Position Slug</th>
								<th>Page</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl. No</th>
								<th>Position Name</th>
								<th>Position Slug</th>
								<th>Page</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach($AdsPosition->where('device','mobile') as $drow)
							<tr>
								<td class="text-info">{{ $loop->index }}</td>
								<td class="text-primary">{{ $drow->name }}</td>
								<td class="text-primary">{{ $drow->slug }}</td>
								<td class="text-primary">{{ $drow->page }}</td>
								<td class="text-right">
									<a href="{{ url('admin/ads/mobile?position='.$drow->slug) }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">list</i></a>
									<a href="{{ url('admin/ads/create?for=mobile&page='.$drow->page.'&position='.$drow->slug) }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">add</i></a>
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