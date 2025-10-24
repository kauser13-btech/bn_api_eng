@extends('layouts.app')

@section('content')


<div class="alert alert-rose alert-with-icon" data-notify="container">
	<i class="material-icons" data-notify="icon">notifications</i>
	<h1 class="title text-center">Permission Denied</h1>
</div>

@endsection

@push('breadcrumbs') 403 @endpush

@push('meta')
	<title>403</title>
@endpush

@push('stylesheet')
@endpush

@push('scripts')
@endpush