@extends('layouts.app')

@section('content')
    @php
        if ($news->main_image) {
            $news_img = \App\Helpers\ImageStoreHelpers::showImage(
                'news_images',
                $news->created_at,
                $news->main_image,
                '',
            );
        } else {
            $news_img = asset('admin/img/image_placeholder.jpg');
        }
    @endphp
    <div class="mb-5">
        <div class="row">
            <div class="col-2">
                <a href="#" class="btn btn-block btn-primary mb-3" id="btnDownload">Download</a>
                <a href="#" class="btn btn-block btn-primary mb-3" id="enableDraggable">Draggable</a>
                <a href="#" class="btn btn-block btn-primary mb-3" id="disableDraggable">Edit Text</a>

                <hr>

                <div class="card p-2">
                    <span class="btn btn-rose btn-round btn-file">
                        <span class="fileinput-new">Custom Image</span>
                        <input type="file" name="custom-image" onchange="loadFile(event)" />
                    </span>
                </div>

                <hr>

                <div class="card p-2">
                    <select class="form-control _select2" id="watermark_list">
                        <option value="">Watermark Ad List</option>
                        @foreach ($watermark_list as $wrow)
                            @if ($watermark_ad)
                                <option @if ($wrow->id == $watermark_ad->id) selected @endif value="{{ $wrow->id }}">
                                    {{ $wrow->name }}</option>
                            @else
                                <option value="{{ $wrow->id }}">{{ $wrow->name }}</option>
                            @endif
                        @endforeach
                    </select>

                    <div style="margin-bottom: 15px"></div>

                    <select class="form-control _select2" id="card_list">
                        <option value="">News Card List</option>
                        @foreach ($card_list as $wrow)
                            <option @if ($wrow->id == $news_card_ad->id) selected @endif value="{{ $wrow->id }}">
                                {{ $wrow->name }}</option>
                        @endforeach
                    </select>

                    <div style="margin-bottom: 15px"></div>

                    <div class="togglebutton">
                        <label>
                            <input id="n_solder" type="checkbox" name="n_solder" value="1"
                                @if (Request::segment(6) == 1) checked @endif>
                            <span class="toggle"></span>
                            Show News Solder
                        </label>
                    </div>

                    <div style="margin-bottom: 15px"></div>

                    <button id="updateCard" type="submit" class="btn btn-block btn-primary">Update</button>
                </div>

            </div>
            <div class="col-10">
                <div id="capture" class="text-center bg-info align-middle">
                    <img class="w-100 h-auto news-img" src="{{ \App\Helpers\generalHelper::getImageAsData($news_img) }}"
                        alt="alt" id="customPreviewImg">

                    @if ($news_card_ad)
                        <img class="w-100 h-100 z1"
                            src="{{ \App\Helpers\generalHelper::getImageAsData(\App\Helpers\ImageStoreHelpers::showImage('ads_images', $news_card_ad->created_at, $news_card_ad->ad_img, '')) }}"
                            alt="alt">
                    @endif

                    <time>{{ App\Helpers\generalHelper::bn_date(date('d F Y', strtotime($news->n_date))) }}</time>

                    @if ($news->n_caption)
                        <div class="draggable">
                            <div class="n_author">
                                <div class="editor2">
                                    <p style="text-align: left;"><strong>{{ $news->n_caption }}</strong></p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="draggable">
                        <div style="position: absolute;width: 100%;">
                            <div class="editor">
                                @if (Request::segment(6) == 1)
                                    <p style="text-align: center;">
                                        <span class="text-tiny"
                                            style="color:hsl(0, 75%, 60%);">{!! $news->n_solder !!}</span>
                                    </p>
                                @endif

                                <p style="text-align: center;">
                                    {{ $news->n_head }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div id="ad-draggable">
                        @if ($watermark_ad)
                            <img class="is-resizable"
                                src="{{ \App\Helpers\generalHelper::getImageAsData(\App\Helpers\ImageStoreHelpers::showImage('ads_images', $watermark_ad->created_at, $watermark_ad->ad_img, '')) }}"
                                alt="alt">
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumbs')
    News Card
@endpush

@push('meta')
    <title>News Card</title>
@endpush

@push('stylesheet')
    <style>
        @font-face {
            font-family: 'Varendra';
            src: url('/admin/fonts/card/Varendra-Regular.woff2') format('woff2'),
                url('/admin/fonts/card/Varendra-Regular.woff') format('woff');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        #capture .z1 {
            position: absolute;
            z-index: 1;
            left: 0;
            top: 0;
            right: 0;
        }

        .draggable {
            z-index: 3;
            top: 30px;
            left: 0;
            right: 0;
        }

        #ad-draggable {
            position: absolute;
            z-index: 2;
            bottom: 0;
            left: 0;
            right: 0;
        }

        /*  {{ asset('admin/inline-editor/fonts/LiAdorNoirritAV2VR-VF.eot') }} */
        .editor {
            font-size: 36px;
            min-height: 122px;
            line-height: 40px;
            font-family: 'Varendra';
            color: #000;
        }

        .editor h1,
        .editor h2,
        .editor h3,
        .editor h4,
        .editor h5,
        .editor h6,
        .editor p,
        .editor span,
        .editor strong {
            font-family: 'Varendra';
            margin: 0 !important;
            padding: 0 !important;
        }

        #capture {
            width: 800px;
            height: 800px;
            position: relative;
            overflow: hidden;
        }

        #capture .news-img {
            height: 408px;
            margin: 85px 0 0 0;
            width: 704px !important;
            object-fit: cover;
        }

        #ad-draggable img {
            width: 800px;
            min-height: 80px;
        }

        .ck-content p {
            font-size: 3rem;
            line-height: 3.9rem;
            font-weight: bold;
        }

        .ck-content strong {
            font-weight: bold;
        }

        .ck-content .text-tiny {
            font-size: 0.7em;
        }

        .ck-content .text-small {
            font-size: 0.85em;
        }

        .ck-content .text-big {
            font-size: 1.4em;
            line-height: 4rem;
        }

        .ck-content .text-huge {
            font-size: 1.8em;
            line-height: 5rem;
        }

        .ck.ck-editor__editable_inline {
            overflow: unset !important;
        }

        #target {
            position: absolute;
            right: 0;
            top: 0;
            z-index: 999;
            display: block !important;
        }

        time {
            position: absolute;
            left: 26px;
            bottom: 18px;
            z-index: 3;
            font-size: 20px;
            color: #000;
            font-weight: bold;
        }

        .n_author {
            position: absolute;
            right: unset;
            left: 58px;
            bottom: 26px;
            z-index: 3;
        }

        .n_author .editor {
            color: black;
            min-height: auto;
        }

        .n_author .ck-content p {
            font-size: 14px;
            margin: 0 !important;
        }
    </style>

    {!! $news_card_ad ? $news_card_ad->head_code : '' !!}
@endpush

@push('scripts')
    <script src="{{ asset('admin/inline-editor/html2canvas.min.js') }}"></script>
    <script src="{{ asset('admin/inline-editor/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('admin/inline-editor/ckeditor.js') }}"></script>

    <script>
        $('#updateCard').click(function() {
            let watermark_list = $("#watermark_list").find(":selected").val();
            let card_list = $("#card_list").find(":selected").val();
            let n_solder = $('#n_solder:checked').val();

            let watermark_id = (watermark_list != '') ? watermark_list : 0
            let card_id = (card_list != '') ? card_list : 0
            let nsolder = (n_solder == undefined) ? 0 : 1

            window.location.href =
                `{{ url('admin/newsCard/' . $news->n_id) }}/${watermark_id}/${card_id}/${nsolder}`;
        })

        BalloonEditor.create(document.querySelector('.editor'), {}).then(editor => {
            window.editor = editor;
        });

        BalloonEditor.create(document.querySelector('.editor2'), {}).then(editor => {
            window.editor = editor;
        });

        function download(url) {
            var a = $("<a style='display:none' id='js-downloder'>")
                .attr("href", url)
                .attr("download", "{{ $news->n_head }}.png")
                .appendTo("body");
            a[0].click();
            a.remove();
        }

        function saveCapture(element) {
            html2canvas(element, {
                useCORS: true,
                allowTaint: true,
                dpi: 144,
            }).then(function(canvas) {
                download(canvas.toDataURL("image/png"));
                // document.body.appendChild(canvas);
            })
        }

        var loadFile = function(event) {

            var input = event.target;
            var image = document.getElementById('customPreviewImg');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    image.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }

        };

        $(function() {
            $("#ad-draggable").draggable().resizable();

            // $(".draggable").draggable('disable');
            $(".draggable").draggable();
            $("#enableDraggable").css('display', 'none');

            $(document).on('click', '#enableDraggable', function() {
                $(".draggable").draggable('enable');
                $("#enableDraggable").css('display', 'none');
                $("#disableDraggable").css('display', 'block');
                return false;
            });

            $(document).on('click', '#disableDraggable', function() {
                $(".draggable").draggable('disable');
                $("#enableDraggable").css('display', 'block');
                $("#disableDraggable").css('display', 'none');
                return false;
            });

            $('#btnDownload').click(function() {
                var element = document.querySelector("#capture");
                saveCapture(element)
                return false;
            })
        });
    </script>

    {!! $news_card_ad ? $news_card_ad->footer_code : '' !!}
@endpush
