<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Session;
use Redirect;
use App\Models\Ads;
use App\Models\Tag;
use App\Models\Menu;
use App\Models\Miscellaneous;
use App\Models\News;
use App\Models\Writers;
use App\Models\NewsArchive;
use App\Models\PrintSettings;
use App\Helpers\clearCacheHelpers;
use App\Helpers\generalHelper;
use App\Http\Requests\NewsRequest;
use App\Helpers\ImageStoreHelpers;
use App\Helpers\SocialMediaEmbedder;

class NewsController extends Controller
{

	private $edition;

	public function __construct(Request $request)
	{
		$routeName = \Route::currentRouteName();
		$this->edition = $request->get('edition');

		if ($routeName == 'news.create' || $routeName == 'news.edit' || $routeName == 'news.trash' || $routeName == 'news.sorting' || $routeName == 'news.sortnews') {
			if ($this->edition != 'online' && $this->edition != 'print' && $this->edition != 'magazine' && $this->edition != 'multimedia') {
				return Redirect::to('admin/error403')->send();
			}
		}
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$menusSql = Menu::where('m_status', 1)->where('slug', '!=', '#');
		$magazine = [];

		if ($this->edition == 'online') {
			$menusSql->where('m_edition', 'online');
		} elseif ($this->edition == 'multimedia') {
			$menusSql->where('m_edition', 'multimedia');
		} else {
			$menusSql->where('m_edition', 'print');
			$magazine = Menu::where('m_status', 1)->where('m_edition', 'magazine')->orderBy('m_order', 'asc')->get();
		}

		$menus = $menusSql->orderBy('m_order', 'asc')->get();

		return view('admin.news.index', compact('menus', 'magazine'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request)
	{
		$watermark_ads = Ads::activeAd()->where('ads_positions_slug', 'watermark-ad')->orderBy('id', 'desc')->get();
		$menusSql = Menu::where('m_status', 1)->where('m_visible', 1);
		$activeWatermarkAd = Miscellaneous::where('status', 1)->where('id', 2)->first();
		$livenewsSql = News::with(['editingBy'])->where('n_status', 3)->where('is_live', 1)->orderBy('n_id', 'desc')->take(20)->get();

		if ($this->edition == 'online') {
			$newsdate = date('Y-m-d H:i:s');
			$menusSql->where('m_edition', 'online');
		} elseif ($this->edition == 'multimedia') {
			$newsdate = date('Y-m-d H:i:s');
			$menusSql->where('m_edition', 'multimedia');
		} elseif ($this->edition == 'print') {
			$pSql = PrintSettings::where('type', 'E-Paper-New-Date')->orderBy('id', 'desc')->first();
			$newsdate = $pSql->pdate;
			$menusSql->where('m_edition', 'print');
		} elseif ($this->edition == 'magazine') {
			$pSql = PrintSettings::where('type', 'Magazine-New-Date')->orderBy('id', 'desc')->first();
			$newsdate = $pSql->pdate;
			$menusSql->where('m_edition', 'magazine');
		}

		$menus = $menusSql->orderBy('m_order', 'asc')->get();

		$writers = Writers::where('status', 1)->get();


		if ($request->get('mid')) {
			$Menus = Menu::select('m_edition')->find($request->get('mid'));
			$edition = ($Menus->m_edition == 'magazine') ? 'print' : $Menus->m_edition;

			if ($edition != Auth::user()->type && Auth::user()->type != 'all' && !($edition == 'multimedia' && Auth::user()->type == 'online')) {
				return Redirect::to('admin/error403')->send();
			}
		}

		return view('admin.news.create', compact('newsdate', 'menus', 'watermark_ads', 'writers', 'activeWatermarkAd', 'livenewsSql'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(NewsRequest $request, ImageStoreHelpers $uploadImage, clearCacheHelpers $clearCacheHelpers)
	{
		$main_image = $request->file('main_image') ? $uploadImage->newsImageUpload($request->file('main_image'), date("Y-m-d"), $request->input('watermark')) : '';

		$n_author =  ($request->input('n_author') == 'other') ? $request->input('n_author_txt') : $request->input('n_author');
		$n_caption =  ($request->input('n_caption') == 'other') ? $request->input('n_caption_txt') : $request->input('n_caption');
		$n_order =  $request->input('n_order') ? $request->input('n_order') : 0;

		$news = News::create([
			'n_solder' => htmlentities($request->input('n_solder')),
			'n_head' => strip_tags($request->input('n_head')),
			'n_subhead' => htmlentities($request->input('n_subhead')),
			'news_tags' => $request->input('news_tags'),
			'n_author' => $n_author,
			'n_writer' => $request->input('n_writer'),
			'n_reporter' => $request->input('n_reporter'),
			'n_category' => $request->input('n_category'),
			'category_lead' => $request->input('category_lead'),
			'home_lead' => $request->input('home_lead'),
			'highlight_items' => $request->input('highlight_items'),
			'focus_items' => $request->input('focus_items'),
			'pin_news' => $request->input('pin_news'),
			'ticker_news' => $request->input('ticker_news'),
			'home_category' => $request->input('home_category'),
			'n_order' => $n_order,
			'is_latest' => $request->input('is_latest'),
			'sticky' => $request->input('sticky'),
			'cat_selected' => $request->input('cat_selected'),
			'home_slide' => $request->input('home_slide'),
			'multimedia_slide' => $request->input('multimedia_slide'),
			'n_details' => $request->input('n_details') ? htmlentities($request->input('n_details')) : '&nbsp;&nbsp;',
			'main_image' => $main_image,
			'n_caption' => htmlentities($n_caption),
			'watermark' => $request->input('watermark'),
			'embedded_code' => htmlentities($request->input('embedded_code')),
			'main_video' => $request->input('main_video') ? $request->input('main_video') : 0,
			'divisions' => $request->input('divisions'),
			'districts' => $request->input('districts'),
			'upazilas' => $request->input('upazilas'),
			'most_read'  => 1,
			'title_info' => $request->input('title_info'),
			'meta_keyword' => $request->input('meta_keyword'),
			'meta_description' => strip_tags($request->input('meta_description')),
			'start_at' => $request->input('start_at') ? $request->input('start_at') : date('Y-m-d H:i:s'),
			'n_date' => $request->input('start_at') ? date("Y-m-d", strtotime($request->input('start_at'))) : date('Y-m-d'),
			'n_status' => $request->input('n_category') ? $request->input('n_status') : 1,
			'edition' => $request->input('edition'),
			'created_by' => Auth::user()->id,
			'is_live' => $request->input('is_live'),
			'is_active_live' => $request->input('is_active_live'),
			'parent_id' => $request->input('parent_id'),
			'is_linked' => $request->input('is_linked'),
		]);
		// order update

		if ($request->input('home_lead_sort') != '') {
			$this->home_news_sort($news->n_id, $request->input('home_lead_sort'), 'home_lead', 'leadnews_order');
		} else {
			$news->leadnews_order = $news->n_id;
		}

		if ($request->input('highlight_sort') != '') {
			$this->home_news_sort($news->n_id, $request->input('highlight_sort'), 'highlight_items', 'highlight_order');
		} else {
			$news->highlight_order = $news->n_id;
		}

		$news->home_cat_order = $news->n_id;
		$news->focus_order = $news->n_id;
		$news->pin_order = $news->n_id;
		$news->special_order = $news->n_id;
		$news->home_slide_order = $news->n_id;
		$news->multimedia_slide_order = $news->n_id;
		$news->save();

		$clearCacheHelpers->newsStore($request, $news->n_id);

		Session::flash('success', "Successfully Inserted");
		if ($request->input('edition') == 'online' || $this->edition == 'multimedia') {
			return redirect('/admin/dashboard');
		}
		return Redirect::back();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id, Request $request)
	{
		$newsSql = News::with(['catName', 'createdBy', 'updatedBy'])->where('n_category', $id);

		if ($this->edition == 'online') {
			$newsdate = ($request->input('n_date')) ? $request->input('n_date') : date('Y-m-d');
			$newsSql = $newsSql->where('n_date', $newsdate)->where('n_status', 3);
		} elseif ($this->edition == 'multimedia') {
			$newsdate = ($request->input('n_date')) ? $request->input('n_date') : date('Y-m-d');
			$newsSql = $newsSql->where('n_date', $newsdate)->where('n_status', 3);
		} elseif ($this->edition == 'print') {
			$pSql = PrintSettings::where('type', 'E-Paper-New-Date')->orderBy('id', 'desc')->first();
			$newsdate = $pSql->pdate;
			$newsSql = $newsSql->where('n_date', $newsdate);
		} elseif ($this->edition == 'magazine') {
			$pSql = PrintSettings::where('type', 'Magazine-New-Date')->orderBy('id', 'desc')->first();
			$newsdate = $pSql->pdate;
			$newsSql = $newsSql->where('n_date', $newsdate);
		}

		$news = $newsSql->get();

		return view('admin.news.show', compact('news', 'newsdate'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id, Request $request)
	{
		$menusSql = Menu::where('m_status', 1)->where('m_visible', 1);
		$archive = NewsArchive::where('n_id', $id)->with(['editedBy', 'updatedBy'])->orderByDesc('id')->limit(100)->get();
		$livenewsSql = News::with(['editingBy'])->where('n_status', 3)->where('is_live', 1)->orderBy('n_id', 'desc')->take(20)->get();

		if ($this->edition == 'online') {
			$menusSql->where('m_edition', 'online');
		} elseif ($this->edition == 'multimedia') {
			$menusSql->where('m_edition', 'multimedia');
		} elseif ($this->edition == 'print') {
			$menusSql->where('m_edition', 'print');
		} elseif ($this->edition == 'magazine') {
			$menusSql->where('m_edition', 'magazine');
		}

		$menus = $menusSql->orderBy('m_order', 'asc')->get();

		if ($request->get('archiveid')) {
			$news = NewsArchive::find($request->get('archiveid'));
		} else {
			$news = News::findNewsTable($id)->find($id);
		}

		if ($this->edition == 'online' || $this->edition == 'multimedia') {
			if ($news->onediting != 0 && $news->onediting != Auth::user()->id) {
				Session::flash('success', "On Edit");
				return redirect('/admin/dashboard');
			} else {
				News::findNewsTable($id)->where('n_id', $id)->update(['onediting' => Auth::user()->id]);
			}
		}

		$writers = Writers::where('status', 1)->get();
		$tag = ($news->news_tags != '') ? Tag::where('id', $news->news_tags)->first() : '';

		$watermark_ads = Ads::where('id', $news->watermark)->first();

		return view('admin.news.edit', compact('news', 'archive', 'menus', 'watermark_ads', 'writers', 'tag', 'livenewsSql'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(NewsRequest $request, $id, ImageStoreHelpers $uploadImage, clearCacheHelpers $clearCacheHelpers)
	{
		$old_main_image = $request->input('old_main_image');
		$get_main_image = $request->file('main_image') ? $request->file('main_image') : '';
		$main_image = $uploadImage->newsImageEdit($get_main_image, $request->get('created_at'), $old_main_image, $request->input('watermark'));

		$n_author =  ($request->input('n_author') == 'other') ? $request->input('n_author_txt') : $request->input('n_author');
		$n_caption =  ($request->input('n_caption') == 'other') ? $request->input('n_caption_txt') : $request->input('n_caption');
		$n_order =  $request->input('n_order') ? $request->input('n_order') : 0;

		$NewsArchive = News::findNewsTable($id)->find($id);
		$NewsArchive->edited_by = Auth::user()->id;
		$NewsArchive->edited_at = date('Y-m-d H:i:s');
		NewsArchive::create($NewsArchive->attributesToArray());

		$array = [
			'n_solder' => htmlentities($request->input('n_solder')),
			'n_head' => strip_tags($request->input('n_head')),
			'n_subhead' => htmlentities($request->input('n_subhead')),
			'news_tags' => $request->input('news_tags'),
			'n_author' => $n_author,
			'n_writer' => $request->input('n_writer'),
			'n_reporter' => $request->input('n_reporter'),
			'n_category' => $request->input('n_category'),
			'category_lead' => $request->input('category_lead'),
			'home_lead' => $request->input('home_lead'),
			'highlight_items' => $request->input('highlight_items'),
			'focus_items' => $request->input('focus_items'),
			'pin_news' => $request->input('pin_news'),
			'ticker_news' => $request->input('ticker_news'),
			'home_category' => $request->input('home_category'),
			'n_order' => $n_order,
			'is_latest' => $request->input('is_latest'),
			'sticky' => $request->input('sticky'),
			'cat_selected' => $request->input('cat_selected'),
			'home_slide' => $request->input('home_slide'),
			'multimedia_slide' => $request->input('multimedia_slide'),
			'n_details' => $request->input('n_details') ? htmlentities($request->input('n_details')) : '&nbsp;&nbsp;',
			'main_image' => $main_image,
			'n_caption' => htmlentities($n_caption),
			'watermark' => $request->input('watermark'),
			'embedded_code' => htmlentities($request->input('embedded_code')),
			'main_video' => $request->input('main_video') ? $request->input('main_video') : 0,
			'divisions' => $request->input('divisions'),
			'districts' => $request->input('districts'),
			'upazilas' => $request->input('upazilas'),
			'title_info' => $request->input('title_info'),
			'meta_keyword' => $request->input('meta_keyword'),
			'meta_description' => strip_tags($request->input('meta_description')),
			'start_at' => $request->input('start_at'),
			'n_date' => date("Y-m-d", strtotime($request->input('start_at'))),
			'edit_at' => date('Y-m-d H:i:s'),
			'n_status' => $request->input('n_category') ? $request->input('n_status') : 1,
			'edition' => $request->input('edition'),
			'updated_by' => Auth::user()->id,
			'is_live' => $request->input('is_live'),
			'is_active_live' => $request->input('is_active_live'),
			'parent_id' => $request->input('parent_id'),
			'is_linked' => $request->input('is_linked'),
			'onediting' => 0,
		];

		if ($request->has('most_read')) {
			$array['most_read'] = $request->input('most_read');
		}

		News::findNewsTable($id)->where('n_id', $id)->update($array);

		if ($request->input('refetch-lead') == 1) {
			$this->home_news_sort($id, 15, 'home_lead', 'leadnews_order');
		}
		if ($request->input('refetch-highlight') == 1) {
			$this->home_news_sort($id, 15, 'highlight_items', 'highlight_order');
		}

		if ($request->input('refetch-pin_news') == 1) {
			$this->home_news_sort($id, 15, 'pin_news', 'pin_order');
		}

		if ($request->input('refetch-focus_items') == 1) {
			$this->home_news_sort($id, 15, 'focus_items', 'focus_order');
		}

		if ($request->input('refetch-slide') == 1) {
			$this->home_news_sort($id, 15, 'home_slide', 'home_slide_order');
		}

		if ($request->input('refetch-multimedia-slide') == 1) {
			$this->home_news_sort($id, 15, 'multimedia_slide', 'multimedia_slide_order');
		}

		if ($request->has('most_read')) {
			News::findNewsTable($id)->where('n_id', $id)->update([
				'most_read' => $request->input('most_read'),
			]);
		}

		$clearCacheHelpers->newsUpdate($request, $id);

		Session::flash('success', "Successfully Updated");
		return Redirect::to("admin/news/" . $request->input('n_category') . "?edition=" . $request->input('edition') . "&n_date=" . date("Y-m-d", strtotime($request->input('start_at'))));
	}

	/**
	 * editing news release.
	 * access only editor and devloper
	 */
	public function release($nid)
	{
		if (Auth::user()->role == 'developer' || Auth::user()->role == 'editor') {
			News::findNewsTable($nid)->where('n_id', $nid)->update(['onediting' => 0]);
			Session::flash('success', "Successfully Release");
			return Redirect::to('admin/dashboard');
		} else {
			News::findNewsTable($nid)->where('onediting', Auth::user()->id)->where('n_id', $nid)->update(['onediting' => 0]);
			Session::flash('success', "Successfully Release");
			return Redirect::to('admin/dashboard');
		}
		Session::flash('error', "Permission Denied");
		return Redirect::back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id, NewsRequest $request, clearCacheHelpers $clearCacheHelpers)
	{
		$news = News::findNewsTable($id)->where('n_id', $id)->first();
		$news->deleted_by = Auth::user()->id;
		$news->save();
		$news->delete();

		$clearCacheHelpers->newsDestroy($id, $news);

		Session::flash('success', "Successfully Destroyed");
		return Redirect::back();
	}

	/**
	 * news shoring.
	 *
	 */
	public function home_news_sort($nid, $lead_sort, $where_name, $order_by)
	{
		$sorting = News::where($where_name, 1)->skip($lead_sort)->orderByDesc($order_by)->limit(19)->get();
		$newsOrder = 0;
		foreach ($sorting as $key => $value) {
			if ($key == 0) {
				$newsOrder = $value->$order_by;
			}

			News::findNewsTable($value->n_id)->where('n_id', $value->n_id)->where($where_name, 1)->update([
				$order_by => ($value->$order_by - 1),
			]);
		}
		News::findNewsTable($nid)->where('n_id', $nid)->update([
			$order_by => $newsOrder,
		]);
	}

	/**
	 * Custom function.
	 */
	public function sorting()
	{
		$menus = Menu::where('m_status', 1)->where('m_edition', 'online')->where('m_visible', 1)->orderBy('m_order', 'ASC')->get();
		$tags = Tag::where('status', 1)->orderBy('id', 'asc')->get();
		return view('admin.news.sorting', compact('menus', 'tags'));
	}

	public function sortnews($mid, Request $request)
	{
		$newsSql = News::with(['editingBy'])->where('n_status', 3);
		$newsStickySql = News::with(['editingBy'])->where('n_status', 3);
		$sticky = 0;

		switch ($mid) {
			case 'leadnews':
				$newsSql->where('home_lead', 1)->where('sticky', 0)->orderBy('leadnews_order', 'desc');
				$newsStickySql->where('home_lead', 1)->where('sticky', 1)->orderBy('leadnews_order', 'desc');
				$order_name = 'leadnews_order';
				$sticky = 1;
				break;
			case 'highlight':
				$newsSql->where('highlight_items', 1)->where('sticky', 0)->orderBy('highlight_order', 'desc');
				$newsStickySql->where('highlight_items', 1)->where('sticky', 1)->orderBy('highlight_order', 'desc');
				$order_name = 'highlight_order';
				$sticky = 1;
				break;
			case 'focus':
				$newsSql->where('focus_items', 1)->where('sticky', 0)->orderBy('focus_order', 'desc');
				$newsStickySql->where('focus_items', 1)->where('sticky', 1)->orderBy('focus_items', 'desc');
				$order_name = 'focus_order';
				$sticky = 1;
				break;
			case 'pin':
				$newsSql->where('pin_news', 1)->where('sticky', 0)->orderBy('pin_order', 'desc');
				$newsStickySql->where('pin_news', 1)->where('sticky', 1)->orderBy('pin_order', 'desc');
				$order_name = 'pin_order';
				$sticky = 1;
				break;
			case 'slide':
				$newsSql->where('home_slide', 1)->orderBy('home_slide_order', 'desc');
				$order_name = 'home_slide_order';
				break;
			case 'multimedia':
				$newsSql->where('multimedia_slide', 1)->orderBy('multimedia_slide_order', 'desc');
				$order_name = 'multimedia_slide_order';
				break;
			case 'specialTag':
				$specialSigmentTagId = $request->get('tag_id');
				$newsSql->where('news_tags', $specialSigmentTagId)->orderBy('special_order', 'desc');
				$order_name = 'special_order';
				break;
			default:
				$mids = generalHelper::getSubmenus($mid);

				$categoryLead = News::where('n_status', 3)->where('category_lead', '1')->whereIn('n_category', $mids)->orderBy('n_id', 'desc')->first();

				if (isset($categoryLead['n_id'])) {
					$newsSql->where('n_id', '!=', $categoryLead['n_id']);
				}

				$newsSql->whereIn('n_category', $mids)->where('home_category', 1)->orderBy('home_cat_order', 'desc');
				$order_name = 'home_cat_order';
				break;
		}

		$news = $newsSql->take(20)->get();

		if ($sticky == 1) {
			$stickyNews = $newsStickySql->take(9)->get();
			if ($stickyNews) {
				$custom = collect($stickyNews);
				$news = $custom->merge($news);
			}
		}

		return view('admin.news.sortnews', compact('news', 'order_name', 'mid'));
	}

	public function sortupdate(Request $request, clearCacheHelpers $clearCacheHelpers)
	{
		if (Auth::user()->role == 'subscriber') {
			Session::flash('unauthorized', "403 | This action is unauthorized.");
			return Redirect::back();
		}

		$order_name = $request->get('order_name');
		$n_order = $request->get('n_order');
		$n_id = $request->get('n_id');
		$mid = $request->get('mid');

		foreach ($n_id as $key => $value) {
			News::where('n_id', $n_id[$key])->update([
				$order_name => $n_order[$key]
			]);
		}

		$clearCacheHelpers->newsSort($order_name, $mid);

		Session::flash('success', "Successfully Updated");
		return Redirect::back();
	}

	public function trash(Request $request)
	{
		if ($request->get('n_id')) {
			$id = $request->get('n_id');
			$trashSql = News::findNewsTable($id)->onlyTrashed()->with(['catName', 'createdBy', 'updatedBy', 'deletedBy'])->where('n_id', $id);
		} else {
			$trashSql = News::onlyTrashed()->with(['catName', 'createdBy', 'updatedBy', 'deletedBy']);
		}

		if ($request->get('n_head')) {
			$trashSql->where('n_head', $request->get('n_head'));
		}
		if ($request->get('n_date')) {
			$trashSql->where('n_date', $request->get('n_date'));
		}

		if ($this->edition == 'online') {
			$trashSql->where('edition', 'online');
		} elseif ($this->edition == 'multimedia') {
			$trashSql->where('edition', 'multimedia');
		} elseif ($this->edition == 'print' || $this->edition == 'magazine') {
			$trashSql->where('edition', '!=', 'online');
			// $trashSql->where('edition','print')->orWhere('edition','magazine');
		}

		$trash = $trashSql->cursorPaginate(500);

		return view('admin.news.trash', compact('trash'));
	}

	public function restore(Request $request)
	{
		if (Auth::user()->role == 'subscriber') {
			Session::flash('unauthorized', "403 | This action is unauthorized.");
			return Redirect::back();
		}

		$id = $request->input('n_id');
		$news = News::findNewsTable($id)->where('n_id', $id)->onlyTrashed()->first();
		$news->deleted_by = NULL;
		$news->restore_by = Auth::user()->id;
		$news->save();
		$news->restore();

		Session::flash('success', "Restore Successful");
		return Redirect::back();
	}

	public function findwatermarkads($txt)
	{
		$results[] = [];

		$sql = Ads::where('ads_positions_slug', 'watermark-ad');

		if ($txt != '' && $txt != 'undefined') {
			$sql = $sql->where('name', 'like', $txt . '%');
		} else {
			$results[] = [
				"id" => '',
				"text" => 'None'
			];
		}
		$sql = $sql->orderBy('id', 'desc')->limit(10)->get();

		foreach ($sql as $value) {
			if ($value->end_date < date('Y-m-d H:i:s') && $value->end_date != '') {
				$status = 'Inactive';
			} elseif ($value->status == 1) {
				$status = 'Active';
			} else {
				$status = 'Inactive';
			}

			$results[] = [
				"id" => $value->id,
				"text" => $value->name . ' / ' . $status
			];
		}
		$arr = [
			"results" => $results
		];

		return response()->json($arr);
	}

	public function findMoreNews($txt)
	{

		$sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'start_at', 'edit_at', 'created_at', 'deleted_at')->with('catName');

		if ($txt != '' && $txt != 'undefined' && $txt != 'none') {
			$sql = $sql->where('n_head', 'like', $txt . '%');
		}

		$sql = $sql->orderBy('n_id', 'desc')->limit(10)->get();

		$results = [];

		foreach ($sql as $row) {
			// if ($row->catName->m_edition == 'online') {
			// 	$m_edition = 'online';
			// } elseif ($row->catName->m_edition == 'multimedia') {
			// 	$m_edition = 'multimedia';
			// } elseif ($row->catName->m_edition == 'print') {
			// 	$m_edition = 'print-edition';
			// } else {
			// 	$m_edition = 'feature';
			// }

			$results[] = [
				'id' =>  $row->n_id,
				'name' =>  $row->n_head,
				'img' => ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, ''),
				'f_date' => $row->start_at,
				'link' => 'https://en.banglanews24.com/' . $row->catName->slug . '/news/bd/' . $row->n_id . '.details',
			];
		}

		return response()->json($results, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_INVALID_UTF8_SUBSTITUTE);
	}

	public function topNewsCallback()
	{
		$sql = News::isActive()->select('n_id', 'n_head', 'n_details', 'n_category', 'edition', 'main_image', 'start_at', 'edit_at', 'created_at', 'deleted_at')->with('catName')->where('n_date', date("Y-m-d"))->orderBy('n_id', 'desc')->get();

		$results = [];

		foreach ($sql as $row) {
			// if ($row->catName->m_edition == 'online') {
			// 	$m_edition = 'online';
			// } elseif ($row->catName->m_edition == 'multimedia') {
			// 	$m_edition = 'multimedia';
			// } else if ($row->catName->m_edition == 'print') {
			// 	$m_edition = 'print-edition';
			// } else {
			// 	$m_edition = 'feature';
			// }

			$results[] = [
				'id' =>  $row->n_id,
				'name' =>  $row->n_head,
				'n_head' =>  $row->n_head,
				'n_details' =>  generalHelper::splitText($row->n_details, 300),
				'img' => ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, ''),
				'f_date' => $row->start_at,
				'link' => 'https://en.banglanews24.com/' . $row->catName->slug . '/news/bd/' . $row->n_id . '.details',
			];
		}

		return response()->json($results, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_INVALID_UTF8_SUBSTITUTE);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function livenews()
	{
		$newsSql = News::with(['catName', 'createdBy', 'updatedBy'])->where('is_live', 1)->where('n_status', 3);

		$news = $newsSql->get();

		return view('admin.news.livenews', compact('news'));
	}
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function livenewslist($nid, Request $request)
	{
		$parentNews = News::with(['catName', 'createdBy', 'updatedBy'])->where('n_id', $nid)->where('n_status', 3)->first();
		$newsSql = News::with(['catName', 'createdBy', 'updatedBy'])->where('parent_id', $nid)->where('n_status', 3);

		$news = $newsSql->get();

		return view('admin.news.livenewslist', compact('news', 'parentNews'));
	}

	public function embedSocial(Request $request, SocialMediaEmbedder $uploadImage)
	{
		$videoUrl = urldecode(trim($request->get('url')));

		$result = $uploadImage->getEmbedFromUrl($videoUrl);

		if ($result['platform'] == 'unknown') {
			return [
				'error' => $result['error'],
				'status' => 'error'
			];
		} else {
			return [
				'platform' => $result['platform'],
				'embed_link' => $result['embed_link'],
				'status' => 'success'
			];
		}
	}
}
