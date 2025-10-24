@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
		@if (Session::has('success'))
			<script type="text/javascript">
				setTimeout(function() {
			        md.showNotification('top','center','success',"{{ Session::get('success') }}").trigger('click');
			    },100);
			</script>
		@endif
		<div class="card">
			<div class="card-header card-header-primary card-header-icon">
				<div class="card-icon">
					<i class="material-icons">assignment</i>
				</div>
				<h4 class="card-title">Live News List </h4>
			</div>
			<div class="card-body">
				<div class="material-datatables">
					<table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
						<thead>
							<tr>
								<th>Sl. No</th>
								<th>Headline</th>
								<th>View</th>
								<th>Category</th>
								<th>Editing By</th>
								<th>Status</th>
								<th>Created By</th>
								<th>Updated By</th>
								<th class="disabled-sorting text-right" width="10%">Actions</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl. No</th>
								<th>Headline</th>
								<th>View</th>
								<th>Category</th>
								<th>Editing By</th>
								<th>Status</th>
								<th>Created By</th>
								<th>Updated By</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach($news as $row)
							<tr>
								<td class="text-info">{{ $row->n_id }}</td>
								<td class="text-primary">{{ $row->n_head }}</td>
								<td class="text-primary">{{ $row->most_read }}</td>
								<td class="text-primary">{{ $row->catName->m_name }}</td>
								<td class="text-info">
									@if($row->onediting!=0)
										@if(Auth::user()->role=='developer' || Auth::user()->role=='editor')
											<a href="{{ url('admin/news/'.$row->n_id."/release") }}" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure you want to release this news?');">{{$row->editingBy->name}}</a>
										@else
											<p class="btn btn-warning btn-sm">{{$row->editingBy->name}}</p>
										@endif
									@endif
								</td>
								<td>
									@if($row->n_status==3)
										<span class="badge badge-pill badge-success">Publish</span>
									@elseif($row->n_status==2)
										<span class="badge badge-pill badge-info">Save</span>
									@elseif($row->n_status==1)
										<span class="badge badge-pill badge-warning">Draft</span>
									@else
										<span class="badge badge-pill badge-danger">Inactive</span>
									@endif
								</td>
								<td class="text-danger">{{ $row->createdBy->name }}</td>
								<td class="text-danger">{{ $row->updatedBy->name }}</td>
								<td class="text-right">
									<a href="{{ url('admin/news/'.$row->n_id.'/edit?edition=online') }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">edit_note</i></a>
									<a href="{{ url('admin/news/create?edition=online&nid='.$row->n_id) }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">note_add</i></a>
										<a href="{{ url('admin/news/livenewslist/'.$row->n_id.'?edition=online') }}" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">view_list</i></a>

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

@push('breadcrumbs') News List @endpush

@push('meta')
	<title>News List</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
@endpush