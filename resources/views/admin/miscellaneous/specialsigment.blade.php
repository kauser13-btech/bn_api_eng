@extends('layouts.app')

@section('content')

    <form class="form-horizontal" action="{{ route('miscellaneous.sigment.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="id" value="2">

        <div class="col-md-12">
            @if (Session::has('success'))
                <script type="text/javascript">
                    setTimeout(function() {
                        md.showNotification('top', 'center', 'success', "{{ Session::get('success') }}").trigger('click');
                    }, 100);
                </script>
            @endif
            @if (Session::has('unauthorized'))
                <script type="text/javascript">
                    setTimeout(function() {
                        md.showNotification('top', 'center', 'danger', "{{ Session::get('unauthorized') }}").trigger('click');
                    }, 100);
                </script>
            @endif

            <div class="card">
                <div class="card-header card-header-primary card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">assignment</i>
                    </div>
                    <h4 class="card-title">Manage Special Sigment</h4>
                </div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <h4 class="title">Desktop Image</h4>
                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                    @if (json_decode($activeSpecial->arr_data)->desktop_img)
                                        <img 
                                            src="{{ \App\Helpers\ImageStoreHelpers::showImage('special_sigment', 'folder', json_decode($activeSpecial->arr_data)->desktop_img, '') }}">
                                    @else
                                        <img src="{{ asset('admin/img/image_placeholder.jpg') }}" alt="...">
                                    @endif
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                <div>
                                    <span class="btn btn-rose btn-round btn-file">
                                        <span class="fileinput-new"><i
                                                class="material-icons">file_present</i></span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="special_desktop_image" />
                                        <input type="hidden" name="old_special_desktop_image" id="old_special_desktop_image"
                                            value="{{ json_decode($activeSpecial->arr_data)->desktop_img }}">
                                    </span>
                                    <a href="#pablo"
                                        class="btn btn-danger btn-round fileinput-exists fileinput-remove"
                                        data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    @if (json_decode($activeSpecial->arr_data)->desktop_img)
                                        <a href="#pablo" class="btn btn-danger btn-round  oldfileinput-remove-desk"
                                            data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <h4 class="title">Mobile Image</h4>
                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                    @if (json_decode($activeSpecial->arr_data)->mobile_img)
                                        <img
                                            src="{{ \App\Helpers\ImageStoreHelpers::showImage('special_sigment', 'folder', json_decode($activeSpecial->arr_data)->mobile_img, '') }}">
                                    @else
                                        <img src="{{ asset('admin/img/image_placeholder.jpg') }}" alt="...">
                                    @endif
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                <div>
                                    <span class="btn btn-rose btn-round btn-file">
                                        <span class="fileinput-new"><i
                                                class="material-icons">file_present</i></span>
                                        <span class="fileinput-exists">Change</span>
                                        <input type="file" name="special_mobile_image" />
                                        <input type="hidden" name="old_special_mobile_image" id="old_special_mobile_image"
                                            value="{{ json_decode($activeSpecial->arr_data)->mobile_img }}">
                                    </span>
                                    <a href="#pablo1"
                                        class="btn btn-danger btn-round fileinput-exists fileinput-remove"
                                        data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    @if (json_decode($activeSpecial->arr_data)->mobile_img)
                                        <a href="#pablo1" class="btn btn-danger btn-round  oldfileinput-remove-mob"
                                            data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12 col-sm-12">
                            <hr>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Special Tag</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <select name="news_tags" class="ajax-tags form-control">
                                            @if ($tag)
                                                <option value="{{ $tag->id }}" selected>{{ $tag->name }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <hr>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <textarea class="form-control" cols="8" name="special_title">{!! json_decode($activeSpecial->arr_data)->title !!}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="togglebutton">
                                        <label>
                                            <input type="checkbox" name="special_display" value="1"
                                                @if (json_decode($activeSpecial->arr_data)->display == 1) checked @endif>
                                            <span class="toggle"></span>
                                            Display
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>





                        
                    </div>
                </div>
                <div class="card-footer ">
                    <button type="submit" class="btn btn-fill btn-rose">Update</button>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('breadcrumbs')
    Manage Watermark Ad
@endpush

@push('meta')
    <title>Manage Watermark Ad</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
<script>
    $('.ajax-tags').select2({
        ajax: {
            url: function(params) {
                var txt = params.term;
                return '{{ url('api/findtags') }}/' + txt;
            },
            delay: 250,
            processResults: function(data) {
                return {
                    results: data.results
                };
            }
        },
    });

    jQuery(document).ready(function($) {
        $('.oldfileinput-remove-desk').click(function(event) {
            $('#old_special_desktop_image').val('');
            $(this).remove();
            return false;
        });
        $('[name="special_desktop_image"]').click(function(event) {
            $('.oldfileinput-remove-desk').remove();
        });
    });


    jQuery(document).ready(function($) {
        $('.oldfileinput-remove-mob').click(function(event) {
            $('#old_special_mobile_image').val('');
            $(this).remove();
            return false;
        });
        $('[name="special_mobile_image"]').click(function(event) {
            $('.oldfileinput-remove-mob').remove();
        });
    });
</script>
@endpush
