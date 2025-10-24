@extends('layouts.app')

@section('content')


<div class="col-md-12">
	<div class="row">
		<div class="card">
			<div class="card-header card-header-rose card-header-text">
				<div class="card-icon">
					<i class="material-icons">search</i>
				</div>
				<h4 class="card-title">Daily News Report</h4>
			</div>
			<div class="card-body">
				<form class="form-horizontal" action="{{ url('admin/report/cat-news-report') }}" method="GET">
					<div class="col-md-12">
						<div class="row">

							<div class="col-md-2">
								<div class="form-group">
									<select class="form-select w-100 selectpicker" name="range">
										<option @if(Request::get('range')=='0') selected @endif value="0">Custom Month</option>
										<option @if(Request::get('range')=='1') selected @endif value="1">Today</option>
										<option @if(Request::get('range')=='2') selected @endif value="2">Yesterday</option>
										<option @if(Request::get('range')=='7') selected @endif value="7">Last 7 Days</option>
										<option @if(Request::get('range')=='15') selected @endif value="15">Last 15 Days</option>
										<option @if(Request::get('range')=='30') selected @endif value="30">Last 1 Month</option>
									</select>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<input type="text" class="form-control monthpicker" value="{{Request::get('rdate')}}" name="rdate">
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
				<h4 class="card-title">User List</h4>
			</div>
			<div class="card-body">
				<div class="material-datatables">
					<table class="table table-striped table-no-bordered table-hover datatables-buttons" cellspacing="0" width="100%" style="width:100%">
					<thead>
						<tr>
							<th scope="col">Category</th>
							<th scope="col">Posts</th>
							<th scope="col">Total Read</th>
							<th scope="col">AVG Read</th>
						</tr>
					</thead>
					<tbody>
						@foreach($cat as $row)
							<tr>
								<th scope="row">{{ $row->m_name }}</th>
								<td>{{ $row->total_posts_count }}</td>
								<td>{{ number_format($row->total_read_sum_most_read) }}</td>
								<td>
									@php
									if($row->total_read_sum_most_read!=0 && $row->total_posts_count!=0){
										echo number_format( $row->total_read_sum_most_read/$row->total_posts_count );
									}
									@endphp
								</td>
							</tr>
						@endforeach
					</tbody>
					</table>
				</div>
				<div class="clearfix"></div>
			</div>
			
		</div>
	</div>
</div>


@endsection

@push('breadcrumbs') Category Report @endpush

@php
	switch (Request::get('range')) {
		case 0:
			$reportDate = Request::get('rdate');
			break;
		case 1:
			$reportDate = date('Y-m-d');
			break;
		case 2:
			$reportDate = date('Y-m-d', strtotime('-1 days'));
			break;
		case 7:
		case 15:
		case 30:
		case 90:
			$reportDate = date('Y-m-d', strtotime('-'.Request::get('range').' days')).' to '.date('Y-m-d');
			break;
		default:
			$reportDate = date('Y-m-d');
			break;
	}
@endphp

@push('meta')
	<title>Category Report - {{$reportDate}}</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
<script>
	$(document).ready(function() {
		$('.datatables-buttons').DataTable( {
			dom: 'Bfrtip',
    		order: [[3, 'desc']],
			"lengthMenu": [
				[30, 50, 100, -1],
				[30, 50, 100, "All"]
			],
			buttons: [
				['copy', 'csv', 'excel'],
				{
					extend: 'print',
					messageTop: function () {
						return '{{$reportDate}}';
					},
					messageBottom: null
				}
			]
		});
	});
</script>
@endpush