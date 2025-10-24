@extends('layouts.app')

@section('content')

<form class="form-horizontal" action="{{ route('astrology.update', $sql->id) }}" method="POST">
	@csrf
	@method('PATCH')

	@if (Session::has('success'))
		<script type="text/javascript">
			setTimeout(function() {
		        md.showNotification('top','center','success',"{{ Session::get('success') }}").trigger('click');
		    },100);
		</script>
	@endif

	<div class="col-md-12">
		<div class="row">
			<div class="col-md-7">
				<div class="card ">
					<div class="card-header card-header-rose card-header-text">
						<div class="card-text">
							<h4 class="card-title">Text</h4>
						</div>
					</div>
					<div class="card-body ">
						<div class="row">
							<label class="col-sm-2 col-form-label">Text</label>
							<div class="col-sm-9">
								<div class="form-group">
									<textarea class="form-control" name="text" rows="18" cols="50">{!! $sql->text !!}</textarea>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

			<div class="col-md-5">
				<div class="card ">
					<div class="card-header card-header-rose card-header-text">
						<div class="card-text">
							<h4 class="card-title">Settings</h4>
						</div>
					</div>
					<div class="card-body">
						<div class="row">
							<label class="col-sm-4 col-form-label">Order</label>
							<div class="col-sm-8">
								<div class="form-group">
									<input type="number" class="form-control" name="p_order" value="{{ $sql->p_order }}">
								</div>
							</div>
						</div>
						<div class="row">
							<label class="col-sm-4 col-form-label">Category</label>
							<div class="col-sm-8">
								<div class="form-group"><select name="category" class="selectpicker" data-style="select-with-transition" title="Choose Astrology" data-size="7" required>
		                            <option @if($sql->category == 'Aries') selected @endif value="Aries">মেষরাশি </option>
		                            <option @if($sql->category == 'Taurus') selected @endif value="Taurus">বৃষরাশি</option>
		                            <option @if($sql->category == 'Gemini') selected @endif value="Gemini">মিথুনরাশি</option>
		                            <option @if($sql->category == 'Cancer') selected @endif value="Cancer">কর্কটরাশি</option>
		                            <option @if($sql->category == 'Leo') selected @endif value="Leo">সিংহরাশি</option>
		                            <option @if($sql->category == 'Virgo') selected @endif value="Virgo">কন্যারাশি</option>
		                            <option @if($sql->category == 'Libra') selected @endif value="Libra">তুলারাশি</option>
		                            <option @if($sql->category == 'Scorpio') selected @endif value="Scorpio">বৃশ্চিকরাশি </option>
		                            <option @if($sql->category == 'Sagittarius') selected @endif value="Sagittarius">ধনুরাশি</option>
		                            <option @if($sql->category == 'Capricorn') selected @endif value="Capricorn">মকররাশি</option>
		                            <option @if($sql->category == 'Aquarius') selected @endif value="Aquarius">কুম্ভরাশি</option>
		                            <option @if($sql->category == 'Pisces') selected @endif value="Pisces">মীনরাশি</option>
		                          </select>
		                      </div>
							</div>
						</div>
					</div>
				</div>

				<div class="card ">
					<div class="card-header card-header-rose card-header-text">
						<div class="card-text">
							<h4 class="card-title">Publishing</h4>
						</div>
					</div>
					<div class="card-body ">
						<div class="col-md-12">
							<div class="row">
								<label class="col-sm-2 col-form-label">Date</label>
								<div class="col-sm-8">
									<div class="form-group">
										<input name="start_date" type="text" class="form-control datepicker" value="{{ $sql->start_date }}">
									</div>	
								</div>
								<label class="col-sm-2 label-on-right"><code>required</code></label>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<div class="row">
									<label class="col-sm-2 col-form-label">Status</label>
									<div class="col-sm-8">
										<div class="form-group">
											@if($sql->p_status==1)
												<div class="form-check">
													<label class="form-check-label">
														<input name="p_status" class="form-check-input" type="radio" value="1" @if($sql->p_status==1) checked @endif> Active
														<span class="circle"><span class="check"></span></span>
													</label>
												</div>
												<div class="form-check">
													<label class="form-check-label">
														<input name="p_status" class="form-check-input" type="radio" value="2" @if($sql->p_status==2) checked @endif> Save
														<span class="circle"><span class="check"></span></span>
													</label>
												</div>
											@else
												<div class="form-check">
													<label class="form-check-label">
														<input name="p_status" class="form-check-input" type="radio" value="2" @if($sql->p_status==2) checked @endif> Save
														<span class="circle"><span class="check"></span></span>
													</label>
												</div>
											@endif
											<div class="form-check">
												<label class="form-check-label">
													<input name="p_status" class="form-check-input" type="radio" value="0" @if($sql->p_status==0) checked @endif> Inactive
													<span class="circle"><span class="check"></span></span>
												</label>
											</div>
										</div>
									</div>
									<label class="col-sm-2 label-on-right"><code>required</code></label>
								</div>
							</div>
						</div>

					</div>
	                    
				</div>

			</div>
		</div>

		<div class="col-md-12">
			<div class="card-footer ml-auto mr-auto">
				<div class="col-md-12">
					<button type="submit" class="btn btn-rose">Submit</button>
				</div>
			</div>
		</div>
		
	</div>
</form>

@endsection

@push('breadcrumbs') News Add @endpush

@push('meta')
	<title>News Add</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
<script src="{{ asset('admin/ckeditor/ckeditor.js') }}"></script>
<script>
	var options = {
		filebrowserImageBrowseUrl: '/admin/news-filemanager?type=Images',
		filebrowserImageUploadUrl: '/admin/news-filemanager/upload?type=Images&_token=',
		filebrowserBrowseUrl: '/admin/news-filemanager?type=Files',
		filebrowserUploadUrl: '/admin/news-filemanager/upload?type=Files&_token='
	};
	CKEDITOR.replace('editor', options);
	
	</script>
@endpush