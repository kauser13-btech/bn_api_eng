@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <div class="row">
            <div class="card">
                <div class="card-header card-header-rose card-header-text">
                    <div class="card-icon">
                        <i class="material-icons">search</i>
                    </div>
                    <h4 class="card-title">Monthly News Report</h4>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ url('admin/report/monthly-news-report') }}" method="GET">
                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <div class="input-group date">
                                                    <input name="startDate" type="text" class="form-control" id="datetimepicker6" value="{{ $startDate }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">To</div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <div class="input-group date">
                                                    <input name="endDate" type="text" class="form-control" id="datetimepicker7"value="{{ $endDate }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-1 pull-right">
                                    <button id="myBtn" type="submit" class="btn btn-rose">Search</button>
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
                                    <th scope="col">Name</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Posts</th>
                                    <th scope="col">Updated Posts</th>
                                    <th scope="col">Total Read</th>
                                    <th scope="col">AVG Read</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalonlineNews = 0;
                                    $totalonlineNewsUpdate = 0;
                                    $totalPrintNews = 0;
                                @endphp

                                @foreach ($user as $row)
                                    @php
                                        if ($row->type == 'online' || $row->type == 'all') {
                                            $totalonlineNews += $row->total_posts_count;
                                            $totalonlineNewsUpdate += $row->total_update_count;
                                        } elseif ($row->type == 'print' || $row->type == 'all') {
                                            $totalPrintNews += $row->total_posts_count;
                                        }
                                    @endphp
                                    <tr>
                                        <th scope="row">{{ $row->name }} / {{ $row->designation }}</th>
                                        <td>{{ $row->type != 'all' ? $row->type : 'Developer' }}</td>
                                        <td>{{ $row->total_posts_count }}</td>
                                        <td>{{ $row->total_update_count }}</td>
                                        <td>{{ number_format($row->total_read_sum_most_read) }}</td>
                                        <td>
                                            @php
                                                if (
                                                    $row->total_read_sum_most_read != 0 &&
                                                    $row->total_posts_count != 0
                                                ) {
                                                    echo number_format(
                                                        $row->total_read_sum_most_read / $row->total_posts_count,
                                                    );
                                                }
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="card-footer">
                    Total Online News: {{ $totalonlineNews }},
                    Total Online News Update: {{ $totalonlineNewsUpdate }},
                    Total Print News: {{ $totalPrintNews }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumbs')
    Report
@endpush

@push('meta')
    <title>Kaler Kantho Online Monthly Report</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.datatables-buttons').DataTable({
                dom: 'Bfrtip',
                order: [
                    [5, 'desc']
                ],
                "lengthMenu": [
                    [30, 50, 100, -1],
                    [30, 50, 100, "All"]
                ],
                buttons: [
                    ['copy', 'csv', 'excel'],
                    {
                        extend: 'print',
                        messageTop: function() {
                            return '{{ $startDate }} TO {{ $endDate }}';
                        },
                        messageBottom: null
                    }
                ]
            });
        });

        $(function() {
            $('#datetimepicker6').datetimepicker({
                format: 'YYYY-MM-DD',
                useCurrent: true
            });
            $('#datetimepicker7').datetimepicker({
                format: 'YYYY-MM-DD',
            });
            $("#datetimepicker6").on("dp.change", function(e) {
                $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
            });
            $("#datetimepicker7").on("dp.change", function(e) {
                $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
            });



            $('#myBtn').click(function() {
                var date1, date2, time_difference, days_difference;

                date1 = new Date($('#datetimepicker6').val());
                date2 = new Date($('#datetimepicker7').val());

                time_difference = date2.getTime() - date1.getTime();
                days_difference = time_difference / (1000 * 60 * 60 * 24);
	
                if (days_difference > 32) {
                    $('#datetimepicker6').val('');
                    $('#datetimepicker7').val('');
					alert('Date Range limit Maximum 1 month')
                    return false;
                }
				if (days_difference < 2) {
                    $('#datetimepicker6').val('');
                    $('#datetimepicker7').val('');
					alert('Date Range limit minimum 3 Day')
                    return false;
                }
            });

        });
    </script>
@endpush
