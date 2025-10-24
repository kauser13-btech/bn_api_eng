@extends('layouts.app')

@section('content')


<div class="col-md-12">
	@if (Session::has('success'))
		<script type="text/javascript">
			setTimeout(function() {
		        md.showNotification('top','center','success',"{{ Session::get('success') }}").trigger('click');
		    },100);
		</script>
	@endif
	<div class="row">
		<div class="card">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-icon">
					<i class="material-icons">search</i>
				</div>
				<h4 class="card-title">Search</h4>
			</div>
			<div class="card-body">
				<form class="form-horizontal" action="{{ url('admin/news/trash') }}" method="GET">
					<input type="hidden" name="edition" value="{{ Request::get('edition') }}">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
				                  <label for="exampleNewsTitle1" class="bmd-label-floating"> News Headline</label>
				                  <input type="text" class="form-control" name="n_head" id="exampleNewsTitle1" value="{{ Request::get('n_head') }}">
				                </div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
				                  <label for="exampleNewsTitle2" class="bmd-label-floating"> News Id</label>
				                  <input type="number" class="form-control" name="n_id" id="exampleNewsTitle2" value="{{ Request::get('n_id') }}">
				                </div>
							</div>
	 
							<div class="col-md-2">
								<div class="form-group">
									<input type="text" class="form-control datepicker" name="n_date"value="{{ Request::get('n_date') }}">
								</div>
							</div>

							<div class="col-md-2 pull-right">
								<button type="submit" class="btn btn-rose">Search</button>
							</div>
						</div>
					</div>
				</form>
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
				<h4 class="card-title">News List</h4>
			</div>
			<div class="card-body">
				<div class="toolbar">{{ date('Y-m-d') }}</div>
				<div class="material-datatables">
					<table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
						<thead>
							<tr>
								<th>Sl. No</th>
								@if(Request::get('edition')!='online')
									<th>Edition</th>
								@endif
								<th>News Headline</th>
								<th>Created At</th>
								<th>Deleted At</th>
								<th>Deleted By</th>
								<th class="disabled-sorting text-right">Restore</th>
							</tr>
						</thead>
						<tfoot>
								<th>Sl. No</th>
								@if(Request::get('edition')!='online')
									<th>Edition</th>
								@endif
								<th>News Headline</th>
								<th>Created At</th>
								<th>Deleted At</th>
								<th>Deleted By</th>
								<th class="disabled-sorting text-right">Restore</th>
							</tfoot>
						<tbody>
							@if($trash)
								@foreach($trash as $row)
								<tr>
									<td class="text-info">{{ $row->n_id }}</td>
									@if(Request::get('edition')!='online')
										<td>{{ $row->edition }}</td>
									@endif
									<td><a href="#" class="text-primary">{{ $row->n_head }}</a></td>
									<td class="text-warning">{{ $row->start_at }}</td>
									<td class="text-warning">{{ $row->deleted_at }}</td>
									<td class="text-danger">{{ $row->deletedBy->name }}</td>
									<td class="text-right">
										<form class="pull-right" method="POST" action="{{ route('news.restore') }}">
											@csrf
											<input type="hidden" value="{{ $row->n_id }}" name="n_id">
											<button type="submit" class="btn btn-link btn-danger btn-just-icon remove" onclick="return confirm('Are you sure you want to restore this item?');"><i class="material-icons">restore</i></button>
										</form>
									</td>
									@endforeach
								@endif
							</tr>
						</tbody>
					</table>
				</div>
				<div class="card-footer">
					{{ $trash->appends(['edition'=>Request::get('edition'),'n_head'=>Request::get('n_head'),'n_id'=>Request::get('n_id'),'n_date'=>Request::get('n_date')])->links() }}
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