@extends('layouts.desktop')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h1>দুঃখিত!</h1>
                <h2>আপনি যা খুঁজছেন, তা পাওয়া যায়নি</h2>
                <div class="error-details">আপনি ভুলভাবে খুঁজছেন। দয়া করে, বিষয়টি সম্পর্কে নিশ্চিত হয়ে নিন।</div>

                <div class="error-actions">
                    <a href="{{ url('/') }}" class="btn btn-primary btn-lg">প্রচ্ছদে ফিরে যান</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('meta')
    <title>দুঃখিত! আপনার কাঙ্খিত তথ্যটি খুঁজে পাওয়া যায়নি !</title>
@endpush

@push('stylesheet')
<style type="text/css">
.error-template {padding: 40px 15px;text-align: center;}
.error-actions {margin-top:15px;margin-bottom:15px;}
</style>
@endpush

@push('scripts')
@endpush
