{{-- <li class="nav-item @if(Request::segment(3)=='electionResult') active @endif">
	<a class="nav-link" href="{{ url('admin/electionResult')}}">
		<span class="sidebar-mini"> ST </span>
		<span class="sidebar-normal">Election Result </span>
	</a>
</li> --}}

<li class="nav-item @if(Request::segment(2)=='special-sigment') active  @endif">
	<a class="nav-link" href="{{ url('admin/special-sigment')}}">
		<i class="material-icons">tag</i>
		<p> Special Sigment </p>
	</a>
</li>

<li class="nav-item @if(Request::segment(2)=='watermark-ad') active  @endif">
	<a class="nav-link" href="{{ url('admin/watermark-ad')}}">
		<i class="material-icons">tag</i>
		<p> Global Watermark Ad </p>
	</a>
</li>

<li class="nav-item @if(Request::segment(2)=='news' && (Request::segment(3)=='livenews' || Request::segment(3)=='livenewslist')) active @endif">
	<a class="nav-link" href="{{ url('admin/news/livenews')}}">
		<i class="material-icons">speaker_notes</i>
		<span class="sidebar-normal"> Live News </span>
	</a>
</li>

<li class="nav-item @if(Request::segment(2)=='news' && (Request::segment(3)=='sorting' || Request::segment(3)=='sortnews')) active @endif">
	<a class="nav-link" href="{{ url('admin/news/sorting?edition=online')}}">
		<i class="material-icons">list_alt</i>
		<span class="sidebar-normal"> Sort News </span>
	</a>
</li>


<li class="nav-item  @if(Request::segment(2)=='news' && Request::get('edition')=='online') active @endif">
	<a class="nav-link" data-toggle="collapse" href="#pagesOnlineNews" @if(Request::segment(2)=='news' && Request::get('edition')=='online') aria-expanded="true" @endif>
		<i class="material-icons">article</i>
		<p> News <b class="caret"></b></p>
	</a>
	<div class="collapse @if(Request::segment(2)=='news' && Request::get('edition')=='online') show @endif" id="pagesOnlineNews">
		<ul class="nav">
			<li class="nav-item @if(Request::segment(2)=='news' && Request::segment(3)=='') active @endif">
				<a class="nav-link" href="{{ url('admin/news?edition=online')}}">
					<span class="sidebar-mini"> NM </span>
					<span class="sidebar-normal"> News Manager </span>
				</a>
			</li>
			<li class="nav-item @if(Request::segment(2)=='news' && Request::segment(3)=='create') active @endif">
				<a class="nav-link" href="{{ url('admin/news/create?edition=online')}}">
					<span class="sidebar-mini"> ANP </span>
					<span class="sidebar-normal"> Add New Post </span>
				</a>
			</li>
			<li class="nav-item @if(Request::segment(2)=='news' && Request::segment(3)=='trash') active @endif">
				<a class="nav-link" href="{{ url('admin/news/trash?edition=online')}}">
					<span class="sidebar-mini"> T </span>
					<span class="sidebar-normal"> Trash </span>
				</a>
			</li>
		</ul>
	</div>
</li>

{{-- <li class="nav-item  @if(Request::segment(2)=='news' && Request::get('edition')=='multimedia') active @endif">
	<a class="nav-link" data-toggle="collapse" href="#pagesMultimediaNews" @if(Request::segment(2)=='news' && Request::get('edition')=='multimedia') aria-expanded="true" @endif>
		<i class="material-icons">article</i>
		<p> Multimedia <b class="caret"></b></p>
	</a>
	<div class="collapse @if(Request::segment(2)=='news' && Request::get('edition')=='multimedia') show @endif" id="pagesMultimediaNews">
		<ul class="nav">
			<li class="nav-item @if(Request::segment(2)=='news' && Request::segment(3)=='') active @endif">
				<a class="nav-link" href="{{ url('admin/news?edition=multimedia')}}">
					<span class="sidebar-mini"> NM </span>
					<span class="sidebar-normal"> News Manager </span>
				</a>
			</li>
			<li class="nav-item @if(Request::segment(2)=='news' && Request::segment(3)=='create') active @endif">
				<a class="nav-link" href="{{ url('admin/news/create?edition=multimedia')}}">
					<span class="sidebar-mini"> ANP </span>
					<span class="sidebar-normal"> Add New Post </span>
				</a>
			</li>
			<li class="nav-item @if(Request::segment(2)=='news' && Request::segment(3)=='trash') active @endif">
				<a class="nav-link" href="{{ url('admin/news/trash?edition=multimedia')}}">
					<span class="sidebar-mini"> T </span>
					<span class="sidebar-normal"> Trash </span>
				</a>
			</li>
		</ul>
	</div>
</li> --}}

<li class="nav-item @if(Request::segment(2)=='pool') active @endif">
	<a class="nav-link" data-toggle="collapse" href="#pagesPool">
		<i class="material-icons">speaker_notes</i>
		<p> Pool  <b class="caret"></b></p>
	</a>
	<div class="collapse @if(Request::segment(2)=='pool') show @endif" id="pagesPool">
		<ul class="nav">
			<li class="nav-item @if(Request::segment(2)=='pool' && Request::segment(3)=='') active @endif">
				<a class="nav-link" href="{{ url('admin/pool') }}">
					<span class="sidebar-mini"> L </span>
					<span class="sidebar-normal"> List </span>
				</a>
			</li>
			<li class="nav-item @if(Request::segment(2)=='pool' && Request::segment(3)=='create') active @endif">
				<a class="nav-link" href="{{ url('admin/pool/create') }}">
					<span class="sidebar-mini"> AN </span>
					<span class="sidebar-normal">  Add New  </span>
				</a>
			</li>
		</ul>
	</div>
</li>

<li class="nav-item @if(Request::segment(2)=='gallery') active @endif">
	<a class="nav-link" data-toggle="collapse" href="#pagesGallery">
		<i class="material-icons">filter_vintage</i>
		<p> Gallery <b class="caret"></b></p>
	</a>
	<div class="collapse @if(Request::segment(2)=='gallery') show @endif" id="pagesGallery">
		<ul class="nav">
			<li class="nav-item @if(Request::segment(2)=='gallery' && Request::segment(3)=='') active @endif">
				<a class="nav-link" href="{{ url('admin/gallery') }}">
					<span class="sidebar-mini"> L </span>
					<span class="sidebar-normal"> List </span>
				</a>
			</li>
			<li class="nav-item @if(Request::segment(2)=='gallery' && Request::segment(3)=='create') active @endif">
				<a class="nav-link" href="{{ url('admin/gallery/create') }}">
					<span class="sidebar-mini"> AN </span>
					<span class="sidebar-normal"> Add New  </span>
				</a>
			</li>
			<li class="nav-item @if(Request::segment(2)=='gallery' && Request::segment(4)=='video') active @endif">
				<a class="nav-link" href="{{ url('admin/gallery/sort/video') }}">
					<span class="sidebar-mini"> ST </span>
					<span class="sidebar-normal"> Video Sort </span>
				</a>
			</li>
			<li class="nav-item @if(Request::segment(2)=='gallery' && Request::segment(4)=='photo') active @endif">
				<a class="nav-link" href="{{ url('admin/gallery/sort/photo') }}">
					<span class="sidebar-mini"> ST </span>
					<span class="sidebar-normal"> Photo Sort </span>
				</a>
			</li>
			<li class="nav-item @if(Request::segment(2)=='gallery' && Request::segment(3)=='category') active @endif">
				<a class="nav-link" href="{{ url('admin/gallery/category') }}">
					<span class="sidebar-mini"> CM </span>
					<span class="sidebar-normal"> Category Manager </span>
				</a>
			</li>
		</ul>
	</div>
</li>

<li class="nav-item @if(Request::segment(2)=='breakingnews') active @endif">
	<a class="nav-link" data-toggle="collapse" href="#pagesBreakingNews">
		<i class="material-icons">list_alt</i>
		<p> Breaking News <b class="caret"></b></p>
	</a>
	<div class="collapse @if(Request::segment(2)=='breakingnews') show @endif" id="pagesBreakingNews">
		<ul class="nav">
			<li class="nav-item @if(Request::segment(2)=='breakingnews' && Request::segment(3)=='') active @endif">
				<a class="nav-link" href="{{ url('admin/breakingnews') }}">
					<span class="sidebar-mini"> L </span>
					<span class="sidebar-normal"> List </span>
				</a>
			</li>
			<li class="nav-item @if(Request::segment(2)=='breakingnews' && Request::segment(3)=='create') active @endif">
				<a class="nav-link" href="{{ url('admin/breakingnews/create') }}">
					<span class="sidebar-mini"> P </span>
					<span class="sidebar-normal"> Add New </span>
				</a>
			</li>
		</ul>
	</div>
</li>

@if(Auth::user()->role=='developer' || Auth::user()->role=='editor')
<li class="nav-item @if(Request::segment(2)=='report') active @endif">
	<a class="nav-link" data-toggle="collapse" href="#formsReport">
		<i class="material-icons">report_problem</i> <p> Report <b class="caret"></b> </p>
	</a>
	<div class="collapse @if(Request::segment(2)=='report') show @endif" id="formsReport">
		<ul class="nav">
			<li class="nav-item @if(Request::segment(3)=='daily-title-report') active @endif">
				<a class="nav-link" href="{{ url('admin/report/daily-title-report/?rdate='.date('Y-m-d')) }}">
					<span class="sidebar-mini"> EF </span>
					<span class="sidebar-normal"> Daily News Headline </span>
				</a>
			</li>
			<li class="nav-item @if(Request::segment(3)=='daily-news-report') active @endif">
				<a class="nav-link" href="{{ url('admin/report/daily-news-report/?range=0&&rdate='.date('Y-m-d')) }}">
					<span class="sidebar-mini"> EF </span>
					<span class="sidebar-normal"> Daily News </span>
				</a>
			</li>
			<li class="nav-item @if(Request::segment(3)=='monthly-news-report') active @endif">
				<a class="nav-link" href="{{ url('admin/report/monthly-news-report') }}">
					<span class="sidebar-mini"> EF </span>
					<span class="sidebar-normal"> Monthly News </span>
				</a>
			</li>
			<li class="nav-item @if(Request::segment(3)=='cat-news-report') active @endif">
				<a class="nav-link" href="{{ url('admin/report/cat-news-report?range=null') }}">
					<span class="sidebar-mini"> EF </span>
					<span class="sidebar-normal"> Category News </span>
				</a>
			</li>
			<li class="nav-item @if(Request::segment(3)=='watermark-ad') active @endif">
				<a class="nav-link" href="{{ url('admin/report/watermark-ad/?s_date='.date('Y-m-d').'&e_date='.date('Y-m-d')) }}">
					<span class="sidebar-mini"> EF </span>
					<span class="sidebar-normal"> Monthly Watermark Ad </span>
				</a>
			</li>
			<li class="nav-item @if(Request::segment(3)=='special-tag') active @endif">
				<a class="nav-link" href="{{ url('admin/report/special-tag/?rdate='.date('Y-m')) }}">
					<span class="sidebar-mini"> EF </span>
					<span class="sidebar-normal"> Monthly Tag News </span>
				</a>
			</li>
		</ul>
	</div>
</li>
@endif

<li class="nav-item @if(Request::segment(2)=='tag') active  @endif">
	<a class="nav-link" href="{{ url('admin/tag')}}">
		<i class="material-icons">tag</i>
		<p> Tag Manager </p>
	</a>
</li>