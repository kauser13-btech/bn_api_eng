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
				<h4 class="card-title">Writers & Reporters <button class="btn btn-primary btn-round pull-right" data-toggle="modal" data-target="#Writers">Add New</button></h4>
			</div>
			<div class="card-body">
				<div class="material-datatables">
					<table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0" width="100%" style="width:100%">
						<thead>
							<tr>
								<th>Sl. No</th>
								<th>Picture</th>
								<th>Name</th>
								<th>Profession</th>
								<th>Order</th>
								<th>Type</th>
								<th>Status</th>
								<th>Created By</th>
								<th>Updated By</th>
								<th class="disabled-sorting text-right" width="10%">Actions</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Sl. No</th>
								<th>Picture</th>
								<th>Name</th>
								<th>Profession</th>
								<th>Order</th>
								<th>Type</th>
								<th>Status</th>
								<th>Created By</th>
								<th>Updated By</th>
								<th class="disabled-sorting text-right" width="10%">Actions</th>
							</tr>
						</tfoot>
						<tbody>
							@foreach($list as $row)
							<tr>
								<td class="text-info">{{ $loop->index }}</td>
								<td class="text-info"><img src="{{ \App\Helpers\ImageStoreHelpers::showImage('profile',$row->created_at,$row->img) }}" width="50" alt="Ad Image"></td>
								<td class="text-primary">{!! $row->name !!}</td>
								<td class="text-primary">{{ $row->profession }}</td>
								<td class="text-primary">{{ $row->w_order }}</td>
								<td class="text-primary">{{ $row->type }}</td>
								<td>
									@if($row->status==1)
										<span class="badge badge-pill badge-success">Active</span>
									@else
										<span class="badge badge-pill badge-danger">Inactive</span>
									@endif
								</td>
								<td class="text-danger">{{ $row->createdBy->name }}</td>
								<td class="text-danger">{{ $row->updatedBy->name }}</td>
								<td class="text-right">
									<button class="btn btn-link btn-warning btn-just-icon edit" data-toggle="modal" data-target="#writers-{{ $row->id }}"><i class="material-icons">edit_note</i></button>
									<!-- Classic Modal -->
									<div class="modal fade" id="writers-{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="WritersLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title">Writers & Reporters</h4>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
												</div>
												<form class="form-horizontal" action="{{ route('writers.update', $row->id) }}" method="POST" enctype="multipart/form-data">
													@csrf
													@method('PATCH')

													<input type="hidden" name="old_img" value="{{ $row->img }}">
													<input type="hidden" name="created_at" value="{{ $row->created_at }}">
													<div class="modal-body">
														<div class="row">
															<label class="col-sm-2 col-form-label">Name</label>
															<div class="col-sm-9">
																<div class="form-group">
																	<input name="name" type="text" class="form-control" placeholder="Name" value="{!! $row->name !!}">
																</div>
															</div>
														</div>
														<div class="row">
															<label class="col-sm-2 col-form-label">Profession</label>
															<div class="col-sm-9">
																<div class="form-group">
																	<input name="profession" type="text" class="form-control" placeholder="Profession" value="{!! $row->profession !!}">
																</div>
															</div>
														</div>
														<div class="row">
															<label class="col-sm-2 col-form-label">Order</label>
															<div class="col-sm-9">
																<div class="form-group">
																	<input name="w_order" type="number" class="form-control" placeholder="Profession"value="{{ $row->w_order }}">
																</div>
															</div>
														</div>
														<div class="row">
															<label class="col-sm-2 col-form-label">Details</label>
															<div class="col-sm-9">
																<div class="form-group">
																	<textarea class="form-control" name="details">{!! $row->details !!}</textarea>
																</div>
															</div>
														</div>
														<div class="row">
															<label class="col-sm-2 col-form-label">Picture</label>
															<div class="col-sm-9">
																<div class="form-group">
																	<div class="fileinput fileinput-new text-center" data-provides="fileinput">
																		<div class="fileinput-new thumbnail img-circle">
																			<img src="{{ \App\Helpers\ImageStoreHelpers::showImage('profile',$row->created_at,$row->img) }}" alt="Ad Image">
																		</div>
																		<div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
																		<div>
																			<span class="btn btn-round btn-rose btn-file">
																				<span class="fileinput-new">Add Photo</span>
																				<span class="fileinput-exists">Change</span>
																				<input type="file" name="img" />
																			</span>
																			<br />
																			<a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="row">
															<label class="col-sm-2 col-form-label">Type</label>
															<div class="col-sm-9">
																<div class="form-group">
																	<select class="selectpicker" data-size="7" data-style="select-with-transition" name="type">
																		<option @if($row->type=='writers') selected @endif value="writers">Writers</option>
																		<option @if($row->type=='reporters') selected @endif value="reporters">Reporters</option>
																	</select>
																</div>
															</div>
														</div>
														<div class="row">
															<label class="col-sm-2 col-form-label">Status</label>
															<div class="col-sm-9">
																<div class="form-group">
																	<select class="selectpicker" data-size="7" data-style="select-with-transition" name="status">
																		<option @if($row->status==1) selected @endif value="1">Active</option>
																		<option @if($row->status==0) selected @endif value="0">Inactive</option>
																	</select>
																</div>
															</div>
														</div>

													</div>
													<div class="modal-footer">
														<button type="submit" class="btn btn-link">Update</button>
														<button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Close</button>
													</div>
												</form>
											</div>
										</div>
									</div>
									<!--  End Modal -->
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
		
<!-- Classic Modal -->
<div class="modal fade" id="Writers" tabindex="-1" role="dialog" aria-labelledby="WritersLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Writers or Reporters</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
			</div>
			<form class="form-horizontal" action="{{ route('writers.store') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<div class="row">
						<label class="col-sm-2 col-form-label">Name</label>
						<div class="col-sm-9">
							<div class="form-group">
								<input name="name" type="text" class="form-control" placeholder="Name">
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-sm-2 col-form-label">Profession</label>
						<div class="col-sm-9">
							<div class="form-group">
								<input name="profession" type="text" class="form-control" placeholder="Profession">
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-sm-2 col-form-label">Order</label>
						<div class="col-sm-9">
							<div class="form-group">
								<input name="w_order" type="number" class="form-control" placeholder="Profession">
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-sm-2 col-form-label">Details</label>
						<div class="col-sm-9">
							<div class="form-group">
								<textarea class="form-control" name="details"></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-sm-2 col-form-label">Picture</label>
						<div class="col-sm-9">
							<div class="form-group">
								<div class="fileinput fileinput-new text-center" data-provides="fileinput">
									<div class="fileinput-new thumbnail img-circle">
										<img src="{{ asset('/admin/img/placeholder.jpg') }}" alt="...">
									</div>
									<div class="fileinput-preview fileinput-exists thumbnail img-circle"></div>
									<div>
										<span class="btn btn-round btn-rose btn-file">
											<span class="fileinput-new">Add Photo</span>
											<span class="fileinput-exists">Change</span>
											<input type="file" name="img" />
										</span>
										<br />
										<a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-sm-2 col-form-label">Type</label>
						<div class="col-sm-9">
							<div class="form-group">
								<select class="selectpicker" data-size="7" data-style="select-with-transition" name="type">
									<option value="writers">Writers</option>
									<option value="reporters">Reporters</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<label class="col-sm-2 col-form-label">Status</label>
						<div class="col-sm-9">
							<div class="form-group">
								<select class="selectpicker" data-size="7" data-style="select-with-transition" name="status">
									<option value="1" selected>Active</option>
									<option value="0">Inactive</option>
								</select>
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-link">Submit</button>
					<button type="button" class="btn btn-danger btn-link" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--  End Modal -->

@endsection

@push('breadcrumbs') Menu List @endpush

@push('meta')
	<title>Menu List</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
@endpush