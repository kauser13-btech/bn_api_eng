@extends('layouts.app')

@section('content')
    <form class="form-horizontal" action="{{ route('news.sortupdate') }}" method="POST">
        @csrf
        <input type="hidden" name="mid" value="{{ $mid }}">
        <input type="hidden" name="edition" value="{{ Request::get('edition') }}">
        <div class="row">
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
                        <h4 class="card-title">News List</h4>
                    </div>
                    <div class="card-body">
                        <div class="material-datatables">
                            <table class="table" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl. No</th>
                                        <th></th>
                                        <th></th>
                                        <th>News Headline</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sl. No</th>
                                        <th></th>
                                        <th></th>
                                        <th>News Headline</th>
                                    </tr>
                                </tfoot>
                                <tbody id="sort-home-category-news">
                                    @foreach ($news as $row)
                                        @php
                                            if($row->edition == 'online')
                                                $edition = 'online';
                                            elseif($row->edition == 'multimedia')
                                                $edition = 'multimedia';
                                            else
                                                $edition = 'print';
                                        @endphp
                                        <tr id="{{ $row->$order_name }}" style="cursor: move;">
                                            <td class="text-info">{{ $loop->index }}</td>
                                            <td>
                                                <a href="{{ url('admin/news/' . $row->n_id . '/edit?edition=' . $edition) }}"
                                                    class="btn btn-link btn-warning btn-just-icon edit" target="_blank">
                                                    <i class="material-icons" style="font-size:32px;">edit_note</i>
                                                </a>
                                            </td>
                                            <td>
                                                {!! $row->sticky == 1 &&
                                                ($order_name == 'leadnews_order' ||
                                                    $order_name == 'highlight_order' ||
                                                    $order_name == 'focus_order' ||
                                                    $order_name == 'pin_order')
                                                    ? '<button class="btn btn-rose btn-round">Sticky</button>'
                                                    : '' !!}
                                            </td>
                                            <td>
                                                {{ $row->n_head }}
                                                <input type="hidden" value="{{ $row->$order_name }}"
                                                    class="sort pull-right" name="n_order[]">
                                                <input type="hidden" value="{{ $row->n_id }}" name="n_id[]">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <input type="hidden" value="{{ $order_name }}" name="order_name">
                        </div>
                    </div>
                    <div class="card-footer ">
                        <button type="submit" class="btn btn-fill btn-rose">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('breadcrumbs')
    Dashboard
@endpush

@push('meta')
    <title>{{ config('app.name', 'Laravel') }}</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
    <script src="{{ asset('/admin/js/jquery-ui.js') }}"></script>
    <script>
        $(document).ready(function() {

            $("#sort-home-category-news").sortable({
                stop: function(event, ui) {
                    var tbody = $('#sort-home-category-news');
                    var rows = tbody.find('tr');

                    var order_ids = $(this).sortable("toArray").sort(function(a, b) {
                        return b - a
                    });

                    for (var i = 0; i < rows.length; i++) {
                        $(rows[i]).find('.sort').val(order_ids[i]);
                    }
                }
            });
        });
    </script>
@endpush
