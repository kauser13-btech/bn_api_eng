@extends('layouts.app')

@section('content')
    <form class="form-horizontal" action="{{ route('ads.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-md-12">
            @if (Session::has('success'))
                <script type="text/javascript">
                    setTimeout(function() {
                        md.showNotification('top', 'center', 'success', "{{ Session::get('success') }}").trigger('click');
                    }, 100);
                </script>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-text">
                                <h4 class="card-title">Ad Info</h4>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Type</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <select id="AdType" class="selectpicker" data-size="7"
                                            data-style="select-with-transition" title="Ad Type" name="adtype">
                                            <option value="images">Images</option>
                                            <option value="dfp-code">DFP Code</option>
                                            {{-- <option value="script-code">Script Code</option> --}}
                                        </select>
                                    </div>
                                </div>
                                <label class="col-sm-2 label-on-right"><code>required</code></label>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" required="true" />
                                    </div>
                                </div>
                                <label class="col-sm-2 label-on-right"><code>required</code></label>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Device</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <select class="form-control" id="getversion" name="device">
                                            <option value="desktop" @if (Request::get('for') == 'desktop') selected @endif>
                                                Desktop</option>
                                            <option value="mobile" @if (Request::get('for') == 'mobile') selected @endif>Mobile
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <label class="col-sm-2 label-on-right"><code>required</code></label>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Page</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <select id="Page" class="selectpicker" data-size="7"
                                            data-style="select-with-transition" name="page">
                                            <option @if (Request::get('page') == 'home') selected @endif value="home"
                                                selected>Home</option>
                                            <option @if (Request::get('page') == 'category') selected @endif value="category">
                                                Category</option>
                                            <option @if (Request::get('page') == 'details') selected @endif value="details">
                                                Details</option>
                                        </select>
                                    </div>
                                </div>
                                <label class="col-sm-2 label-on-right"><code>required</code></label>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Position</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <select id="setPosition" name="ads_positions_slug"
                                            class="ajax-select2 form-control">
                                            @if ($SelectAdsPosition)
                                                <option value="{{ $SelectAdsPosition->slug }}" selected="">
                                                    {{ $SelectAdsPosition->name }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <label class="col-sm-2 label-on-right"><code>required</code></label>
                            </div>
                            <div class="row" id="categoryPage">
                                <label class="col-sm-2 col-form-label">Show On Page</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <select name="menus_id[]" class="form-control _select2" multiple>
                                            @foreach ($Menus as $mrow)
                                                <option value="{{ $mrow->m_id }}">{{ $mrow->m_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2 label-on-right">
                                    <select class="selectpicker" name="ad_condition">
                                        <option value="1">==</option>
                                        <option value="0">!=</option>
                                    </select>
                                </div>
                                @if (Request::get('page') == 'details')
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">News ID</label>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="n_id"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Order</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <input class="form-control" type="number" name="ad_order" required="true" />
                                    </div>
                                </div>
                                <label class="col-sm-2 label-on-right"><code>required</code></label>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="status"
                                                    value="1" checked> Active
                                                <span class="circle"><span class="check"></span></span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="status"
                                                    value="0"> Inactive
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

                <div class="col-md-6">
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-text">
                                <h4 class="card-title">Time Slot</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="slotListArea">
                                <div class="slotList col-md-12">
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control datetimepicker"
                                                            placeholder="Start publishing" name="time_slot[start_date][]"
                                                            value="{{ date('Y-m-d H:i:s') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control datetimepicker"
                                                            placeholder="End publishing" name="time_slot[end_date][]">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            placeholder="setTimeout" name="time_slot[time_schedule][]"
                                                            value="7000">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <a href="#" class="btn btn-link btn-danger btn-just-icon remove"><i
                                                    class="material-icons">close</i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button id="AddNewSlot" type="button" class="btn btn-primary btn-sm">Add New Slot</button>

                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-text">
                                <h4 class="card-title">Ad</h4>
                            </div>
                        </div>
                        <div class="card-body ">

                            <div class="row" id="imgAd" style="display: none;">
                                <label class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10">
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <img src="{{ asset('/admin/img/image_placeholder.jpg') }}" alt="Ad Image">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-rose btn-round btn-file">
                                                <span class="fileinput-new"><i
                                                        class="material-icons">file_present</i></span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="ad_img" accept=".png, .jpg, .gif, .jpeg" />
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists"
                                                data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                        </div>
                                    </div>
                                </div>

                                <label class="col-sm-2 col-form-label">Landing Url</label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="landing_url" value="#">
                                    </div>
                                </div>

                            </div>

                            <div class="row" id="codeAd" style="display: none;">
                                <label class="col-sm-2 col-form-label">Ad Code</label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <textarea class="form-control" type="text" name="ad_code" style="height: 200px!important;"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label" id="HeaderCode">Head Code</label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <textarea class="form-control" type="text" name="head_code"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">Footer Code</label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <textarea class="form-control" type="text" name="footer_code"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card-footer ml-auto mr-auto">
                        <button type="submit" class="btn btn-rose">Submit</button>
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection

@push('breadcrumbs')
    Menu List
@endpush

@push('meta')
    <title>{{ config('app.name', 'Laravel') }}</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#AddNewSlot').click(function(event) {
                var slotHtml = '<div class="slotList col-md-12">\
    					<div class="row">\
    						<div class="col-sm-11">\
    							<div class="row">\
    								<div class="col-md-5">\
    									<div class="form-group">\
    										<input type="text" class="form-control datetimepicker" placeholder="Start publishing" name="time_slot[start_date][]">\
    									</div>\
    								</div>\
    								<div class="col-md-5">\
    									<div class="form-group">\
    										<input type="text" class="form-control datetimepicker" placeholder="End publishing" name="time_slot[end_date][]">\
    									</div>\
    								</div>\
    								<div class="col-md-2">\
    									<div class="form-group">\
    										<input type="text" class="form-control" placeholder="setTimeout" name="time_slot[time_schedule][]" value="7000">\
    									</div>\
    								</div>\
    							</div>\
    						</div>\
    						<div class="col-md-1">\
    							<a href="#" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>\
    						</div>\
    					</div>\
    				</div>';

                $('#slotListArea').append(slotHtml);

                md.initFormExtendedDatetimepickers();
                return false;
            });

            $('body').on('click', '.remove', function(event) {
                event.preventDefault();
                var _delete = confirm("Are you sure you want to delete?");
                if (_delete) {
                    $(this).parents('.slotList').remove();
                }
            });

            $("#AdType").change(function() {

                var selectedCountry = $(this).children("option:selected").val();
                if (selectedCountry == 'dfp-code') {
                    $('#HeaderCode').html('DFP Head Code');
                } else {
                    $('#HeaderCode').html('Head Code');
                }

                if (selectedCountry == 'images') {
                    $('#imgAd').css('display', 'flex');
                    $('#codeAd').css('display', 'none');
                } else {
                    $('#imgAd').css('display', 'none');
                    $('#codeAd').css('display', 'flex');
                }
            });

            $("#Page, #getversion").change(function() {
                $('.ajax-select2').empty();
            });

            setTimeout(function() {
                var getPageName = $('#Page').children("option:selected").val();
                if (getPageName == 'category' || getPageName == 'details') {
                    $('#categoryPage').css('display', 'flex');
                } else {
                    $('#categoryPage').css('display', 'none');
                }
            }, 100);
            $("#Page").change(function() {
                var getPageName = $('#Page').children("option:selected").val();
                if (getPageName == 'category' || getPageName == 'details') {
                    $('#categoryPage').css('display', 'flex');
                } else {
                    $('#categoryPage').css('display', 'none');
                }

            });

            $('.ajax-select2').select2({
                ajax: {
                    url: function(params) {
                        var getVersion = $('#getversion').children("option:selected").val(),
                            getPage = $('#Page').children("option:selected").val(),
                            txt = params.term;
                        console.log('{{ url('api/findposition') }}/' + getVersion + '/' + getPage +
                            '/' + txt)
                        return '{{ url('api/findposition') }}/' + getVersion + '/' + getPage + '/' +
                            txt;
                    },
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: data.results
                        };
                    }
                },
            });

        });
    </script>
@endpush
