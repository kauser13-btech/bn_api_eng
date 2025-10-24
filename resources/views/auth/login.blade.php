<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{ asset('/admin/css/material-dashboard.css') }}" rel="stylesheet" />
</head>

<body class="off-canvas-sidebar">
    <div class="wrapper wrapper-full-page">
        <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('{{ asset('/admin/img/login.jpg')}}'); background-size: cover; background-position: top center;">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="card card-login card-hidden">
                                <div class="card-header card-header-rose text-center" style="background:#ff9800">
                                    <h4 class="card-title"><img  class="w-75 d-block m-auto" src="{{asset('/admin/img/logo.png')}}" alt="logo"></h4>
                                </div>
                                <div class="card-body ">
                                    <div class="card-description text-center">
                                        @if (session('status'))
                                            <div>
                                                {{ session('status') }}
                                            </div>
                                        @endif

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
                                    </div>
                                    <span class="bmd-form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="material-icons">email</i>
                                                </span>
                                            </div>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('E-Mail Address') }}">
                                        </div>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </span>
                                    <span class="bmd-form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="material-icons">lock_outline</i>
                                                </span>
                                            </div>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('E-Password...') }}">
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </span>
                                    <span class="bmd-form-group" style="margin: 15px 0 0 7px;display: inline-block;">
                                        <div class="input-group">
                                            <input class="form-control pull-left" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="flex: unset;width: 20px;margin-top: 0;margin-left: 10px;">
                                            <label class="pull-left" for="remember" style="margin: 10px 0 0 10px;">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </span>
                                </div>

                                <div class="card-footer justify-content-center">
                                    <button type="submit" class="btn btn-rose btn-link btn-lg">{{ __('Login') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('/admin/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('/admin/js/material-dashboard.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            md.checkFullPageBackgroundImage();
            setTimeout(function() {
                // after 1000 ms we add the class animated to the login/register card
                $('.card').removeClass('card-hidden');
            }, 700);
        });
    </script>
</body>

</html>