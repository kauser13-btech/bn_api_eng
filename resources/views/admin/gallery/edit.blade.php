@extends('layouts.app')

@section('content')

    <form class="form-horizontal" action="{{ route('gallery.update', $gallery->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <input type="hidden" name="created_at" value="{{ $gallery->created_at }}">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (Session::has('success'))
            <script type="text/javascript">
                setTimeout(function() {
                    md.showNotification('top', 'center', 'success', "{{ Session::get('success') }}").trigger('click');
                }, 100);
            </script>
        @endif

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-7">
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-text">
                                <h4 class="card-title">Gallery Info</h4>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Album</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $gallery->name }}">
                                    </div>
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Album Caption</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <textarea class="form-control" name="caption">{{ $gallery->caption }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">Cover Photo</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail">
                                                <img src="{{ \App\Helpers\ImageStoreHelpers::showImage('gallery', $gallery->created_at, $gallery->cover_photo, 'thumb') }}"
                                                    alt="Ad Image">
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                            <div>
                                                <span class="btn btn-rose btn-round btn-file">
                                                    <span class="fileinput-new"><i
                                                            class="material-icons">file_present</i></span>
                                                    <span class="fileinput-exists">Change</span>
                                                    <input type="file" name="cover_photo" />
                                                    <input type="hidden" name="old_cover_photo"
                                                        value="{{ $gallery->cover_photo }}">
                                                </span>
                                                <a href="#pablo" class="btn btn-danger btn-round fileinput-exists"
                                                    data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                            </div>
                                            <code>Cover Photo Size 1000X660</code>
                                        </div>
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
                                <h4 class="card-title">Display Settings</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Type</label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <select id="Gtype" class="selectpicker" data-size="7"
                                            data-style="select-with-transition" name="type">
                                            <option @if ($gallery->type == 'photo') selected @endif value="photo">Photo
                                            </option>
                                            <option @if ($gallery->type == 'video') selected @endif value="video">Video
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">Category</label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <select class="form-control ajax-select2" name="category" required>
                                            <option @if ($gallery->category == $gallery->category) selected @endif
                                                value="{{ $gallery->category }}">{{ $gallery->catName->name }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label label-checkbox">Watermark Ad</label>
                                <div class="col-md-10 pull-right">
                                    <select class="form-control ajax_watermark_ads" data-style="select-with-transition"
                                        data-size="7" name="watermark">
                                        <option value="">No ad</option>
                                        @if ($watermark_ads)
                                            <option value="{{ $watermark_ads->id }}" selected>{{ $watermark_ads->name }}
                                            </option>
                                        @endif
                                    </select>
                                    <div class="clearfix"></div>
                                    <code>যদি ওয়াটারমার্ক বিজ্ঞাপন পরিবর্তন করা হয়, অনুগ্রহ করে কভার ফটো পুনরায় আপলোড
                                        করুন</code>
                                </div>
                            </div>

                            <div id="special_video">
                                <div class="row">
                                    <label class="col-sm-3 col-form-label">Show Home Page</label>
                                    <div class="col-sm-9">
                                        <div class="form-check mt-3">
                                            <label class="form-check-label">
                                                <input name="special_video" class="form-check-input" type="checkbox"
                                                    value="1" @if ($gallery->special_video == 1) checked @endif> Yes
                                                <span class="form-check-sign"><span class="check"></span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-3 col-form-label">Home Slide</label>
                                    <div class="col-sm-9">
                                        <div class="form-check mt-3">
                                            <label class="form-check-label">
                                                <input name="slide_video" class="form-check-input" type="checkbox"
                                                    value="1" @if ($gallery->slide_video == 1) checked @endif> Yes
                                                <span class="form-check-sign"><span class="check"></span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-text">
                                <h4 class="card-title">Media</h4>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12 col-sm-12" id="typeImage">
                                    <div class="alert alert-rose alert-with-icon mt-3" data-notify="container">
                                        <i class="material-icons" data-notify="icon">notifications</i>
                                        <span data-notify="message">Minimum required 5 Image</span>
                                    </div>
                                    <h4 class="title my-2">Photos</h4>
                                    @error('images.*')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div class="fileinput fileinput-new text-center col-md-12" data-provides="fileinput">
                                        <div class="gallery_img">
                                            @if ($gallery->images)
                                                @foreach (unserialize($gallery->images) as $row)
                                                    <div class="img_list">
                                                        <button
                                                            class="btn btn-just-icon btn-round btn-youtube close-img-del"
                                                            type="button"><input name="del[]" class="form-check-input"
                                                                type="checkbox" value="{{ $row['image'] }}"></button>
                                                        <img src="{{ \App\Helpers\ImageStoreHelpers::showImage('gallery', $gallery->created_at, $row['image'], 'thumb') }}"
                                                            alt="Ad Image">
                                                        <input type="hidden" name="old_img[]"
                                                            value="{{ $row['image'] }}">
                                                        <textarea name="old_cap[]" rows="4">{{ $row['text'] }}</textarea>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="clearfix"></div>
                                        <div>
                                            <span class="btn btn-rose btn-round btn-file">
                                                <span class="fileinput-new"><i
                                                        class="material-icons">file_present</i></span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="images[]" multiple id="gallery-photo-add"
                                                    onchange="preview_image();" />
                                            </span>
                                            <a id="removeImg" href="#pablo2"
                                                class="btn btn-danger btn-round fileinput-exists"
                                                data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12" id="typeVideo">
                                    <hr>
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">Embed Code</label>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <textarea id="embed_code" class="form-control" rows="8" name="embed_code">{!! $gallery->embed_code !!}</textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <code>YouTube, Facebook</code>
                                                </div>
                                                <div class="col text-right">
                                                    <button id="generate_embed_code" type="button"
                                                        class="btn btn-info">Get Embed</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-text">
                                <h4 class="card-title">Meta & Social Tags</h4>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Title Info</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="title_info"
                                            value="{{ $gallery->title_info }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">keywords</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" name="keywords" class="form-control tagsinput"
                                            data-role="tagsinput" data-color="info" value="{{ $gallery->keywords }}">
                                    </div>
                                </div>
                                <label class="col-sm-1 label-on-right"><code>required</code></label>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <textarea class="form-control meta-desc" name="description" required>{{ $gallery->description }}</textarea>
                                    </div>
                                    <div id="meta-count" class="text-danger">
                                        <span id="current_count">0</span>
                                        <span id="maximum_count">/ 160</span>
                                        <small>১২০ থেকে ১৫৫ অক্ষররের মধ্যে সীমিত রাখুন। - গুগল</small>
                                    </div>
                                </div>
                                <label class="col-sm-1 label-on-right"><code>required</code></label>
                            </div>

                        </div>
                    </div>
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-text">
                                <h4 class="card-title">Order & publishing</h4>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="col-md-12">
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Start publishing</label>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <input type="text" class="form-control datetimepicker" name="start_at"
                                                value="{{ $gallery->start_at }}">
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
                                                        <input class="form-check-input" type="radio" name="status"
                                                            value="1"
                                                            @if ($gallery->status == 1) checked @endif> Active
                                                        <span class="circle"><span class="check"></span></span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="status"
                                                            value="0"
                                                            @if ($gallery->status == 0) checked @endif> Inactive
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
                        <button type="submit" class="btn btn-rose">Update</button>
                    </div>
                </div>
            </div>

        </div>
    </form>

@endsection

@push('breadcrumbs')
    Edit Add
@endpush

@push('meta')
    <title>News Add</title>
@endpush

@push('stylesheet')
    <style type="text/css">
        .gallery_img .img_list {
            display: block;
            width: 100%;
            height: 100px;
            margin-bottom: 8px;
        }

        .gallery_img img {
            width: 100px;
            height: 100px;
            float: left;
        }

        .gallery_img textarea {
            width: 70%;
            float: right;
        }

        .gallery_img .img_list {
            position: relative;
        }

        .gallery_img .img_list .close-img-area,
        .gallery_img .img_list .close-img-del {
            position: absolute;
            left: -20px;
            top: -20px;
        }

        .gallery_img .img_list .close-img-del input {
            margin: -6px 0 0 -7px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        jQuery(document).ready(function($) {
            setTimeout(function() {
                $("#Gtype select").val("{{ $gallery->type }}").change();
            }, 200);

            function mediaType() {
                var Gtype = $('#Gtype').children("option:selected").val();
                if (Gtype == 'photo') {
                    $('#typeImage').css('display', 'block');
                    $('#typeVideo').css('display', 'none');
                    $('#special_video').css('display', 'none');
                } else {
                    $('#removeImg').trigger('click');
                    $('#typeImage').css('display', 'none');
                    $('#typeVideo').css('display', 'block');
                    $('#special_video').css('display', 'block');
                }
            }
            mediaType();

            $('body').on('click', '.close-img-area', function(event) {
                event.preventDefault();
                $(this).parents('.img_list').remove();

            });

            $("#Gtype").change(function() {
                $('.ajax-select2').empty();
                mediaType();
            });

            $('.ajax-select2').select2({
                ajax: {
                    url: function(params) {
                        var Gtype = $('#Gtype').children("option:selected").val();
                        return '{{ url('api/findgallerycat') }}/' + Gtype;
                    },
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: data.results
                        };
                    }
                },
            });

            $("#generate_embed_code").click(function() {
                let embedded_code = $('#embed_code').val();
                if (embedded_code) {
                    $.ajax({
                        url: "{{ url('/api/embedSocial') }}",
                        type: "post",
                        data: {
                            'url': encodeURI(embedded_code)
                        },
                        success: function(embed) {
                            if (embed.status == 'error') {
                                $("#embed_code").val('');
                                alert(embed.error)
                            } else {
                                alert(`Successfully ${embed.platform} Embedded`)
                                $("#embed_code").val(embed.embed_link);
                            }
                        }
                    });
                }
            });
        });

        function preview_image() {
            var total_file = document.getElementById("gallery-photo-add").files.length;
            for (var i = 0; i < total_file; i++) {
                $('.gallery_img').append(
                    '<div class="img_list"><button class="btn btn-just-icon btn-round btn-youtube close-img-area"><i class="fa fa-times" onclick="return confirm(\'Are you sure you want to delete this item?\');"></i></button><img src="' +
                    URL.createObjectURL(event.target.files[i]) + '"><textarea name="cap[]" rows="4"></textarea></div>');
            }
        }

        $(function() {
            // $( "#gallery-form" ).submit(function( event ) {
            // 	var Gtype = $('#Gtype').children("option:selected").val();
            // 	if(Gtype=='photo'){
            // 		var total_file=document.getElementById("gallery-photo-add").files.length;
            // 	    if(total_file < 3){
            // 			event.preventDefault();
            // 	    	swal({ title:"Oops...", text: "Minimum required 10 Image", type: "danger", buttonsStyling: false, confirmButtonClass: "btn btn-danger"}).trigger('click');
            // 	    }
            // 	}
            // });

            $('#removeImg').click(function(event) {
                $('.gallery_img').html('');
            });
            $('.meta-desc').keyup(function() {
                var characterCount = $(this).val().length,
                    current_count = $('#current_count'),
                    maximum_count = $('#maximum_count'),
                    count = $('#meta-count');
                current_count.text(characterCount);
            });

            $('.ajax_watermark_ads').select2({
                ajax: {
                    url: function(params) {
                        var txt = params.term;
                        return '{{ url('api/findwatermarkads') }}/' + txt;
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
