@extends('layouts.app')

@section('content')

<div class="col-md-12">
	<div class="row">

		<div class="col-md-6">
			<div class="row">
				
				<div class="col-md-6">
					<div class="card ">
						<div class="card-body text-center">
							<h5 class="card-text">Lead News</h5>
							<a href="{{ url('admin/news/sortnews/leadnews?edition=online') }}" class="btn btn-rose btn-fill">Sorting</a>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card ">
						<div class="card-body text-center">
							<h5 class="card-text">Highlight</h5>
							<a href="{{ url('admin/news/sortnews/highlight?edition=online') }}" class="btn btn-rose btn-fill">Sorting</a>
						</div>
					</div>
				</div>
				{{-- <div class="col-md-6">
					<div class="card ">
						<div class="card-body text-center">
							<h5 class="card-text">Focus News</h5>
							<a href="{{ url('admin/news/sortnews/focus?edition=online') }}" class="btn btn-rose btn-fill">Sorting</a>
						</div>
					</div>
				</div> --}}
				{{-- <div class="col-md-6">
					<div class="card ">
						<div class="card-body text-center">
							<h5 class="card-text">Pin News</h5>
							<a href="{{ url('admin/news/sortnews/pin?edition=online') }}" class="btn btn-rose btn-fill">Sorting</a>
						</div>
					</div>
				</div> --}}
				{{-- <div class="col-md-6">
					<div class="card ">
						<div class="card-body text-center">
							<h5 class="card-text">Home Slide</h5>
							<a href="{{ url('admin/news/sortnews/slide?edition=online') }}" class="btn btn-rose btn-fill">Sorting</a>
						</div>
					</div>
				</div> --}}
				{{-- <div class="col-md-6">
					<div class="card ">
						<div class="card-body text-center">
							<h5 class="card-text">Multimedia Slide</h5>
							<a href="{{ url('admin/news/sortnews/multimedia?edition=multimedia') }}" class="btn btn-rose btn-fill">Sorting</a>
						</div>
					</div>
				</div> --}}
				<div class="col-md-12">
					<div class="card">
						<div class="card-header card-header-primary card-header-icon">
							<div class="card-icon">
								<i class="material-icons">assignment</i>
							</div>
							<h4 class="card-title">Tag List</h4>
						</div>
						<div class="card-body">
							<div class="material-datatables">
								<table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
									<thead>
										<tr>
											<th>Sl. No</th>
											<th>Tag Name </th>
											<th class="disabled-sorting text-right">Actions</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Sl. No</th>
											<th>Tag Name </th>
											<th class="disabled-sorting text-right">Actions</th>
										</tr>
									</tfoot>
									<tbody>
										@foreach($tags as $row)
										<tr>
											<td class="text-info">{{ $loop->index }}</td>
											<td>{{ $row->name }}</td>
											<td><a href="{{ url('admin/news/sortnews/specialTag?edition=online&tag_id='.$row->id) }}" class="btn btn-rose btn-fill pull-right">Sorting</a></td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
		
			</div>
		</div>


		<div class="col-md-6">
			<div class="card">
				<div class="card-header card-header-primary card-header-icon">
					<div class="card-icon">
						<i class="material-icons">assignment</i>
					</div>
					<h4 class="card-title">Category List</h4>
				</div>
				<div class="card-body">
					<div class="material-datatables">
						<table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
							<thead>
								<tr>
									<th>Sl. No</th>
									<th>Category </th>
									<th class="disabled-sorting text-right">Actions</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Sl. No</th>
									<th>Category </th>
									<th class="disabled-sorting text-right">Actions</th>
								</tr>
							</tfoot>
							<tbody>
								@foreach($menus as $row)
								<tr>
									<td class="text-info">{{ $loop->index }}</td>
									<td>{{ $row->m_name }}</td>
									<td><a href="{{ url('admin/news/sortnews/'.$row->m_id.'?edition=online') }}" class="btn btn-rose btn-fill pull-right">Sorting</a></td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>



	</div>
</div>	  

@endsection

@push('breadcrumbs') Dashboard @endpush

@push('meta')
	<title>{{ config('app.name', 'Laravel') }}</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
@endpush