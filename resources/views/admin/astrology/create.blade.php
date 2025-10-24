@extends('layouts.app')

@section('content')

<form class="form-horizontal" action="{{ route('astrology.store') }}" method="POST">
	@csrf

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
									<textarea class="form-control" name="text" rows="18" cols="50"></textarea>
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
						{{-- <div class="row">
							<label class="col-sm-4 col-form-label">Order</label>
							<div class="col-sm-8">
								<div class="form-group">
									<input type="number" class="form-control" name="p_order">
								</div>
							</div>
						</div> --}}
						<div class="row">
							<label class="col-sm-4 col-form-label">Category</label>
							<div class="col-sm-8">
								<div class="form-group"><select name="category" class="selectpicker" data-style="select-with-transition" title="Choose Astrology" data-size="7" required>
		                            <option value="Aries">মেষরাশি </option>
		                            <option value="Taurus">বৃষরাশি</option>
		                            <option value="Gemini">মিথুনরাশি</option>
		                            <option value="Cancer">কর্কটরাশি</option>
		                            <option value="Leo">সিংহরাশি</option>
		                            <option value="Virgo">কন্যারাশি</option>
		                            <option value="Libra">তুলারাশি</option>
		                            <option value="Scorpio">বৃশ্চিকরাশি</option>
		                            <option value="Sagittarius">ধনুরাশি</option>
		                            <option value="Capricorn">মকররাশি</option>
		                            <option value="Aquarius">কুম্ভরাশি</option>
		                            <option value="Pisces">মীনরাশি</option>
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
										<input name="start_date" type="text" class="form-control" value="{{ $EPaperNewDate }}" readonly>
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
											<div class="form-check">
												<label class="form-check-label">
													<input name="p_status" class="form-check-input" type="radio" value="2" checked> Save
													<span class="circle"><span class="check"></span></span>
												</label>
											</div>
											<div class="form-check">
												<label class="form-check-label">
													<input name="p_status" class="form-check-input" type="radio" value="0"> Inactive
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
@endpush