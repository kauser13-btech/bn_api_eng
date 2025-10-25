<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\Pool;
use App\Models\News;
use App\Models\Menu;
use Jenssegers\Agent\Agent;
use App\Models\BreakingNews;
use App\Helpers\queryHelpers;
use App\Helpers\generalHelper;
use Illuminate\Support\Facades\URL;
use App\Helpers\ImageStoreHelpers;
use Illuminate\Support\Facades\Route;

class CategoryController extends Controller
{

	public function index($cat, $pdate = '')
	{
		// $checkEdition = generalHelper::checkEdition($cat);

		switch (Route::currentRouteName()) {
			case 'printversion-category':
				$checkEdition = 'print';
				break;
			case 'magazine-category':
				$checkEdition = 'magazine';
				break;
			default:
				$checkEdition = 'online';
				break;
		}

		$banner_desktop = Cache::get('desktop-category-banner');
		$banner_mobile = Cache::get('mobile-category-banner');

		$currentPage = $cat . '-' . request()->get('page', 1) . '-' . request()->get('y', '') . '-' . $pdate;
		$category = Cache::flexible('category-' . $currentPage, [400, 900], function () use ($cat, $checkEdition, $pdate) {
			return queryHelpers::query_CategoryNewsList($cat, $checkEdition, $pdate);
		});

		$latest = Cache::get('latest');

		$most_read = Cache::get('most_read');

		$most_read_by_cat = Cache::flexible('most_read_by_cat-' . $cat, [305, 805], function () use ($cat) {
			return queryHelpers::query_MostRead($cat);
		});

		$cat_selected = Cache::flexible('cat_selected-' . $cat, [300, 600], function () use ($cat, $checkEdition) {
			$sql = News::isActive()->select('n_id', 'n_solder', 'n_head', 'n_details', 'n_category', 'edition', 'main_image', 'start_at', 'created_at', 'deleted_at')->with('catName')->whereHas('catName', function ($query) use ($cat, $checkEdition) {
				$query->where('slug', $cat)->where('m_edition', $checkEdition);
			})->where('cat_selected', 1)->orderBy('n_id', 'desc')->limit(10)->get();

			$sql->transform(function ($row, $key) {
				$row->n_details = generalHelper::splitText(strip_tags(html_entity_decode($row->n_details)), 400);
				$row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, '');
				$row->date_at = generalHelper::bn_date(date("d F, Y", strtotime($row->start_at)));
				$row->f_date = date("Y/m/d", strtotime($row->start_at));
				return $row;
			});
			return $sql;
		});

		return response()->json(
			[
				'banner_desktop' => $banner_desktop,
				'banner_mobile' => $banner_mobile,
				'category' => $category,
				'latest' => $latest,
				'most_read' => $most_read,
				'cat_selected' => $cat_selected,
				'most_read_by_cat' => $most_read_by_cat,
			],
			200,
			['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
			JSON_INVALID_UTF8_SUBSTITUTE
		);
	}

	public function election()
	{
		$currentPage = 'election-tag-' . request()->get('page', 1) . '-' . request()->get('y', '');
		$perPage = request()->get('per_page', 30);
		$category = Cache::remember('category-' . $currentPage . '-' . $perPage, 300, function () use ($perPage) {
			$sql = News::newsTable(request()->get('y'))->isActive()->select('n_id', 'n_solder', 'n_head', 'n_category', 'edition', 'main_image', 'n_details', 'created_at', 'start_at')->with('catName')->where('news_tags', 13)->orderBy('n_id', 'desc')->paginate($perPage);

			$sql->transform(function ($row, $key) {
				$row->thumb_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
				$row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, '');
				$row->n_head = strip_tags(html_entity_decode($row->n_head));
				$row->n_details = generalHelper::splitText(strip_tags(html_entity_decode($row->n_details)), 400);
				// $row->start_at = generalHelper::time_elapsed_string($row->start_at);
				$edition = ($row->edition == 'online') ? 'online/' : 'print-edition/';
				$row->detailsUrl = 'https://www.banglanews24.com/' . $edition . $row->catName->slug . '/' . date("Y/m/d", strtotime($row->start_at)) . '/' . $row->n_id;
				return $row;
			});

			return $sql;
		});

		return response()->json($category);
	}


	public function todayall()
	{
		$banner_desktop = Cache::get('desktop-category-banner');
		$banner_mobile = Cache::get('mobile-category-banner');

		$list = Cache::remember('today-all-' . request()->get('page', 1), 300, function () {
			$sql = News::isActive()->select('n_id', 'n_head', 'main_image', 'main_video', 'start_at', 'n_category', 'created_at', 'deleted_at', 'n_date', 'n_details')->with('catName')->orderBy('n_id', 'desc')->paginate(20);
			// ->where('n_date', date('Y-m-d'))


			$sql->transform(function ($row, $key) {
				$row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
				$row->n_details = generalHelper::splitText($row->n_details, 700);
				return $row;
			});
			return $sql;
		});


		return response()->json(
			[
				'banner_desktop' => $banner_desktop,
				'banner_mobile' => $banner_mobile,
				'list' => $list,
			],
			200,
			['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
			JSON_INVALID_UTF8_SUBSTITUTE
		);
	}

	public function printhome()
	{
		$breakingNews = Cache::remember('breakingNews', 501, function () {
			return BreakingNews::select('text', 'start_at', 'end_at', 'b_status',)->where('start_at', '<=', date('Y-m-d H:i:s'))->where('end_at', '>', date('Y-m-d H:i:s'))->orWhereNull('end_at')->where('b_status', 1)->orderBy('id', 'desc')->get();
		});

		$ticker = Cache::remember('ticker', 502, function () {
			return News::isActive()->select('n_id', 'n_head', 'start_at', 'deleted_at')->where('ticker_news', 1)->orderBy('n_id', 'desc')->limit(20)->get();
		});


		$printMenus = generalHelper::todaysNewspaperMenu()->toArray();
		$getPublishDate = generalHelper::getPublishDate('Publish-Print-New-Date');

		$sql = Cache::remember('printhome', 300, function () use ($printMenus, $getPublishDate) {
			$printNews = [];
			$data = [];
			foreach ($printMenus as $row) {
				$data['m_name'] = $row['m_name'];
				$data['slug'] = $row['slug'];
				$data['news'] = News::isActive()->select('n_id', 'n_head', 'n_category', 'main_image', 'start_at', 'created_at', 'deleted_at', 'n_date', 'n_details')->where('n_date', $getPublishDate)->where('n_category', $row['m_id'])->orderBy('n_order', 'ASC')->get();

				$printNews[] = $data;
			}
			return $printNews;
		});

		$agent = new Agent();

		if ($agent->isDesktop() || $agent->isTablet()) {
			return view('desktop.printhome', compact('breakingNews', 'ticker', 'sql', 'getPublishDate'));
		} else {
			return view('mobile.printhome', compact('breakingNews', 'ticker', 'sql', 'getPublishDate'));
		}
	}

	public function pollResults()
	{
		$banner = Cache::remember('desktop-category-banner', 300, function () {
			return Ads::activeAd()->where('device', 'desktop')->where('page', 'category')->get();
		});
		$breakingNews = Cache::remember('breakingNews', 501, function () {
			return BreakingNews::select('text', 'start_at', 'end_at', 'b_status',)->where('start_at', '<=', date('Y-m-d H:i:s'))->where('end_at', '>', date('Y-m-d H:i:s'))->orWhereNull('end_at')->where('b_status', 1)->orderBy('id', 'desc')->get();
		});

		$ticker = Cache::remember('ticker', 502, function () {
			return News::isActive()->select('n_id', 'n_head', 'start_at', 'deleted_at')->where('ticker_news', 1)->orderBy('n_id', 'desc')->limit(20)->get();
		});

		$poll = Pool::active()->orderBy('start_date', 'desc')->paginate(30)->setPath(URL::current());

		return view('desktop.poll_results', compact('banner', 'poll', 'breakingNews', 'ticker'));
	}

	public function geo($divisions = '', $districts = '', $upazilas = '')
	{
		$banner_desktop = Cache::get('desktop-category-banner');
		$banner_mobile = Cache::get('mobile-category-banner');

		$currentPage = $divisions . '-' . $districts . '-' . $upazilas . '-' . request()->get('page', 1);
		$news = Cache::remember('geo-' . $currentPage, 505, function () use ($divisions, $districts, $upazilas) {
			$sql =  News::newsTable(request()->get('y'))->isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'created_at', 'n_details', 'start_at', 'deleted_at')->with('catName');

			if ($divisions != '') {
				$sql = $sql->where('divisions', $divisions);
			}
			if ($districts != '') {
				$sql = $sql->where('districts', $districts);
			}
			if ($upazilas != '') {
				$sql = $sql->where('upazilas', $upazilas);
			}

			$sql = $sql->orderBy('n_id', 'desc')->paginate(20)->setPath(URL::current());

			$sql->getCollection()->transform(function ($row, $key) {
				$row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
				$row->n_details = generalHelper::splitText($row->n_details, 400);
				$row->f_date = date("Y/m/d", strtotime($row->start_at));
				return $row;
			});

			return $sql;
		});

		$latest = Cache::remember('latest', 503, function () {
			return queryHelpers::query_LatestNews();
		});

		$most_read = Cache::remember('most_read', 504, function () {
			return queryHelpers::query_MostRead();
		});

		return response()->json(
			[
				'news' => $news,
				'latest' => $latest,
				'most_read' => $most_read,
			],
			200,
			['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
			JSON_INVALID_UTF8_SUBSTITUTE
		);
	}

	public function topic($keyword)
	{
		$latest = Cache::get('latest');
		$most_read = Cache::get('most_read');

		$list = Cache::flexible('keyword-' . $keyword, [504, 900], function () use ($keyword) {
			$sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'start_at', 'created_at', 'deleted_at', 'n_date', 'n_details')->with('catName')->where('n_date', '>=', Carbon::now()->subDays(90))->where('meta_keyword', 'LIKE', '%' . $keyword . '%')->orderBy('n_id', 'desc')->limit(48)->get();

			$sql->transform(function ($row, $key) {
				$row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
				$row->n_details = generalHelper::splitText($row->n_details, 400);
				$row->f_date = date("Y/m/d", strtotime($row->start_at));
				return $row;
			});
			return $sql;
		});

		return response()->json(
			[
				'list' => $list,
				'latest' => $latest,
				'most_read' => $most_read,
			],
			200,
			['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
			JSON_INVALID_UTF8_SUBSTITUTE
		);
	}

	public function multimediaCat($cat)
	{
		$banner_desktop = Cache::get('desktop-category-banner');
		$banner_mobile = Cache::get('mobile-category-banner');

		$currentPage = $cat . '-' . request()->get('page', 1) . '-' . request()->get('y', '');
		$media = Cache::flexible('category-' . $currentPage, [400, 900], function () use ($cat) {
			return queryHelpers::query_CategoryNewsList($cat, 'multimedia');
		});

		$getNcat = $media->toArray();
		if ($getNcat['data']) {
			$getMostVideoCat = $getNcat['data'][0]['n_category'];
			$topMedia = Cache::flexible('multimediatopMedia-' . $getMostVideoCat, [300, 600], function () use ($getMostVideoCat) {
				$sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'main_image', 'start_at', 'created_at', 'deleted_at', 'n_date')->with('catName')->where('n_category', $getMostVideoCat)->orderBy('most_read', 'desc')->limit(3)->get();
				$sql->transform(function ($row, $key) {
					$row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
					$row->f_date = date("Y/m/d", strtotime($row->start_at));
					$row->date_at = generalHelper::bn_date(date("d F, Y", strtotime($row->start_at)));
					return $row;
				});
				return $sql;
			});
		} else {
			$topMedia = [];
		}

		return response()->json(
			[
				'banner_desktop' => $banner_desktop,
				'banner_mobile' => $banner_mobile,
				'topMedia' => $topMedia,
				'media' => $media,
			],
			200,
			['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
			JSON_INVALID_UTF8_SUBSTITUTE
		);
	}


	public function testoldCategory($cat)
	{
		switch (Route::currentRouteName()) {
			case 'printversion-category':
				$checkEdition = 'print';
				break;
			case 'feature-testoldCategory':
				$checkEdition = 'magazine';
				break;
			default:
				$checkEdition = 'online';
				break;
		}

		$catArcDate = request()->get('y') ? request()->get('y') : date('Y');

		$category = queryHelpers::query_CategoryNewsListTst($cat, $checkEdition, $catArcDate);

		if ($category->total() == 0 && $catArcDate != '2015') {
			for ($i = $catArcDate; $i >= 2015; $i--) {
				$year_data_loop = News::newsTable($i)->isActive()->select('n_id')->whereHas('catName', function ($query) use ($cat, $checkEdition) {
					$query->where('slug', $cat)->where('m_edition', $checkEdition);
				})->count();

				echo $i . '==' . $year_data_loop . '<br>';

				// if($year_data_loop != null){
				//     $catArcDate = $i;
				// 	$category = queryHelpers::query_CategoryNewsListTst($cat,$checkEdition,$catArcDate);
				//     break;
				// }
			}
			exit;
		}

		return response()->json($category);
	}
}
