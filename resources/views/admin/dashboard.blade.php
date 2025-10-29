@extends('layouts.app')

@section('content')

    @if (!auth()->user()->two_factor_secret || session('status') == 'two-factor-authentication-enabled')
        @include('profile.two-factor-authentication-form')
    @endif

    @if (auth()->user()->two_factor_secret)

        {{-- <form method="POST" action="{{ url('ewmgl/user/two-factor-authentication') }}">
            @csrf
            @method('DELETE')

            <button type="submit">
                {{ __('Disable Two-Factor') }}
            </button>
        </form> --}}

        <div class="col-md-12">
            <div class="row">
                <div class="card">
                    <div class="card-header card-header-rose card-header-text">
                        <div class="card-icon">
                            <i class="material-icons">search</i>
                        </div>
                        <h4 class="card-title">Search</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ url('admin/dashboard') }}" method="GET">
                            <div class="col-md-12">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleNewsTitle1" class="bmd-label-floating"> News Headline</label>
                                            <input type="text" class="form-control" name="n_head" id="exampleNewsTitle1"
                                                value="{{ Request::get('n_head') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="exampleNewsTitle2" class="bmd-label-floating"> News Id</label>
                                            <input type="text" class="form-control" id="exampleNewsTitle2" name="n_id"
                                                value="{{ Request::get('n_id') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select class="selectpicker" data-size="7" data-style="select-with-transition"
                                                name="n_status">
                                                <option @if (Request::get('n_status') == 3) selected @endif value="3">
                                                    Publish</option>
                                                <option @if (Request::get('n_status') == 2) selected @endif value="2">
                                                    Save</option>
                                                <option @if (Request::get('n_status') == 1) selected @endif value="1">
                                                    Draft</option>
                                                <option @if (Request::get('n_status') == '0') selected @endif value="0">
                                                    Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select class="_select2 form-control" title="Post By" name="user_id">
                                                <option value="" selected>Select User</option>
                                                @foreach ($user as $urow)
                                                    <option @if (Request::get('user_id') == $urow->id) selected @endif
                                                        value="{{ $urow->id }}">{{ $urow->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="bmd-label-floating"> Date</label>
                                            <input type="text" class="form-control datepicker"
                                                value="{{ Request::get('n_date') }}" name="n_date">
                                        </div>
                                    </div>

                                    <div class="col-md-1 pull-right">
                                        <div class="row">
                                            <button style="width: 100%;" type="submit" class="btn btn-rose">Search</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">assignment</i>
                        </div>
                        <h4 class="card-title">News List</h4>
                    </div>
                    <div class="card-body">
                        <div class="toolbar">{{ $newsdate }}</div>
                        <div class="material-datatables">
                            <table class="table table-striped table-no-bordered table-hover datatables" cellspacing="0"
                                width="100%" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sl. No</th>
                                        <th>Edition</th>
                                        <th>Category</th>
                                        <th>News Headline</th>
                                        <th>Editing By</th>
                                        <th>Status</th>
                                        <th>Reach</th>
                                        <th>Post By / Post Time</th>
                                        <th>Edit By / Edit Time</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Sl. No</th>
                                        <th>Edition</th>
                                        <th>Category</th>
                                        <th>News Headline</th>
                                        <th>Editing By</th>
                                        <th>Status</th>
                                        <th>Reach</th>
                                        <th>Post By / Post Time</th>
                                        <th>Edit By / Edit Time</th>
                                        <th class="disabled-sorting text-right">Actions</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if ($news)
                                        @foreach ($news as $row)
                                            <tr>
                                                <td class="text-info">{{ $loop->index }}</td>
                                                <td class="text-info">{{ $row->edition }}</td>
                                                <td class="text-info">{{ $row->catName->m_name }}</td>
                                                <td><a href="{{ url('admin/news/' . $row->n_id . '/edit?edition=' . $row->edition) }}"
                                                        class="text-primary">{{ $row->n_head }}</a></td>
                                                <td class="text-info">
                                                    @if ($row->onediting != 0)
                                                        @if (Auth::user()->role == 'developer' || Auth::user()->role == 'editor')
                                                            <a href="{{ url('admin/news/' . $row->n_id . '/release') }}"
                                                                class="btn btn-warning btn-sm"
                                                                onclick="return confirm('Are you sure you want to release this news?');">{{ $row->editingBy->name }}</a>
                                                        @else
                                                            <p class="btn btn-warning btn-sm">{{ $row->editingBy->name }}
                                                            </p>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($row->n_status == 3)
                                                        <span class="badge badge-pill badge-primary">Publish</span>
                                                    @elseif($row->n_status == 2)
                                                        <span class="badge badge-pill badge-info">Save</span>
                                                    @elseif($row->n_status == 1)
                                                        <span class="badge badge-pill badge-warning">Draft</span>
                                                    @elseif($row->n_status == 0)
                                                        <span class="badge badge-pill badge-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-danger">{{ $row->most_read }}</td>
                                                <td class="text-danger">{{ $row->createdBy->name }} <br><span
                                                        class="text-warning"> {{ $row->start_at }}</span></td>
                                                <td class="text-danger">{{ $row->updatedBy->name }} <br><span
                                                        class="text-warning"> {{ $row->edit_at }}</span></td>
                                                <td class="text-right">
                                                    <a target="_blank"
                                                        href="{{ url('admin/newsCard/' . $row->n_id . '/0/0/0') }}"
                                                        class="btn btn-link btn-warning btn-just-icon edit"><i
                                                            class="fa fa-id-card-o" aria-hidden="true"></i></a>

                                                    @php
                                                        if ($row->catName->m_edition == 'online') {
                                                            $m_edition = 'online';
                                                        } elseif ($row->catName->m_edition == 'multimedia') {
                                                            $m_edition = 'multimedia';
                                                        } elseif ($row->catName->m_edition == 'print') {
                                                            $m_edition = 'print-edition';
                                                        } else {
                                                            $m_edition = 'feature';
                                                        }
                                                    @endphp
                                                    @if ($row->n_status == 3)
                                                        <a href="https://en.banglanews24.com/{{ $row->catName->slug }}/news/bd/{{ $row->n_id }}.details"
                                                            class="btn btn-link btn-warning btn-just-icon edit"
                                                            target="_blank"><i class="material-icons">link</i></a>
                                                    @endif

                                                    <a href="{{ url('admin/news/' . $row->n_id . '/edit?edition=' . $row->edition) }}"
                                                        class="btn btn-link btn-warning btn-just-icon edit"><i
                                                            class="material-icons">edit_note</i></a>
                                                    <form class="pull-right" method="POST"
                                                        action="{{ route('news.destroy', $row->n_id) }}">
                                                        @csrf @method('DELETE')
                                                        <input type="hidden" name="edition"
                                                            value="{{ $row->edition }}">
                                                        <button type="submit"
                                                            class="btn btn-link btn-danger btn-just-icon remove"
                                                            onclick="return confirm('Are you sure you want to delete this item?');"><i
                                                                class="material-icons">close</i></button>
                                                    </form>

                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $news->appends(['n_head' => Request::get('n_head'), 'n_id' => Request::get('n_id'), 'n_status' => Request::get('n_status'), 'user_id' => Request::get('user_id'), 'n_date' => Request::get('n_date')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endif


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
    @if (session('status') == 'two-factor-authentication-enabled')
        <script>
            setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: "{{ route('logout') }}",
                    data: {
                        '_token': "{{ csrf_token() }}"
                    }
                });
            }, 100)
        </script>
    @endif
@endpush
