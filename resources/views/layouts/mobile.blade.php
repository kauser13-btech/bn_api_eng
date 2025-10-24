<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-63593458-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-63593458-1');
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-L5MPVW2TER"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-L5MPVW2TER');
    </script>

    <!-- Start Alexa Certify Javascript -->
    <script type="text/javascript">
        _atrk_opts = { atrk_acct:"nLZmn1a4KM104B", domain:"daily-sun.com",dynamic: true};
        (function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://certify-js.alexametrics.com/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
    </script>
    <noscript><img src="https://certify.alexametrics.com/atrk.gif?account=nLZmn1a4KM104B" style="display:none" height="1" width="1" alt="" /></noscript>

    <meta http-equiv="refresh" content="1000">
    <!-- favicon tags -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ url('favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ url('favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ url('favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ url('favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ url('favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ url('favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url('favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ url('favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ url('favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- base -->
    <base href="{{ url('/') }}">

    <!-- Meta -->
    <meta name="language" content="en">
    <meta http-equiv="Content-Language" content="en">
    <meta name="coverage" content="Worldwide">
    <meta name="distribution" content="Global">
    <meta name="robots" content="all" >
    <meta name="googlebot" content="all">
    <meta name="googlebot-news" content="all">
    <meta name="Developer" content="Rabiul islam Rabin, Enayet Ullah">
    <meta name="Developed By" content="EWMGL Online Team">

    <meta name="author" content="daily-sun">
    <meta name="identifier-URL" content="https://www.daily-sun.com/">

    <!-- open graph tags -->
    <meta property="og:site_name" content="daily-sun.com">
    <meta property="og:type" content="article" />

    <!-- verification -->
    {{-- <meta property="fb:app_id" content=""> --}}
    <meta property="fb:pages" content="267469593263369">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @stack('meta')

    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "url": "https://www.daily-sun.com",
            "logo": "{{ url('desktop/img/logo.png') }}",
            "contactPoint" : [
                {
                    "@type" : "ContactPoint",
                    "telephone" : "+88-02-8432046",
                    "email" : "reporting@daily-sun.com",
                    "contactType" : "customer service"
                }
            ],
            "sameAs" : [
                "https://www.facebook.com/dailysun.newspaper",
                "https://twitter.com/dailysunbd",
                "https://play.google.com/store/apps/details?id=com.dailysun.app",
                "https://apps.apple.com/us/app/daily-sun/id1049592926",
                "https://www.daily-sun.com/sitemap.xml"
            ]
        }
    </script>
    @if(Request::is('/'))
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "url": "https://www.daily-sun.com/",
            "potentialAction": {
                "@type": "SearchAction",
                "target": "http://www.daily-sun.com/keywordsearch?cx=008012374219124743477:q0kdopxxxlu&cof=FORID%3A10&ie=UTF-8&q={search_term_string}",
                "query-input": "required name=search_term_string"
            }
        }
    </script>
    @endif

    <!-- CSS Files -->
    @php 
        Assets::add([
            asset('mobile/css/bootstrap.min.css'),
            asset('mobile/css/bootstrap-icons.css'),
            asset('mobile/css/owl.carousel.min.css'),
            asset('mobile/css/ticker.css'),
            asset('mobile/css/theme-style.css'),
        ],'css');

        Assets::add([
            asset('mobile/js/jquery.min.js'),
            asset('mobile/js/lazyload.min.js'),
        ],'js','head-script');

        Assets::add([
            asset('mobile/js/bootstrap.bundle.min.js'),
            asset('mobile/js/owl.carousel.min.js'),
            asset('mobile/js/acmeticker.js'),
            asset('mobile/js/theme-script.js'),
        ],'js','footer-script');
    @endphp

    {!! Assets::css() !!}
    @stack('stylesheet')
    {!! Assets::js('head-script') !!}

    <script type="text/javascript">$(function() { $("img.lazyload").lazyload({effect : "fadeIn"});});</script>

    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
    <script>
        window.googletag = window.googletag || {cmd: []};
        googletag.cmd.push(function() {
            @stack('dfp')
            googletag.pubads().enableSingleRequest();
            googletag.pubads().collapseEmptyDivs();
            googletag.enableServices();
        });
    </script>
    
    @stack('head_code')

    <!--Feedify Script Start-->
    <script id="feedify_webscript">
        var feedify = feedify || {};
          window.feedify_options={fedify_url:"https://feedify.net/",pkey:"BJN7IZReFdpNNfjrIOZ9FlyirXcHNANKNS-MiojlwVVbyZXp4ZmzDDt-CD2yVqc9Btbgpe9Lhfc8QT3zE2Njz5s"};
            (function (window, document){
            function addScript( script_url ){
              var s = document.createElement('script');
              s.type = 'text/javascript';
              s.src = script_url;
              document.getElementsByTagName('head')[0].appendChild(s);
            }
            addScript('https://tpcf.feedify.net/uploads/settings/7e5743526d2b8bb069a2acc80f6c6725.js?ts='+Math.random());
            addScript('https://cdn.feedify.net/getjs/feedbackembad-min-5.0.js');
        })(window, document);
    </script>
</head>

<body>
    <header class="fixed-top">
        <div class="container my-2 d-flex justify-content-between align-items-center">
            <a href="{{ url('/') }}"><img src="{{ url('mobile/images/ds-logo.png') }}" alt=""></a>

            <b class="screen-overlay"></b>
            <a class="text-secondary" href="{{ env('APP_BN_URL') }}">BN</a>
            <a href="#" data-trigger="#navbar_main" class="navbar-toggler-btn"><i class="bi bi-list"></i></a>
            <nav id="navbar_main" class="mobile-offcanvas navbar fixed-top navbar-expand-lg navbar-light">
                <div class="container nav-cont">
                    <a class="navbar-brand d-none d-lg-block" href="#"><a href=""><img src="{{ url('mobile/images/ds-logo.png') }}" alt=""></a></a>
                    <div class="offcanvas-header">
                        <button class="navbar-toggler btn-close"></button>
                    </div>
                    <hr>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link text-success" href="{{ url('/online/today-all') }}">Today's News</a></li>

                        {!! App\Helpers\generalHelper::desktopMenu() !!}

                        <li class="nav-item dropdown">
                            <a class="nav-link  dropdown-toggle text-info" href="#" data-toggle="dropdown">Today's Newspaper </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ url('printversion/today-all') }}">Home</a></li>
                                @foreach(App\Helpers\generalHelper::todaysNewspaperMenu() as $row)
                                    <li><a class="dropdown-item" href="{{ url('printversion/'.$row->slug) }}">{{ $row->m_name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="text-center my-4">
                    <a href="https://play.google.com/store/apps/details?id=com.dailysun.app" target="_blank" class="android me-1">
                        <img src="{{ url('mobile/images/android.png') }}" alt="android">
                    </a>
                    <a href="https://apps.apple.com/us/app/daily-sun/id1049592926" target="_blank" class="ios">
                        <img src="{{ url('mobile/images/Ios-app.png') }}" alt="Ios">
                    </a>
                </div>
            </nav>
        </div>

        @if(!$ticker->isEmpty())
        <div class="acme-news-ticker mt-0">
            <div class="acme-news-ticker-box">
                <ul class="my-news-ticker">
                    @foreach($ticker as $row)
                        @php
                            if($row->edition=='online'){
                                $ticker_url = url('post/'.$row->n_id);
                            }elseif($row->edition=='print'){
                                $ticker_url = url('printversion/details/'.$row->n_id);
                            }else{
                                $ticker_url = url('magazine/details/'.$row->n_id);
                            }
                        @endphp
                        <li class="bi bi-record-fill"><a href="{{ $ticker_url }}">{{ $row->n_head }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        
    </header>
    <div class="container-main">
        @hasSection('content')
            @yield('content')
        @endif
    </div>

    <footer class="py-4">
        <div class="container text-center">
            <img class="footer-logo" src="{{ url('mobile/images/footer-logo.png') }}" alt="banglanews24">
        </div>
        <div class="clearfix"></div>

        <span class="py-1 mt-3 text-center editor">Editor : Enamul Hoque Chowdhury</span>
        <ul class="my-3 menu footer-nav">
            <li><a href="./online/national">National</a></li>
            <li><a href="./online/politics">Politics</a></li>
            <li><a href="./online/economy">Economy</a></li>
            <li><a href="./online/world">World</a></li>
            <li><a href="./online/entertainment">Entertainment</a></li>
            <li><a href="./online/sports">Sports</a></li>
            <li><a href="./printversion">Today's Newspaper</a></li>
            <li><a href="./magazine">Magazine</a></li>
            <li><a href="http://www.edailysun.com/" target="_blank">E-paper</a></li>
            <li><a href="./contact">Contact Us</a></li>
            <li><a href="./terms-of-service">Terms Of Service</a></li>
            <li><a href="./privacy-policy">Privacy Policy</a></li>
        </ul>

        <div class="social-info mb-3">
            <ul class="my-2">
                <li><a href="https://www.facebook.com/dailysun.newspaper" target="_blank"><i class="bi bi-facebook"></i></a></li>
                <li><a href="https://twitter.com/dailysunbd" target="_blank"><i class="bi bi-twitter"></i></a></li>
                <li><a href="http://www.daily-sun.com/sitemap.xml" target="_blank"><i class="bi bi-rss"></i></a></li>
                <!-- <li><a href="" target="_blank"><i class="bi bi-instagram"></i></a></li>
                <li><a href="" target="_blank"><i class="bi bi-linkedin"></i></a></li>
                <li><a href="" target="_blank"><i class="bi bi-youtube"></i></a></li> -->
            </ul>
        </div>

        <div class="text-center app-icon-area">
            <a href="https://play.google.com/store/apps/details?id=com.dailysun.app" target="_blank" class="app-icon mb-2">
                <img src="{{ url('mobile/images/android.png') }}" alt="android">
            </a>
            <a href="https://apps.apple.com/us/app/daily-sun/id1049592926" target="_blank" class="app-icon">
                <img src="{{ url('mobile/images/Ios-app.png') }}" alt="Ios">
            </a>
        </div>
        <div class="clearfix"></div>
        <div class="copyright mt-4">
            <p class="text-center"><span>c</span> 2022 banglanews24</p>
        </div>
        <div class="clearfix"></div>
    </footer>

    <a href="#" id="back-to-top" title="Back to top" class="show"><i class="bi bi-chevron-up"></i></a>

    {!! Assets::js('footer-script') !!}

    @stack('scripts')
    
</body>
</html>