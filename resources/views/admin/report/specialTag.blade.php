@extends('layouts.app')

@section('content')


<div class="col-md-12">
	<div class="row">
		<div class="card">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-icon">
					<i class="material-icons">search</i>
				</div>
				<h4 class="card-title">Monthly Special Tag Report</h4>
			</div>
			<div class="card-body">
				<form class="form-horizontal" action="{{ url('admin/report/special-tag') }}" method="GET">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-2">
								<div class="form-group">
									<input type="text" class="form-control monthpicker" value="{{ $rdate }}" name="rdate">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<select name="news_tags" class="ajax-tags form-control">
										<option value="">Select Tags</option>
									</select>
								</div>
							</div>
							<div class="col-md-1 pull-right">
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
				<div class="material-datatables">
					<table class="table table-striped table-no-bordered table-hover datatables-buttons" cellspacing="0" width="100%" style="width:100%">
					<thead>
						<tr>
							<th scope="col">#ID</th>
							<th scope="col">Head</th>
							<th scope="col">Most Read</th>
							<th scope="col">News Link</th>
						</tr>
					</thead>
					<tbody>
						@foreach($newsList as $row)
							@php
								if($row->catName->m_edition=='online'){
									$m_edition = 'online';
								}else if($row->catName->m_edition=='print'){
									$m_edition = 'print-edition';
								}else{
									$m_edition = 'feature';
								}
							@endphp

							<tr>
								<th scope="row">{{$row->n_id}}</th>
								<td>{{$row->n_head}}</td>
								<td>{{$row->most_read}}</td>
								<td><a href="https://www.banglanews24.com/{{$m_edition}}/{{$row->catName->slug}}/{{date("Y/m/d", strtotime($row->start_at))}}/{{$row->n_id}}" class="btn btn-link btn-warning btn-just-icon edit" target="_blank"><i class="material-icons">link</i></a></td>
							</tr>
						@endforeach
					</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer">
				Total: {{count($newsList)}}
			</div>
		</div>
	</div>
</div>




@endsection

@push('breadcrumbs') Report @endpush

@push('meta')
	<title>Report</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
<script>
	$(document).ready(function() {
	    $('.datatables-buttons').DataTable( {
	        dom: 'Bfrtip',
	        buttons: [
	            'copy', 'csv', 'excel','print'
	        ]
	    } );
	} );

	$('.ajax-tags').select2({
		ajax: {
			url: function (params) {
				var txt = params.term;
				return '{{ url('api/findtags') }}/'+txt;
			},
			delay: 250,
			processResults: function (data) {
				return {
					results: data.results
				};
			}
		},
	});
</script>
@endpush