@extends('layouts.app')

@section('content')


<form class="form-horizontal" action="{{ route('gallery.sortupdate') }}" method="POST">
	@csrf
	<div class="row">
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
					<h4 class="card-title">{{ $type }} List</h4>
				</div>
				<div class="card-body">
					<div class="material-datatables">
						<table class="table" cellspacing="0" width="100%" style="width:100%">
							<thead>
								<tr>
									<th>Sl. No</th>
									<th>Name</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Sl. No</th>
									<th>Name</th>
								</tr>
							</tfoot>
							<tbody id="sort-home-category-news">
								@foreach($sql as $row)
	                    		<tr id="{{$row->id}}" style="cursor: move;">
									<td class="text-info">{{ $loop->index }}</td>
									<td>
										{{ $row->name }}

			                            <input type="hidden" value="{{$row->g_order}}" class="sort" name="g_order[]">
			                            <input type="hidden" value="{{$row->id}}" name="id[]">
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
			            <input type="hidden" value="{{ $type }}" name="order_name">
					</div>
				</div>
				<div class="card-footer ">
					<button type="submit" class="btn btn-fill btn-rose">Submit</button>
				</div>
			</div>
		</div>
	</div>
</form>
		  

@endsection

@push('breadcrumbs') Dashboard @endpush

@push('meta')
	<title>{{ config('app.name', 'Laravel') }}</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
    <script src="{{ asset('/admin/js/jquery-ui.js') }}"></script>
    <script>
        $(document).ready(function(){

            $("#sort-home-category-news").sortable({
                stop: function (event, ui) {
                    var tbody = $('#sort-home-category-news');
                    var rows = tbody.find('tr');

                    var order_ids = $(this).sortable("toArray").sort(function(a, b){return b-a});

                    for (var i = 0; i < rows.length; i++) {
                        $(rows[i]).find('.sort').val(order_ids[i]);
                    }
                }
            });
        });
    </script>
@endpush