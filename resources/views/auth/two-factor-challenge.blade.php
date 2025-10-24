<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{ asset('/admin/css/material-dashboard.css') }}" rel="stylesheet" />
</head>

<body class="off-canvas-sidebar">
    <div class="wrapper wrapper-full-page">
        <div class="page-header login-page header-filter" filter-color="black"
            style="background-image: url('{{ asset('/admin/img/login.jpg') }}'); background-size: cover; background-position: top center;">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-8 ml-auto mr-auto">
                        <form method="POST" action="{{ url('/ewmgl/two-factor-challenge') }}">
                            @csrf
                            <div class="card card-login card-hidden">
                                <div class="card-header card-header-rose text-center" style="background:#ff9800">
                                    <h4 class="card-title"><img class="w-75 d-block m-auto"
                                            src="{{ asset('/admin/img/logo.png') }}" alt="logo"></h4>
                                </div>
                                <div class="card-body">

                                    <div class="mb-4 text-center">
                                        {{ __('Authentication code provided by your authenticator application.') }}
                                    </div>

                                    <div class="row">
                                        <label for="staticEmail"
                                            class="col-sm-2 col-form-label">{{ __('Code') }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="code" autofocus
                                                autocomplete="one-time-code" />
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-4 border-top text-center text-danger">
                                        {{ __('One of your emergency recovery codes.') }}
                                    </div>

                                    <div class="row">
                                        <label for="staticEmail"
                                            class="col-sm-3 col-form-label text-danger">{{ __('Recovery Code') }}</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="recovery_code"
                                                autocomplete="one-time-code" />
                                        </div>
                                    </div>

                                </div>

                                <div class="card-footer justify-content-center border-top mt-3">
                                    <button type="submit"
                                        class="btn btn-rose btn-link btn-lg">{{ __('Confirm') }}</button>
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
