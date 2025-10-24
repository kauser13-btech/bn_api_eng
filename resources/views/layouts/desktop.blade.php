<!DOCTYPE html>
<html lang="bn" prefix="og: http://ogp.me/ns#">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name='viewport' content='width=device-width, initial-scale=1.0, shrink-to-fit=no' />

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
			asset('desktop/css/bootstrap.min.css'),
			asset('desktop/css/bootstrap-icons.css'),
			asset('desktop/css/owl.carousel.min.css'),
			asset('desktop/css/theme-style.css'),
		],'css');
		Assets::add([
			asset('desktop/js/jquery.min.js'),
		],'js','head-script');
		Assets::add([
			asset('desktop/js/bootstrap.bundle.min.js'),
			asset('desktop/js/owl.carousel.min.js'),
			asset('desktop/js/flickity.pkgd.js'),
			asset('desktop/js/jquery.date-dropdowns.js'),
			asset('desktop/js/lazyload.min.js'),
			asset('desktop/js/theme-script.js'),
		],'js','footer-script');
	@endphp

	{!! Assets::css() !!}
	@stack('stylesheet')
	{!! Assets::js('head-script') !!}

	<script type="text/javascript">$(function() { $("img.lazyload").lazyload({effect : "fadeIn"});});</script>

	<!--[if lte IE 8]>{!! Assets::js('ie8') !!}<![endif]-->

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
<div class="body-top-ad bg-dark">
	<div class="col-md-12">
		@yield('desktop-header-ad')
	</div>
</div>

<main>
	<header>
		<div class="bird1"></div>
		<div class="birdr1"></div>
		<div class="bird"></div>
		<div class="birdr"></div>
		
		<div class="container mb-0 pb-0">
			<div class="row">
				<div class="col-md-4 col-lg-4 pt-5 header-date"><span class="todayTime">Dhaka, {{ date('l, d F, Y') }}</span></div>
				<div class="col-md-4 col-lg-4 d-flex justify-content-center">
					<a href="{{ url('/') }}" class="logo"><img src="{{ asset('/desktop/img/logo.png') }}" alt="banglanews24"></a>
				</div>
				<div class="col-md-4 col-lg-4 text-end pt-4 header-archive-btn">
					<button type="button" data-bs-toggle="modal" data-bs-target="#archiveModel" class="btn btn-dark">Archive</button>
					<a href="http://www.edailysun.com/" target="_blank" class="btn btn-warning e-paper">e-paper</a>
				</div>
 				<div class="sun"></div>
			</div>
		</div>
	</header>

	<nav id="navbar_top" class="navbar navbar-expand-lg">
		<div class="container">
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav"  aria-expanded="false" aria-label="Toggle navigation">
				<span class="bi bi-list"></span>
			</button>
			<div class="collapse navbar-collapse float-start" id="main_nav">
				<ul class="navbar-nav">
					<li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
					<li class="nav-item"><a class="nav-link" href="{{ url('/online/today-all') }}">Today's News</a></li>
					{!! App\Helpers\generalHelper::desktopMenu() !!}

					<li class="nav-item dropdown">
						<a class="nav-link  dropdown-toggle" href="#" data-bs-toggle="dropdown"> Today's Newspaper </a>
						<ul class="dropdown-menu dropdown-menu-right">
							<li><a class="dropdown-item" href="{{ url('printversion/today-all') }}">Home</a></li>
							@foreach(App\Helpers\generalHelper::todaysNewspaperMenu() as $row)
								<li><a class="dropdown-item" href="{{ url('printversion/'.$row->slug) }}">{{ $row->m_name }}</a></li>
							@endforeach
						</ul>
					</li>

				</ul>
			</div>
			<ul class="head-social float-end ">
				<li><a href="{{ env('APP_BN_URL') }}">BN</a></li>
				<li><a href="#" id="search-btn"><i class="bi bi-search"></i></a></li>
				<li><a href=""><i class="bi bi-facebook"></i></a></li>
				<li><a href=""><i class="bi bi-rss"></i></a></li>
			</ul>
			<!-- Search Form -->
			<div id="search">
                <span class="close">X</span>
				<form action="./search" id="searchform" method="get" id="cse-search-box">
				    <input type="hidden" value="008012374219124743477:q0kdopxxxlu" name="cx">
				    <input type="hidden" name="cof" value="FORID:10" />
				    <input type="hidden" value="UTF-8" name="ie">
				    <input name="q" type="search" placeholder="Search.....">
				    <button type="submit"  onclick="document.getElementById('form-id').submit();"><i class="bi bi-search"></i></button>
				</form>
            </div>
		</div>
	</nav>


	@hasSection('content')
		@yield('content')
	@endif


	<footer class="mt-3 pt-3 pb-5">
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-12 col-sm-6 col-md-2 col-lg-2">
						<img src="{{ url('desktop/img/footer-logo.png') }}" alt="">
					</div>
					<div class="col-12 col-sm-6 col-md-7 col-lg-7 col-xl-8">
						<p>Editor : Enamul Hoque Chowdhury</p>
					</div>
					<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 text-end">
						<button type="button" data-bs-toggle="modal" data-bs-target="#archiveModel" class="btn btn-dark">Archive</button>
						<a href="" class="btn btn-warning e-paper">E-paper</a>
					</div>
				</div>
			</div>
		</div>

		<div class="container footer-bottom">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-4 col-lg-5 pe-0">
					<p>Published by Maynal Hossain Chowdhury on behalf of Bashundhara Multi Trading Limited, 371/A, Block No: D, Bashundhara R/A, Baridhara, Dhaka -1229 and Printed at East West Media Group Limited, Plot No: C/52, Block-K, Bashundhara, Khilkhet, Badda, Dhaka-1229.</p>
					<p class="Copyright">© {{ date('Y') }} banglanews24</p>
				</div>
				<div class="col-12 col-sm-12 col-md-3 col-lg-2 text-center">
					<a href="" target="_blank" class="app-icon mb-2"><img src="img/android.png" alt=""></a>
					<a href="" target="_blank" class="app-icon"><img src="img/Ios-app.png" alt=""></a>
				</div>
				<div class="col-12 col-sm-12 col-md-5 col-lg-5">
					<p class="text-end">PABX- 09612120000, 8432361-3 FAX-88-02-8432094<br>
					Advertisement Phone: 8432046<br>
					Advertisement FAX: 8432045<br>
					E-mail: Editor: editor@daily-sun.com, <br>
					Advertisement: advertisement@daily-sun.com,</p>
					<div class="clearfix"></div>
					<div class="social-info">
						<ul class="mt-2">
							<li><a href=""><i class="bi bi-youtube"></i></a></li>
							<li><a href=""><i class="bi bi-linkedin"></i></a></li>
							<li><a href=""><i class="bi bi-instagram"></i></a></li>
							<li><a href=""><i class="bi bi-twitter"></i></a></li>
							<li><a href=""><i class="bi bi-facebook"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</footer>
</main>

@if(!$ticker->isEmpty())
<div class="news-ticker">
	<div class="container">
		<div class="title-bg">
			<img src="{{ asset('/desktop/img/breaking-news.gif') }}" alt="breaking news">
		</div>
		<div class="owl-carousel owl-theme">
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
				<div class="item bi bi-record-fill"><a href="{{ $ticker_url }}"><h4>{{ $row->n_head }}</h4></a></div>
			@endforeach
		</div>
	</div>
	<style type="text/css">.bottom-sticky-ad{bottom: 45px;}</style>
</div>
@endif

{{-- @if(!$breakingNews->isEmpty())
@foreach($breakingNews as $row)
{{ $row->text }}
@endforeach
@endif --}}

<a href="#" id="back-to-top" title="Back to top"><i class="bi bi-chevron-up"></i></a>


<!-- Modal -->
<div class="modal fade" id="archiveModel" tabindex="-1" aria-labelledby="archiveModelLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="archiveModelLabel">Print Archive</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="archiveArea"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="btnArchive">Search</button>
			</div>
		</div>
	</div>
</div>

<!-- Js -->
{!! Assets::js('footer-script') !!}


@stack('scripts')
</body>
</html>
