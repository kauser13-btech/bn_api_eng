@extends('layouts.app')

@section('content')

    <form class="form-horizontal" action="{{ route('miscellaneous.update') }}" method="POST" enctype="multipart/form-data">
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
                    <h4 class="card-title">Manage Watermark Ad</h4>
                </div>
                <div class="card-body">
                    @php $activeWAd = str_replace('"', "", $activeAd->arr_data) @endphp
                    @if ($watermark_ads)
                        @foreach ($watermark_ads as $wtrow)
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="arr_data"
                                        value="{{ $wtrow->id }}" @if($wtrow->id==$activeWAd) checked @endif> {{ $wtrow->name }}
                                    <span class="circle">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        @endforeach
                    @endif
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="arr_data" value="0" @if(0==$activeWAd) checked @endif>
                            No Ad
                            <span class="circle">
                                <span class="check"></span>
                            </span>
                        </label>
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
@endpush
