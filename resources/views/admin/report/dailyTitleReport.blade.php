@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="row">
            <div class="card">
                <div class="card-header card-header-rose card-header-text">
                    <div class="card-icon">
                        <i class="material-icons">search</i>
                    </div>
                    <h4 class="card-title">News Report</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ url('admin/report/daily-title-report') }}" method="GET">
                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control datepicker sdate"
                                            value="{{ $sdate }}" name="sdate">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control datepicker edate"
                                            value="{{ $edate }}" name="edate">
                                    </div>
                                </div>

                                <div class="col-md-1 pull-right">
                                    <button type="submit" class="btn btn-rose submitBTN">Search</button>
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
                    <h4 class="card-title">User List</h4>
                </div>
                <div class="card-body">
                    <div class="material-datatables">
                        <table class="table table-striped table-no-bordered table-hover datatables-buttons" cellspacing="0"
                            width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>Title</th>
                                    <th>Link</th>
                                    <th>Category</th>
                                    <th>Post By</th>
                                    <th>Post Time</th>
                                    <th>Total Read</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($news as $row)
                                    <tr>
                                        <td>{{ $loop->index }}</td>
                                        <td>{{ $row->n_head }}</td>
                                        <td>{{ 'https://en.banglanews24.com/online/' . $row->catName->slug . '/' . date('Y/m/d', strtotime($row->start_at)) . '/' . $row->n_id }}
                                        </td>
                                        <td>{{ $row->catName->m_name }}</td>
                                        <td>{{ $row->createdBy->name }}</td>
                                        <td>{{ $row->start_at }}</td>
                                        <td>{{ $row->most_read }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumbs')
    Report
@endpush

@push('meta')
    <title>Kaler Kantho Online news Report - {{ $sdate }} - {{ $edate }}</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.datatables-buttons').DataTable({
                dom: 'Bfrtip',

                "lengthMenu": [
                    [30, 50, 100, -1],
                    [30, 50, 100, "All"]
                ],
                buttons: [
                    'copy',
                    {
                        extend: 'print',
                        messageTop: function() {
                            return ' From {{ $sdate }} to {{ $edate }}';
                        },
                        messageBottom: null,
                        customize: function(doc) {
                            $(doc.document.body).find('h1').css('font-size', '28px');
                            $(doc.document.body).find('h1').css('text-align', 'center');
                        }
                    }
                ]
            });

            $(".submitBTN").click(function() {
                const sdate = $('.sdate').val();
                const edate = $('.edate').val();
                const date1 = new Date(sdate);
                const date2 = new Date(edate);
                const diffTime = Math.abs(date2 - date1);
                const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

                if (diffDays > 62) {
                    alert('৬০ দিনের কম সময়ের জন্য নির্বাচন করুন !')
                    return false;
                }
            });



        });
    </script>
@endpush
