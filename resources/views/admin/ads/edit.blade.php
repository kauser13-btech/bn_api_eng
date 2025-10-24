@extends('layouts.app')

@section('content')
    <form class="form-horizontal" action="{{ route('ads.update', $ad->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <input type="hidden" name="created_at" value="{{ $ad->created_at }}">

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
                                            <option @if ($ad->adtype == 'images') selected="" @endif value="images">
                                                Images</option>
                                            <option @if ($ad->adtype == 'dfp-code') selected="" @endif value="dfp-code">
                                                DFP Code</option>
                                            {{-- <option @if ($ad->adtype == 'script-code') selected="" @endif value="script-code">Script Code</option> --}}
                                        </select>
                                    </div>
                                </div>
                                <label class="col-sm-2 label-on-right"><code>required</code></label>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" required="true"
                                            value="{{ $ad->name }}" />
                                    </div>
                                </div>
                                <label class="col-sm-2 label-on-right"><code>required</code></label>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Device</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <select class="form-control" id="getversion" name="device">
                                            <option value="desktop" @if ($ad->device == 'desktop') selected @endif>
                                                Desktop</option>
                                            <option value="mobile" @if ($ad->device == 'mobile') selected @endif>Mobile
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
                                            <option @if ($ad->page == 'home') selected @endif value="home">Home
                                            </option>
                                            <option @if ($ad->page == 'category') selected @endif value="category">
                                                Category</option>
                                            <option @if ($ad->page == 'details') selected @endif value="details">
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
                                            <option value="{{ $ad->adsPosition->slug }}" selected>
                                                {{ $ad->adsPosition->name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <label class="col-sm-2 label-on-right"><code>required</code></label>
                            </div>
                            <div class="row" id="categoryPage">
                                <label class="col-sm-2 col-form-label">Show On Page</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        @php
                                            if ($ad->menus_id != '' && $ad->menus_id != 'all') {
                                                $menus_id = json_decode($ad->menus_id);
                                            } else {
                                                $menus_id = [];
                                            }
                                        @endphp
                                        <select name="menus_id[]" class="form-control _select2" multiple>
                                            @foreach ($Menus as $mrow)
                                                <option @if (in_array($mrow->m_id, $menus_id)) selected @endif
                                                    value="{{ $mrow->m_id }}">{{ $mrow->m_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2 label-on-right">
                                    <select class="selectpicker" name="ad_condition">
                                        <option @if ($ad->ad_condition == 1) selected @endif value="1">==</option>
                                        <option @if ($ad->ad_condition == 0) selected @endif value="0">!=
                                        </option>
                                    </select>
                                </div>
                                @if ($ad->page == 'details')
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">News ID</label>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <textarea class="form-control" name="n_id">{!! $ad->n_id !!}</textarea>
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
                                        <input class="form-control" type="number" name="ad_order" required="true"
                                            value="{{ $ad->ad_order }}" />
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
                                                    value="1" @if ($ad->status == 1) checked @endif>
                                                Active
                                                <span class="circle"><span class="check"></span></span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="status"
                                                    value="0" @if ($ad->status == 0) checked @endif>
                                                Inactive
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
                                                            placeholder="Start publishing" name="start_date"
                                                            value="{{ $ad->start_date }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control datetimepicker"
                                                            placeholder="End publishing" name="end_date"
                                                            value="{{ $ad->end_date }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            placeholder="setTimeout" name="time_schedule"
                                                            value="{{ $ad->time_schedule }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                                            <img src="{{ \App\Helpers\ImageStoreHelpers::showImage('ads_images', $ad->created_at, $ad->ad_img, 'thumb') }}"
                                                alt="Ad Image">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-rose btn-round btn-file">
                                                <span class="fileinput-new"><i
                                                        class="material-icons">file_present</i></span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="ad_img" accept=".png, .jpg, .gif, .jpeg" />
                                                <input type="hidden" name="old_ad_img" value="{{ $ad->ad_img }}">
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists"
                                                data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                        </div>
                                    </div>
                                </div>

                                <label class="col-sm-2 col-form-label">Landing Url</label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="landing_url"
                                            value="{{ $ad->landing_url }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="codeAd" style="display: none;">
                                <label class="col-sm-2 col-form-label">Ad Code</label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <textarea class="form-control" type="text" name="ad_code" style="height: 200px!important;">{{ $ad->ad_code }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label" id="HeaderCode">Head Code</label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <textarea class="form-control" type="text" name="head_code">{{ $ad->head_code }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">Footer Code</label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <textarea class="form-control" type="text" name="footer_code">{{ $ad->footer_code }}</textarea>
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

            function _AdType() {
                var selectedCountry = $('#AdType').children("option:selected").val();
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
            };

            $("#AdType").change(function() {
                _AdType();
            });
            setTimeout(function() {
                _AdType();
            }, 200);


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
            }, 200);
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
