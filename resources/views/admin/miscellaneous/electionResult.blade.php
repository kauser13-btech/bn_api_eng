@extends('layouts.app')

@section('content')

<form class="form-horizontal" action="{{ route('miscellaneous.update') }}" method="POST" enctype="multipart/form-data">
	@csrf


	<input type="hidden" name="id" value="{{ $top10news->id }}">
	<div class="col-md-12">
		@if (Session::has('success'))
			<script type="text/javascript">
				setTimeout(function() {
					md.showNotification('top','center','success',"{{ Session::get('success') }}").trigger('click');
				},100);
			</script>
		@endif
		@if (Session::has('unauthorized'))
			<script type="text/javascript">
				setTimeout(function() {
					md.showNotification('top','center','danger',"{{ Session::get('unauthorized') }}").trigger('click');
				},100);
			</script>
		@endif
		<div class="card">
			<div class="card-header card-header-primary card-header-icon">
				<div class="card-icon">
					<i class="material-icons">assignment</i>
				</div>
				<h4 class="card-title">Election Update</h4>
			</div>
            
			<div class="card-body">
				<div class="material-datatables">
					<table class="table" cellspacing="0" width="100%" style="width:100%">
						<thead>
							<tr>
								<th>Sl. No</th>
								<th>News ID</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl. No</th>
								<th>News ID</th>
							</tr>
						</tfoot>
						<tbody id="sort-home-category-news">
                        
                            <tr>
                                <td class="text-info">AL</td>
                                <td>
                                    <input type="text" value="{{ json_decode($top10news->arr_data)[0] }}" class="sort" name="arr_data[]">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-info">JP</td>
                                <td>
                                    <input type="text" value="{{ json_decode($top10news->arr_data)[1] }}" class="sort" name="arr_data[]">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-info">TBNP</td>
                                <td>
                                    <input type="text" value="{{ json_decode($top10news->arr_data)[2] }}" class="sort" name="arr_data[]">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-info">INDEPENDENT</td>
                                <td>
                                    <input type="text" value="{{ json_decode($top10news->arr_data)[3] }}" class="sort" name="arr_data[]">
                                </td>
                            </tr>
                            <tr>
                                <td class="text-info">OTHERS</td>
                                <td>
                                    <input type="text" value="{{ json_decode($top10news->arr_data)[4] }}" class="sort" name="arr_data[]">
                                </td>
                            </tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer ">
				<button type="submit" class="btn btn-fill btn-rose">Update</button>
			</div>
		</div>
	</div>
</form>

@endsection

@push('breadcrumbs') Election Update @endpush

@push('meta')
	<title>Election Update</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')

@endpush