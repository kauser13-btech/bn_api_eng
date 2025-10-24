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

		<form class="form-horizontal" action="{{ route('menu.update', $Menu->m_id) }}" method="POST">
			@csrf
			@method('PATCH')

			<div class="col-md-12">
				<div class="row">
					<div class="col-md-6">
						<div class="card ">
							<div class="card-header card-header-rose card-header-text">
								<div class="card-text">
									<h4 class="card-title">Menu Create</h4>
								</div>
							</div>
							<div class="card-body ">
								<div class="row">
									<label class="col-sm-3 col-form-label">Display Name</label>
									<div class="col-sm-7">
										<div class="form-group">
											<input class="form-control" type="text" name="m_name" required="true" value="{{ $Menu->m_name }}" />
										</div>
										@error('m_name')
											<p class="text-danger">{{ $message }}</p>
										@enderror
									</div>
									<label class="col-sm-2 label-on-right"><code>required</code></label>
								</div>
								
								<div class="row">
									<label class="col-sm-3 col-form-label">Slug</label>
									<div class="col-sm-7">
										<div class="form-group">
											<input class="form-control" type="text" name="slug" required="true" value="{{ $Menu->slug }}" />
										</div>
										@error('slug')
											<p class="text-danger">{{ $message }}</p>
										@enderror
									</div>
									<label class="col-sm-2 label-on-right"><code>required</code></label>
								</div>
								
								<div class="row">
									<label class="col-sm-3 col-form-label">Edition</label>
									<div class="col-sm-7">
										<div class="form-group">
											<select name="m_edition" class="selectpicker" data-style="select-with-transition" title="Choose Edition" data-size="7" required="" id="Edition">
												@if(Auth::user()->type=='all' || Auth::user()->type=='online')
													<option @if($Menu->m_edition=='online') selected="" @endif value="online">Online</option>
													<option @if($Menu->m_edition=='multimedia') selected="" @endif value="multimedia">Multimedia</option>
												@endif
												@if(Auth::user()->type=='all' || Auth::user()->type=='print')
													<option @if($Menu->m_edition=='print') selected="" @endif value="print">Print</option>
													<option  @if($Menu->m_edition=='magazine') selected="" @endif value="magazine">Magazine</option>
												@endif
											</select>
										</div>
										@error('m_edition')
											<p class="text-danger">{{ $message }}</p>
										@enderror
									</div>
									<label class="col-sm-2 label-on-right"><code>required</code></label>
								</div>
								
								<div class="row">
									<label class="col-sm-3 col-form-label">Parent Menu</label>
									<div class="col-sm-7">
										<div class="form-group">
											<select name="m_parent" class="form-control ajax-select2">
												@if($Menu->m_parent)
													<option value="{{ $Menu->m_parent }}" selected="">{{ $ParentName->m_name }}</option>
												@else
													<option value="0">None</option>
												@endif
											</select>
										</div>
									</div>
								</div>
								
								<div class="row">
									<label class="col-sm-3 col-form-label">Order</label>
									<div class="col-sm-7">
										<div class="form-group">
											<input name="m_order" type="number" class="form-control" required="true"  value="{{ $Menu->m_order }}"/>
										</div>
										@error('m_order')
											<p class="text-danger">{{ $message }}</p>
										@enderror
									</div>
									<label class="col-sm-2 label-on-right"><code>required</code></label>
								</div>
								
								<div class="row">
									<label class="col-sm-3 col-form-label">Menu Status</label>
									<div class="col-sm-7">
										<div class="form-group">
											<div class="togglebutton">
												<label>
													<input name="m_status" type="checkbox" @if($Menu->m_status==1) checked="" @endif value="1">
													<span class="toggle"></span>
													Active
												</label>
											</div>
										</div>
										@error('m_status')
											<p class="text-danger">{{ $message }}</p>
										@enderror
									</div>
									<label class="col-sm-2 label-on-right"><code>required</code></label>
								</div>
								
								<div class="row">
									<label class="col-sm-3 col-form-label">Visible Navbar</label>
									<div class="col-sm-7">
										<div class="form-group">
											<div class="togglebutton">
												<label>
													<input name="m_visible" type="checkbox"  @if($Menu->m_visible==1) checked="" @endif value="1">
													<span class="toggle"></span>
													Yes
												</label>
											</div>
										</div>
										@error('m_visible')
											<p class="text-danger">{{ $message }}</p>
										@enderror
									</div>
									<label class="col-sm-2 label-on-right"><code>required</code></label>
								</div>
								
								<div class="row">
									<label class="col-sm-3 col-form-label">Get Sub Menu News</label>
									<div class="col-sm-7">
										<div class="form-group">
											<div class="togglebutton">
												<label>
													<input name="s_news" type="checkbox"  @if($Menu->s_news==1) checked="" @endif value="1">
													<span class="toggle"></span>
													Yes
												</label>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="row">
							<div class="col-sm-12">
								<div class="card ">
									<div class="card-header card-header-rose card-header-text">
										<div class="card-text">
											<h4 class="card-title">Menu Text Style</h4>
										</div>
									</div>
									<div class="card-body ">
										<div class="row">
											<label class="col-sm-3 col-form-label">Text Color</label>
											<div class="col-sm-7">
												<div class="form-group">
													<div id="" class="input-group color-picker">
														<input name="m_color" type="text" value="" class="form-control" value="{{ $Menu->m_color }}" />
														<span class="input-group-addon"><i></i></span>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-3 col-form-label">Background Color</label>
											<div class="col-sm-7">
												<div class="form-group">
													<div id="" class="input-group color-picker">
														<input name="m_bg" type="text" value="" class="form-control" value="{{ $Menu->m_bg }}" />
														<span class="input-group-addon"><i></i></span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-sm-12">
								<div class="card ">
									<div class="card-header card-header-rose card-header-text">
										<div class="card-text">
											<h4 class="card-title">Meta Info</h4>
										</div>
									</div>
									<div class="card-body ">
										<div class="row">
											<label class="col-sm-3 col-form-label">Meta Title</label>
											<div class="col-sm-7">
												<div class="form-group">
													<input name="m_title" class="form-control" type="text" required="true" value="{{ $Menu->m_title }}" />
												</div>
												@error('m_title')
													<p class="text-danger">{{ $message }}</p>
												@enderror
											</div>
											<label class="col-sm-2 label-on-right"><code>required</code></label>
										</div>
										<div class="row">
											<label class="col-sm-3 col-form-label">Meta Keyworks</label>
											<div class="col-sm-7">
												<div class="form-group">
													<input name="m_keywords" type="text" class="form-control tagsinput" data-role="tagsinput" data-color="info" required="true" value="{{ $Menu->m_keywords }}" />
												</div>
												@error('m_keywords')
													<p class="text-danger">{{ $message }}</p>
												@enderror
											</div>
											<label class="col-sm-2 label-on-right"><code>required</code></label>
										</div>
										<div class="row">
											<label class="col-sm-3 col-form-label">Meta Description</label>
											<div class="col-sm-7">
												<div class="form-group">
													<textarea name="m_desc" class="form-control meta-desc" name="required" required="true">{{ $Menu->m_desc }}</textarea>
													<div id="meta-count" class="text-danger">
														<span id="current_count">0</span>
														<span id="maximum_count">/ 160</span>
														<small>১২০ থেকে ১৫৫ অক্ষররের মধ্যে সীমিত রাখুন। - গুগল</small>
													</div>
												</div>
												@error('m_desc')
													<p class="text-danger">{{ $message }}</p>
												@enderror
											</div>
											<label class="col-sm-2 label-on-right"><code>required</code></label>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>

					<div class="col-md-12">
						<div class="card-footer ml-auto mr-auto">
							<button type="submit" class="btn btn-rose">Update</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
		
		  

@endsection

@push('breadcrumbs') Menu Create @endpush

@push('meta')
	<title>Menu Create</title>
@endpush

@push('stylesheet')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/css/bootstrap-colorpicker.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/js/bootstrap-colorpicker.min.js"></script>
<script type="text/javascript">
$(function () {
	$('.color-picker').colorpicker();

	$("#Edition").change(function(){
		$('.ajax-select2').empty();
	});
	$('.ajax-select2').select2({
		ajax: {
			url: function (params) {
				var Edition = $('#Edition').children("option:selected").val(),
					txt = params.term,
					mID = {{ $Menu->m_id }};

				return '{{ url('api/findparentmenu') }}/'+Edition+"/"+mID+"/"+txt;
			},
			delay: 250,
			processResults: function (data) {
				return {
					results: data.results
				};
			}
		},
	});
	
	function _strlen() {
		var characterCount = $('.meta-desc').val().length,
	        current_count = $('#current_count'),
	        maximum_count = $('#maximum_count'),
	        count = $('#meta-count');    
	        current_count.text(characterCount); 
	}
	_strlen();
	$('.meta-desc').keyup(function() {    
	      _strlen();     
	});

});
</script>
@endpush