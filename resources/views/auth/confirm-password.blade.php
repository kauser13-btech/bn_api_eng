@extends('layouts.app')

@section('content')

    <div class="col-md-6 m-auto">
        <div class="row">
            <div class="card">
                <div class="card-header card-header-rose card-header-text">
                    <div class="card-icon">
                        <i class="material-icons">lock</i>
                    </div>
                    <h4 class="card-title">Enable Two-Factor Confirm Password</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div>
                            <div>{{ __('Whoops! Something went wrong.') }}</div>

                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row">
                            <label class="col-sm-2 col-form-label">{{ __('Password') }}</label>
                            <div class="col-sm-10">
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" required autocomplete="current-password" />
                                </div>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-warning">
                                {{ __('Confirm Password') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
