@extends('layouts.app')

@section('content')

    <form class="form-horizontal" action="{{ route('news.update', $news->n_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <input type="hidden" name="edition" value="{{ Request::get('edition') }}">
        <input type="hidden" name="start_at" value="{{ $news->start_at }}">
        <input type="hidden" name="created_at" value="{{ $news->created_at }}">

        <div class="col-md-12">
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
            <div class="row">
                <div class="col-md-7">
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-text">
                                <h4 class="card-title">{{ ucfirst(Request::get('edition')) }} News Info</h4>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">News Solder</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <textarea class="form-control" name="n_solder" placeholder="News Solder">{!! $news->n_solder !!}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">News Headline</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <textarea class="form-control" name="n_head" required="true" placeholder="News Headline">{!! $news->n_head !!}</textarea>
                                    </div>
                                </div>
                                <label class="col-sm-1 label-on-right"><code>*</code></label>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">News Sub Headline</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <textarea class="form-control" name="n_subhead" placeholder="News Sub Headline">{!! $news->n_subhead !!}</textarea>
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
                                <h4 class="card-title">Meta & Social Tags</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Og Title Info</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="title_info"
                                            value="{{ $news->title_info }}" />
                                    </div>
                                </div>
                                <label class="col-sm-1 label-on-right"><code>*</code></label>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">keywords</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" name="meta_keyword" class="form-control tagsinput"
                                            data-role="tagsinput" data-color="info" value="{{ $news->meta_keyword }}">
                                    </div>
                                </div>
                                <label class="col-sm-1 label-on-right"><code>*</code></label>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Description <br> (Optional)</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <textarea class="form-control meta-desc" name="meta_description">{{ $news->meta_description }}</textarea>
                                        <div id="meta-count" class="text-danger">
                                            <span id="current_count">0</span>
                                            <span id="maximum_count">/ 160</span>
                                            <small>১২০ থেকে ১৫৫ অক্ষররের মধ্যে সীমিত রাখুন। - গুগল</small>
                                        </div>
                                    </div>
                                </div>
                                {{-- <label class="col-sm-1 label-on-right"><code>*</code></label> --}}
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-text">
                                <h4 class="card-title">Article</h4>
                            </div>
                            <button type="button" class="btn btn-link btn-warning btn-just-icon edit pull-right"
                                data-toggle="modal" data-target="#article_not">?</button>
                        </div>
                        <div class="card-body">
                            <textarea class="form-control" id="editor" name="n_details">{!! $news->n_details !!}</textarea>
                        </div>
                    </div>
                    <!-- Classic Modal -->
                    <div class="modal fade" id="article_not" tabindex="-1" role="dialog" aria-labelledby="WritersLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Not:</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                            class="material-icons">clear</i></button>
                                </div>
                                <div class="modal-body">
                                    <p class="mb-0">Twitter Embedded</p>
                                    <code>https://twitframe.com/show?url=Twitter Copy link</code>
                                    <p class="mb-0 mt-3">instagram Embedded</p>
                                    <code>https://instagram.com/p/Embed-ID/embed</code>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  End Modal -->
                </div>

                <div class="col-md-12 @if (Request::get('edition') != 'online') d-none @endif">
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-text">
                                <h4 class="card-title">Live Info</h4>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <label class="col-sm-4 col-form-label label-checkbox">Live News</label>
                                        <div class="col-sm-8 checkbox-radios">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="is_live"
                                                        value="1" @if ($news->is_live == 1) checked @endif>
                                                    yes
                                                    <span class="circle"><span class="check"></span></span>
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="is_live"
                                                        value="0" @if ($news->is_live == 0) checked @endif> no
                                                    <span class="circle"><span class="check"></span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <label class="col-sm-4 col-form-label label-checkbox">Is Live Active</label>
                                        <div class="col-sm-8 checkbox-radios">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="is_active_live"
                                                        value="1" @if ($news->is_active_live == 1) checked @endif>
                                                    yes
                                                    <span class="circle"><span class="check"></span></span>
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="is_active_live"
                                                        value="0" @if ($news->is_active_live == 0) checked @endif> no
                                                    <span class="circle"><span class="check"></span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <label class="col-sm-4 col-form-label">Parent News</label>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <select class="form-control _select2" name="parent_id">
                                                    <option value="0"
                                                        @if ($news->parent_id == 0) selected @endif>Select Parent News
                                                    </option>
                                                    @foreach ($livenewsSql as $lrow)
                                                        <option value="{{ $lrow->n_id }}"
                                                            @if ($news->parent_id == $lrow->n_id) selected @endif>
                                                            {{ $lrow->n_head }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <label class="col-sm-4 col-form-label label-checkbox">Is Linked</label>
                                        <div class="col-sm-8 checkbox-radios">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="is_linked"
                                                        value="1" @if ($news->is_linked == 1) checked @endif>
                                                    yes
                                                    <span class="circle"><span class="check"></span></span>
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="is_linked"
                                                        value="0" @if ($news->is_linked == 0) checked @endif>
                                                    no
                                                    <span class="circle"><span class="check"></span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-text">
                                <h4 class="card-title">Source</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <select name="divisions" id="divisions" class="form-control">
                                        <option @if ($news->divisions == '0') selected @endif value="0">বিভাগ
                                        </option>
                                        <option @if ($news->divisions == 'Dhaka') selected @endif value="Dhaka">ঢাকা
                                        </option>
                                        <option @if ($news->divisions == 'Chattagram') selected @endif value="Chattagram">
                                            চট্টগ্রাম</option>
                                        <option @if ($news->divisions == 'Rajshahi') selected @endif value="Rajshahi">
                                            রাজশাহী
                                        </option>
                                        <option @if ($news->divisions == 'Khulna') selected @endif value="Khulna">খুলনা
                                        </option>
                                        <option @if ($news->divisions == 'Barisal') selected @endif value="Barisal">বরিশাল
                                        </option>
                                        <option @if ($news->divisions == 'Sylhet') selected @endif value="Sylhet">সিলেট
                                        </option>
                                        <option @if ($news->divisions == 'Rangpur') selected @endif value="Rangpur">রংপুর
                                        </option>
                                        <option @if ($news->divisions == 'Mymensingh') selected @endif value="Mymensingh">
                                            ময়মনসিংহ</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <select name="districts" id="districts" class="form-control">
                                        <option value="0">জেলা</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <select name="upazilas" id="upazilas" class="form-control">
                                        <option value="0">উপজেলা</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label label-checkbox">Source line</label>
                                <div class="col-sm-10 col-sm-offset-1 checkbox-radios">
                                    <div class="checkbox-radios">
                                        @if (Request::get('edition') == 'print' || Request::get('edition') == 'magazine')
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="n_author"
                                                        value="নিজস্ব প্রতিবেদক"> নিজস্ব প্রতিবেদক
                                                    <span class="circle"><span class="check"></span></span>
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="n_author"
                                                        value="প্রেস বিজ্ঞপ্তি"> প্রেস বিজ্ঞপ্তি
                                                    <span class="circle"><span class="check"></span></span>
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="n_author"
                                                        value="প্রতিদিন ডেস্ক"> প্রতিদিন ডেস্ক
                                                    <span class="circle"><span class="check"></span></span>
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="n_author"
                                                        value="ষ্টাফ রিপোর্টার"> ষ্টাফ রিপোর্টার
                                                    <span class="circle"><span class="check"></span></span>
                                                </label>
                                            </div>
                                        @else
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="n_author"
                                                        value="নিজস্ব প্রতিবেদক"> নিজস্ব প্রতিবেদক
                                                    <span class="circle"><span class="check"></span></span>
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="n_author"
                                                        value="অনলাইন ডেস্ক"> অনলাইন ডেস্ক
                                                    <span class="circle"><span class="check"></span></span>
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="n_author"
                                                        value="প্রেস বিজ্ঞপ্তি"> প্রেস বিজ্ঞপ্তি
                                                    <span class="circle"><span class="check"></span></span>
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" name="n_author"
                                                        value="অনলাইন প্রতিবেদক"> অনলাইন প্রতিবেদক
                                                    <span class="circle"><span class="check"></span></span>
                                                </label>
                                            </div>
                                        @endif

                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="n_author"
                                                    value="other" checked> অন্যান্য/none
                                                <span class="circle"><span class="check"></span></span>
                                            </label>
                                            <input class="form-control" type="text" name="n_author_txt"
                                                value="{{ $news->n_author }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Writers Name</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <select class="form-control _select2" name="n_writer">
                                            <option value="">Select Writers</option>
                                            @foreach ($writers->where('type', 'writers') as $wrow)
                                                <option @if ($news->n_writer == $wrow->id) selected @endif
                                                    value="{{ $wrow->id }}">{{ $wrow->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Reporters</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <select class="form-control _select2" name="n_reporter">
                                            <option value="">Select Reporters</option>
                                            @foreach ($writers->where('type', 'reporters') as $wrow)
                                                <option @if ($news->n_reporter == $wrow->id) selected @endif
                                                    value="{{ $wrow->id }}">{{ $wrow->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-text">
                                <h4 class="card-title">Media</h4>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <h4 class="title">News Image</h4>
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            @if ($news->main_image)
                                                <img
                                                    src="{{ \App\Helpers\ImageStoreHelpers::showImage('news_images', $news->created_at, $news->main_image, 'thumbnail') }}">
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
                                                <input type="file" name="main_image" />
                                                <input type="hidden" name="old_main_image" id="old_main_image"
                                                    value="{{ $news->main_image }}">
                                            </span>
                                            <a href="#pablo"
                                                class="btn btn-danger btn-round fileinput-exists fileinput-remove"
                                                data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                            @if ($news->main_image)
                                                <a href="#pablo" class="btn btn-danger btn-round  oldfileinput-remove"
                                                    data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label label-checkbox">Watermark Ad</label>
                                        <div class="col-md-9 pull-right">
                                            <select class="form-control ajax_watermark_ads"
                                                data-style="select-with-transition" data-size="7" name="watermark">
                                                <option value="">No ad</option>
                                                @if ($watermark_ads)
                                                    <option value="{{ $watermark_ads->id }}" selected>
                                                        {{ $watermark_ads->name }} </option>
                                                @endif
                                            </select>
                                            <div class="clearfix"></div>
                                            <code>যদি ওয়াটারমার্ক বিজ্ঞাপনটি পরিবর্তন করা হয়, দয়া করে নিউজ ইমেজটি পুনরায়
                                                আপলোড করুন</code>
                                        </div>
                                        <div class="clearfix"></div>

                                        <label class="col-sm-2 col-form-label label-checkbox">Caption</label>
                                        <div class="col-sm-10 checkbox-radios">
                                            <div class="checkbox-radios">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="n_caption"
                                                            value="সংগৃহীত ছবি"> সংগৃহীত ছবি
                                                        <span class="circle"><span class="check"></span></span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="n_caption"
                                                            value="ফাইল ছবি"> ফাইল ছবি
                                                        <span class="circle"><span class="check"></span></span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="n_caption"
                                                            value="প্রতীকী ছবি"> প্রতীকী ছবি
                                                        <span class="circle"><span class="check"></span></span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="n_caption"
                                                            value="ছবি: বাংলানিউজটোয়েন্টিফোর"> ছবি: বাংলানিউজটোয়েন্টিফোর
                                                        <span class="circle"><span class="check"></span></span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="n_caption"
                                                            value="other" checked> অন্যান্য/none
                                                        <span class="circle"><span class="check"></span></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <textarea class="form-control" name="n_caption_txt" placeholder="Caption...">{!! $news->n_caption !!}</textarea>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <hr>
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">Embed Code</label>
                                        <div class="col-sm-7">
                                            <div class="form-group">
                                                <textarea id="embed_code" class="form-control" cols="8" name="embedded_code">{!! $news->embedded_code !!}</textarea>
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
                                        <div class="col-sm-3">
                                            <div class="col-sm-10 checkbox-radios">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input @if ($news->main_video == 1) checked @endif
                                                            class="form-check-input" type="radio" name="main_video"
                                                            value="1"> Main Video
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input @if ($news->main_video == 2) checked @endif
                                                            class="form-check-input" type="radio" name="main_video"
                                                            value="2"> Content Video
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input @if ($news->main_video == 0) checked @endif
                                                            class="form-check-input" type="radio" name="main_video"
                                                            value="0"> No video
                                                        <span class="circle">
                                                            <span class="check"></span>
                                                        </span>
                                                    </label>
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
                    <div class="card">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-text">
                                <h4 class="card-title">{{ Request::get('edition') != 'online' ? 'Order & ' : '' }} Display
                                    Settings</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (Request::get('edition') == 'print' || Request::get('edition') == 'magazine')
                                <div class="row">
                                    <label class="col-sm-4 col-form-label">News Order</label>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input class="form-control" type="number" name="n_order"
                                                value="{{ $news->n_order }}" />
                                        </div>
                                    </div>
                                    <label class="col-sm-2 label-on-right"><code>*</code></label>
                                </div>
                            @endif
                            <div class="row">
                                <label class="col-sm-4 col-form-label">Category</label>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <select class="form-control _select2" name="n_category" required>
                                            <option value="">Select Category</option>
                                            @foreach ($menus as $Mrow)
                                                @if ($Mrow->slug != '#')
                                                    <option value="{{ $Mrow->m_id }}"
                                                        @if ($news->n_category == $Mrow->m_id) selected @endif>
                                                        {{ $Mrow->m_name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 col-form-label label-checkbox">Category Lead item</label>
                                <div class="col-sm-8 checkbox-radios">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="category_lead"
                                                value="1" @if ($news->category_lead == 1) checked @endif> yes
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="category_lead"
                                                value="0" @if ($news->category_lead == 0) checked @endif> no
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 col-form-label label-checkbox">Home Lead</label>
                                <div class="col-sm-8 checkbox-radios">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="home_lead"
                                                value="1" @if ($news->home_lead == 1) checked @endif> yes
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="home_lead"
                                                value="0" @if ($news->home_lead == 0) checked @endif> no
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <div class="togglebutton">
                                            <label>
                                                <input type="checkbox" name="refetch-lead" value="1">
                                                <span class="toggle"></span>
                                                Refetch
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 col-form-label label-checkbox">Highlight Items</label>
                                <div class="col-sm-8 checkbox-radios">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="highlight_items"
                                                value="1" @if ($news->highlight_items == 1) checked @endif> yes
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="highlight_items"
                                                value="0" @if ($news->highlight_items == 0) checked @endif> no
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <div class="togglebutton">
                                            <label>
                                                <input type="checkbox" name="refetch-highlight" value="1">
                                                <span class="toggle"></span>
                                                Refetch
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 col-form-label label-checkbox">Focus Items</label>
                                <div class="col-sm-8 checkbox-radios">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="focus_items"
                                                value="1" @if ($news->focus_items == 1) checked @endif> yes
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="focus_items"
                                                value="0" @if ($news->focus_items == 0) checked @endif> no
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <div class="togglebutton">
                                            <label>
                                                <input type="checkbox" name="refetch-focus_items" value="1">
                                                <span class="toggle"></span>
                                                Refetch
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 col-form-label label-checkbox">Pin News</label>
                                <div class="col-sm-8 checkbox-radios">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="pin_news"
                                                value="1" @if ($news->pin_news == 1) checked @endif> yes
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="pin_news"
                                                value="0" @if ($news->pin_news == 0) checked @endif> no
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <div class="togglebutton">
                                            <label>
                                                <input type="checkbox" name="refetch-pin_news" value="1">
                                                <span class="toggle"></span>
                                                Refetch
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 col-form-label label-checkbox">Ticker News</label>
                                <div class="col-sm-8 checkbox-radios">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="ticker_news"
                                                value="1" @if ($news->ticker_news == 1) checked @endif> yes
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="ticker_news"
                                                value="0" @if ($news->ticker_news == 0) checked @endif> no
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 col-form-label label-checkbox">Home Category News</label>
                                <div class="col-sm-8 checkbox-radios">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="home_category"
                                                value="1" @if ($news->home_category == 1) checked @endif> yes
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="home_category"
                                                value="0" @if ($news->home_category == 0) checked @endif> no
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 col-form-label label-checkbox">Home Slide</label>
                                <div class="col-sm-8 checkbox-radios">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="home_slide"
                                                value="1" @if ($news->home_slide == 1) checked @endif> yes
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="home_slide"
                                                value="0" @if ($news->home_slide == 0) checked @endif> no
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <div class="togglebutton">
                                            <label>
                                                <input type="checkbox" name="refetch-slide" value="1">
                                                <span class="toggle"></span>
                                                Refetch
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 col-form-label label-checkbox">Multimedia Slide</label>
                                <div class="col-sm-8 checkbox-radios">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="multimedia_slide"
                                                value="1" @if ($news->multimedia_slide == 1) checked @endif> yes
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="multimedia_slide"
                                                value="0" @if ($news->multimedia_slide == 0) checked @endif> no
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <div class="togglebutton">
                                            <label>
                                                <input type="checkbox" name="refetch-multimedia-slide" value="1">
                                                <span class="toggle"></span>
                                                Refetch
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 col-form-label label-checkbox">Category Page Slide</label>
                                <div class="col-sm-8 checkbox-radios">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="cat_selected"
                                                value="1" @if ($news->cat_selected == 1) checked @endif> yes
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="cat_selected"
                                                value="0" @if ($news->cat_selected == 0) checked @endif> no
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 col-form-label label-checkbox">Is latest news</label>
                                <div class="col-sm-8 checkbox-radios">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="is_latest"
                                                value="1" @if ($news->is_latest == 1) checked @endif> yes
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="is_latest"
                                                value="0" @if ($news->is_latest == 0) checked @endif> no
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 col-form-label label-checkbox">Sticky Home</label>
                                <div class="col-sm-8 checkbox-radios">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="sticky" value="1"
                                                @if ($news->sticky == 1) checked @endif> yes
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="sticky" value="0"
                                                @if ($news->sticky == 0) checked @endif> no
                                            <span class="circle"><span class="check"></span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            @if (Auth::user()->role == 'developer' || Auth::user()->role == 'editor')
                                <div class="row">
                                    <label class="col-sm-4 col-form-label">Total Hit</label>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input class="form-control" type="number" name="most_read"
                                                value="{{ $news->most_read }}" />
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                    <div class="card ">
                        <div class="card-header card-header-rose card-header-text">
                            <div class="card-text">
                                <h4 class="card-title">Publishing</h4>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">Start publishing</label>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <input type="text" class="form-control datetimepicker"
                                                    placeholder="Start publishing" name="start_at"
                                                    value="{{ $news->start_at }}">
                                            </div>

                                            @if (date('m-d') == '12-31')
                                                <div class="alert alert-danger" role="alert">
                                                    অনুগ্রহ করে ০১ তারিখ publish হবে এমন কোনো নিউজ রাত ১২ টার আগে Start
                                                    publishing select করবেন না । ধন্যবাদ
                                                </div>
                                            @endif

                                        </div>
                                        <label class="col-sm-2 label-on-right"><code>*</code></label>
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
                                                            <input class="form-check-input" type="radio"
                                                                name="n_status" value="3"
                                                                @if ($news->n_status == 3) checked @endif> Publish
                                                            <span class="circle"><span class="check"></span></span>
                                                        </label>
                                                    </div>
                                                    @if (Request::get('edition') != 'online' && Request::get('edition') != 'multimedia')
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input class="form-check-input" type="radio"
                                                                    name="n_status" value="2"
                                                                    @if ($news->n_status == 2) checked @endif> Save
                                                                <span class="circle"><span class="check"></span></span>
                                                            </label>
                                                        </div>
                                                    @endif
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="radio"
                                                                name="n_status" value="1"
                                                                @if ($news->n_status == 1) checked @endif> Draft
                                                            <span class="circle"><span class="check"></span></span>
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="radio"
                                                                name="n_status" value="0"
                                                                @if ($news->n_status == 0) checked @endif> Inactive
                                                            <span class="circle"><span class="check"></span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-sm-2 label-on-right"><code>*</code></label>
                                        </div>
                                    </div>
                                </div>

                                @if (isset($archive[0]))
                                    <div class="col-md-12">
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Archive</label>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <button type="button" class="btn btn-primary btn-round"
                                                        data-toggle="modal" data-target="#news-archive">Timeline</button>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="news-archive" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Archive Timeline</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true"><i
                                                                    class="material-icons">clear</i></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <ul class="timeline timeline-simple">
                                                                @foreach ($archive as $arow)
                                                                    <li class="timeline-inverted">
                                                                        <div class="timeline-badge danger"><i
                                                                                class="material-icons">alarm</i></div>
                                                                        <div class="timeline-panel">
                                                                            <div class="timeline-heading">
                                                                                <span
                                                                                    class="badge badge-pill badge-danger">{{ $arow->updatedBy->name }}</span>
                                                                            </div>
                                                                            <div class="timeline-body">
                                                                                <a
                                                                                    href="{{ url('admin/news/' . $news->n_id . '/edit?archiveid=' . $arow->id . '&edition=' . Request::get('edition')) }}">{{ $arow->n_head }}</a>
                                                                            </div>
                                                                            <h6><i class="ti-time"></i>
                                                                                {{ $arow->edited_at }}</h6>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger btn-link"
                                                                data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card-footer ml-auto mr-auto">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-rose">Submit</button>
                            <a href="{{ url('admin/news/' . $news->n_id . '/release?edition=' . Request::get('edition')) }}"
                                class="btn btn-warning">Cancel</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>

@endsection

@push('breadcrumbs')
    News Add
@endpush

@push('meta')
    <title>News Add</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
    <script src="{{ asset('admin/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('admin/tinymce/tinymce.min.js') }}"></script>
    <script>
        CKEDITOR.replace('editor', {
            on: {
                paste: function(evt) {
                    if (evt.data.dataValue) {
                        evt.data.dataValue = removeAllStyles(evt.data.dataValue);
                    }
                },
                instanceReady: function(evt) {
                    var itemTemplate =
                        '<li data-id="{id}" style="margin-bottom: 5px;border-bottom: 1px solid #ccc;padding-bottom: 5px;">' +
                        '<div><img src="{img}" width="100" height="66"></div>' +
                        '<div><strong class="item-title" style="font-size: 14px;margin-top:8px;display: block;">{name}</strong></div>' +
                        '<div><time style="font-size: 14px;">{f_date}</time>' +
                        '</li>',
                        outputTemplate =
                        '<div class="d-flex justify-content-center"><div class="col-12 col-md-10 position-relative" data-id="{id}">' +
                        '<strong>আরো পড়ুন</strong>' +
                        '<div class="card">' +
                        '<div class="row">' +
                        '<div class="col-4 col-md-3">' +
                        '<img src="{img}" class="img-fluid rounded-start m-0 w-100" alt="{name}" width="100" height="66">' +
                        '</div>' +
                        '<div class="col-8 col-md-9"><p class="p-1 m-0 lh-sm">{name}</p></div>' +
                        '</div>' +
                        '</div>' +
                        '<a class="stretched-link" target="_blank" href="{link}">&nbsp;</a>' +
                        '</div></div>';


                    var autocomplete = new CKEDITOR.plugins.autocomplete(evt.editor, {
                        textTestCallback: textTestCallback,
                        dataCallback: debounce(dataCallback, 800),
                        itemTemplate: itemTemplate,
                        outputTemplate: outputTemplate
                    });

                    // Override default getHtmlToInsert to enable rich content output.
                    autocomplete.getHtmlToInsert = function(item) {
                        return this.outputTemplate.output(item);
                    }
                },
                insertElement: function(event) {
                    var element = event.data;
                    if (element.getName() == 'table') {
                        var div = new CKEDITOR.dom.element('div').addClass('table-responsive');
                        event.data.appendTo(div);
                        event.data = div;
                        element.addClass('table');
                        element.addClass('table');
                        element.addClass('table-bordered');
                    }
                }
            },
            mentions: [{
                marker: '@top10',
                feed: topNewsCallback,
                itemTemplate: '<li data-id="{id}" style="margin-bottom: 5px;border-bottom: 1px solid #ccc;padding-bottom: 5px;">' +
                    '<div><img src="{img}" width="100" height="66"></div>' +
                    '<div><strong class="item-title" style="font-size: 14px;margin-top:8px;display: block;">{name}</strong></div>' +
                    '<div><time style="font-size: 14px;">{f_date}</time>' +
                    '</li>',
                outputTemplate: '<div class="col-12 mb-3 topNewsCallback position-relative" data-id="{id}">' +
                    '<div class="card rounded-0">' +
                    '<div class="row">' +
                    '<div class="col-12 col-md-3 col-lg-12 col-xl-3">' +
                    '<img src="{img}" class="w-100 h-100" alt="{n_head}">' +
                    '</div>' +
                    '<div class="col-12 col-md-3 col-lg-12 col-xl-9">' +
                    '<div class="card-body m-0 pb-0 pt-2 ps-2 ps-lg-2 ps-xl-0">' +
                    '<h3>{n_head}</h3>' +
                    '<p class="card-text">{n_details}</p>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<a class="stretched-link" target="_blank" href="{link}">&nbsp;</a>' +
                    '</div>',
                minChars: 0
            }],
            removeButtons: 'PasteFromWord',
            embed_provider: '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}',
            height: 250,
            @if (Auth::user()->role != 'subscriber')
                filebrowserImageBrowseUrl: '/admin/news-filemanager?type=Images',
                filebrowserImageUploadUrl: '/admin/news-filemanager/upload?type=Images&_token=',
                filebrowserBrowseUrl: '/admin/news-filemanager?type=Files',
                filebrowserUploadUrl: '/admin/news-filemanager/upload?type=Files&_token='
            @endif
        });

        @if (Request::get('edition') == 'print')
            //CKEDITOR.config.forcePasteAsPlainText = true;
        @endif

        function removeAllStyles(content) {
            return content
                // Direct font-size style remove
                .replace(/\sstyle="font-size:[^"]*"/gi, '')
                // Direct font-family style remove
                .replace(/\sstyle="font-family:[^"]*"/gi, '')
                // Font-size with quotes handle
                .replace(/\sstyle="font-size:\s*[^"]*"/gi, '')
                // Font-family with quotes handle  
                .replace(/\sstyle="font-family:\s*[^"]*"/gi, '')
                // Handle &quot; encoded quotes
                .replace(/\sstyle="font-family:\s*&quot;[^"]*&quot;[^"]*"/gi, '')
                // Empty spans with &nbsp;
                .replace(/<span><\/span>/g, '')
                .replace(/<span>&nbsp;<\/span>/g, '')
                .replace(/<span>\s*&nbsp;\s*<\/span>/g, '')
                .replace(/<span[^>]*><span[^>]*><\/span><\/span>/g, '')
                // Clean empty styles
                .replace(/\sstyle="[\s]*"/gi, '');
        }

        function textTestCallback(range) {
            if (!range.collapsed) {
                return null;
            }

            return CKEDITOR.plugins.textMatch.match(range, matchCallback);
        }

        function matchCallback(text, offset) {
            var pattern = /\[{2}/,
                match = text.slice(0, offset)
                .match(pattern);

            if (!match) {
                return null;
            }

            return {
                start: match.index,
                end: offset
            };
        }

        function dataCallback(matchInfo, callback) {
            var txt = encodeURI(matchInfo.query.substring(2));

            if (txt == '') {
                txt = 'none';
            }

            $.ajax({
                url: `{{ url('api/findmorenews/') }}/${txt}`,
                type: 'GET',
                success: function(res) {
                    var data = res.filter(function(item) {
                        var itemName = '[[' + item.name + ']]';
                        return itemName.indexOf(matchInfo.query.toLowerCase()) == 0;
                    });
                    callback(data);
                }
            });
        }

        function topNewsCallback(matchInfo, callback) {
            $.ajax({
                url: `{{ url('api/topNewsCallback') }}`,
                type: 'GET',
                success: function(res) {
                    var data = res.filter(function(item) {
                        var itemName = '[[' + item.name + ']]';
                        return itemName.indexOf(matchInfo.query.toLowerCase()) == 0;
                    });
                    callback(data);
                }
            });
        }


        jQuery(document).ready(function($) {
            $('.oldfileinput-remove').click(function(event) {
                $('#old_main_image').val('');
                $(this).remove();
                return false;
            });
            $('[name="main_image"]').click(function(event) {
                $('.oldfileinput-remove').remove();
            });
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

        tinymce.init({
            selector: '.tinymce',
            menubar: false,
            branding: false,
            height: "110"
        });

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

        function divisions() {
            var divisionsId = $('#divisions').find(":selected").val();
            $.ajax({
                url: "{{ url('bangladesh-geocode/districts.json') }}",
                success: function(data) {
                    var $districts = $('#districts');
                    $districts.empty();
                    $districts.append('<option id="0" value="">জেলা</option>');
                    for (var i = 0; i < data.length; i++) {
                        if (divisionsId == data[i].division_id) {
                            $districts.append('<option id=' + data[i].name + ' value=' + data[i].name + '>' +
                                data[i].bn_name + '</option>');
                        }
                    }
                }
            });
        }

        function districts() {
            var districtsId = $('#districts').find(":selected").val();
            $.ajax({
                url: "{{ url('bangladesh-geocode/upazilas.json') }}",
                success: function(data) {
                    var $upazilas = $('#upazilas');
                    $upazilas.empty();
                    $upazilas.append('<option id="0" value="">উপজেলা</option>');
                    for (var i = 0; i < data.length; i++) {
                        if (districtsId == data[i].district_id) {
                            $upazilas.append('<option id=' + data[i].name + ' value=' + data[i].name + '>' +
                                data[i].bn_name + '</option>');
                        }
                    }
                }
            });
        }
        jQuery(document).ready(function($) {
            $('#divisions').change(function() {
                divisions();
            });
            $('#districts').change(function() {
                districts();
            });
            setTimeout(() => {
                divisions();
            }, 100);
            setTimeout(() => {
                $("#districts option[value={{ $news->districts }}]").attr('selected', 'selected');
                districts();
            }, 200);
            setTimeout(() => {
                $("#upazilas option[value={{ $news->upazilas }}]").attr('selected', 'selected');
            }, 300);

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
    </script>
@endpush
