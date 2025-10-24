<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('meta')
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{ asset('/admin/css/material-dashboard.css?v=0.0.8') }}" rel="stylesheet" />
    <link href="{{ asset('/admin/css/select2.min.css') }}" rel="stylesheet" />
    @stack('stylesheet')
</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="rose" data-background-color="black"
            data-image="{{ asset('/admin/img/sidebar-1.jpg') }}">
            <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

    Tip 2: you can also add an image using data-image tag
  -->
            <div class="logo"><span class="simple-text logo-normal text-center">
                    <img class="w-75 d-block m-auto mb-2" src="{{ asset('/admin/img/logo.png') }}" alt="logo">
                    Admin Panel
                </span></div>
            <div class="sidebar-wrapper">
                <div class="user">
                    <div class="photo">
                        @if (Auth::user()->img)
                            <img src="{{ \App\Helpers\ImageStoreHelpers::showImage('profile', Auth::user()->created_at, Auth::user()->img) }}"
                                alt="Ad Image">
                        @else
                            <img src="{{ asset('/admin/img/default-avatar.png') }}" />
                        @endif
                    </div>
                    <div class="user-info">
                        <a data-toggle="collapse" href="#collapseExample" class="username">
                            <span> {{ Auth::user()->name }} <b class="caret"></b></span>
                        </a>
                        <div class="collapse" id="collapseExample">
                            <ul class="nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('admin/profile') }}">
                                        <span class="sidebar-mini"> EP </span>
                                        <span class="sidebar-normal"> Edit Profile </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <span class="sidebar-mini"> LO </span>
                                        <span class="sidebar-normal"> {{ __('Logout') }} </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <ul class="nav">
                    <li class="nav-item @if (Request::segment(2) == 'dashboard') active @endif">
                        <a class="nav-link" href="{{ url('admin/dashboard') }}">
                            <i class="material-icons">dashboard</i>
                            <p> Dashboard </p>
                        </a>
                    </li>

                    <li class="nav-item @if (Request::segment(2) == 'menu') active @endif">
                        <a class="nav-link" data-toggle="collapse" href="#pagesMenu"
                            @if (Request::segment(2) == 'menu') aria-expanded="true" @endif>
                            <i class="material-icons">view_headline</i>
                            <p> Menu <b class="caret"></b></p>
                        </a>
                        <div class="collapse @if (Request::segment(2) == 'menu') show @endif" id="pagesMenu">
                            <ul class="nav">
                                <li class="nav-item @if (Request::segment(2) == 'menu' && Request::segment(3) == '') active @endif">
                                    <a class="nav-link" href="{{ url('admin/menu') }}">
                                        <span class="sidebar-mini"> L </span>
                                        <span class="sidebar-normal"> List </span>
                                    </a>
                                </li>
                                <li class="nav-item  @if (Request::segment(2) == 'menu' && Request::segment(3) == 'create') active @endif">
                                    <a class="nav-link" href="{{ url('admin/menu/create') }}">
                                        <span class="sidebar-mini"> AN </span>
                                        <span class="sidebar-normal"> Add New </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    @switch(Auth::user()->type)
                        @case('all')
                            @if (Auth::user()->role == 'developer')
                                @include('admin.inc.MenuDevs')
                            @endif

                            <li class="nav-item btn-info" style="margin-top: 15px;">
                                <span class="nav-link">
                                    <i class="material-icons">timeline</i>
                                    <p> Online Section </p>
                                </span>
                            </li>

                        @case('online')
                            @include('admin.inc.MenuOnline')
                        @break

                        @default
                    @endswitch

                    <li class="nav-item mb-5 @if (Request::segment(2) == 'writers') active @endif">
                        <a class="nav-link" href="{{ url('admin/writers') }}">
                            <i class="material-icons">edit_calendar</i>
                            <p> Writers </p>
                        </a>
                    </li>

                    {{-- <li class="nav-item">
						<a class="nav-link" data-toggle="collapse" href="#pagesExamples">
							<i class="material-icons">image</i>
							<p> Menu <b class="caret"></b></p>
						</a>
						<div class="collapse" id="pagesExamples">
							<ul class="nav">
								<li class="nav-item ">
									<a class="nav-link" href="../examples/pages/pricing.html">
										<span class="sidebar-mini"> P </span>
										<span class="sidebar-normal"> Pricing </span>
									</a>
								</li>
							</ul>
						</div>
					</li> --}}

                    {{-- <li class="nav-item ">
						<a class="nav-link" href="../examples/charts.html">
							<i class="material-icons">timeline</i>
							<p> Charts </p>
						</a>
					</li> --}}

                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-minimize">
                            <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                                <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                                <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
                            </button>
                        </div>
                        <a class="navbar-brand" href="javascript:;">Dashboard</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                        <span class="navbar-toggler-icon icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="javascript:;" id="navbarDropdownProfile"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">person</i>
                                    <p class="d-lg-none d-md-block">
                                        Account
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right"
                                    aria-labelledby="navbarDropdownProfile">
                                    <a class="dropdown-item" href="{{ url('admin/profile') }}">Profile</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="content">
                <div class="content">
                    <div class="container-fluid">

                        @if (Auth::user()->type != 'online' && date('m-d') == '12-31')
                            <div class="alert alert-danger" role="alert">
                                অনুগ্রহ করে ০১ তারিক এর সব নিউজ রাত ১২ টার পর আপলোড করুন। ধন্যবাদ
                            </div>
                        @endif

                        @hasSection('content')
                            @yield('content')
                        @endif
                        <footer class="text-center">
                            Developed By Application Team, ABG Bashundhara
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('/admin/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('/admin/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('/admin/js/core/bootstrap-material-design.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <!-- Plugin for the momentJs  -->

    <script src="{{ asset('/admin/js/plugins/moment.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/sweetalert2.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/jquery.bootstrap-wizard.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/bootstrap-selectpicker.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/jasny-bootstrap.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/jquery-jvectormap.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/nouislider.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/arrive.min.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/bootstrap-notify.js') }}"></script>
    <script src="{{ asset('/admin/js/plugins/select2.min.js') }}"></script>
    @stack('scripts')
    <script src="{{ asset('/admin/js/material-dashboard.js?v=0.0.2') }}" type="text/javascript"></script>
</body>

</html>
