<?php

namespace App\Helpers;


use App\Models\News;
use App\Helpers\generalHelper;
use App\Helpers\queryHelpers;
use Illuminate\Support\Facades\Cache;


class clearCacheHelpers
{

	public function menuClear()
	{
		Cache::forget('nav');
		Cache::forget('allnav');
		Cache::forget('multimediaMenu');
		Cache::forget('todaysNewspaperMenu');
		Cache::forget('todaysMagazineMenu');
		Cache::forget('adMenuCheck');
		Cache::forget('appMenu');
	}

	public static function autoQuickCache()
	{
		Cache::put('desktop-home-banner', queryHelpers::query_Banner('desktop', 'home'), 300);
		Cache::put('mobile-home-banner', queryHelpers::query_Banner('mobile', 'home'), 300);

		Cache::put('desktop-category-banner', queryHelpers::query_Banner('desktop', 'category'), 300);
		Cache::put('mobile-category-banner', queryHelpers::query_Banner('mobile', 'category'), 300);

		Cache::put('desktop-details-banner', queryHelpers::query_Banner('desktop', 'details'), 300);
		Cache::put('mobile-details-banner', queryHelpers::query_Banner('mobile', 'details'), 300);

		Cache::put('leadNews', queryHelpers::query_LeadNews(), 300);
		Cache::put('leadLiveNews', queryHelpers::query_LiveNews('home_lead'), 300);
		Cache::put('highlight', queryHelpers::query_Highlight(), 300);
		// Cache::put('focusitems', queryHelpers::query_Focusitems(), 300);
		// Cache::put('pin_news', queryHelpers::query_PinNews(), 300);
		// Cache::put('pinLiveNews', queryHelpers::query_LiveNews('pin_news'), 300);
		Cache::put('homeCat_1', queryHelpers::query_HomeCategory_With_Details(1, 20, 400), 300);
		Cache::put('homeCat_2', queryHelpers::query_HomeCategory_With_Details(2, 20, 400), 300);
		Cache::put('homeCat_14', queryHelpers::query_HomeCategory_With_Details(14, 20, 400), 300);
		Cache::put('homeCat_4', queryHelpers::query_HomeCategory_With_Details(4, 20, 400), 300);
		Cache::put('homeCat_3', queryHelpers::query_HomeCategory_With_Details(3, 20, 400), 300);
		Cache::put('homeCat_5', queryHelpers::query_HomeCategory_With_Details(5, 20, 400), 300);
		Cache::put('homeCat_6', queryHelpers::query_HomeCategory_With_Details(6, 20, 400), 300);
		Cache::put('homeCat_1208', queryHelpers::query_HomeCategory_With_Details(1208, 20, 400), 300);
		Cache::put('homeCat_1253', queryHelpers::query_HomeCategory_With_Details(1253, 20, 400), 300);
		Cache::put('homeCat_14', queryHelpers::query_HomeCategory_With_Details(14, 20, 400), 300);
		Cache::put('homeCat_12', queryHelpers::query_HomeCategory_With_Details(12, 20, 400), 300);
		Cache::put('homeCat_20', queryHelpers::query_HomeCategory_With_Details(20, 20, 400), 300);
		Cache::put('homeCat_19', queryHelpers::query_HomeCategory_With_Details(19, 20, 400), 300);
		Cache::put('homeCat_7', queryHelpers::query_HomeCategory_With_Details(7, 20, 400), 300);
		Cache::put('homeCat_9', queryHelpers::query_HomeCategory_With_Details(9, 20, 400), 300);
		Cache::put('homeCat_15', queryHelpers::query_HomeCategory_With_Details(15, 20, 400), 300);
		Cache::put('homeCat_11', queryHelpers::query_HomeCategory_With_Details(11, 20, 400), 300);
		Cache::put('homeCat_16', queryHelpers::query_HomeCategory_With_Details(16, 20, 400), 300);

		Cache::put('latest', queryHelpers::query_LatestNews(), 503);
		Cache::put('most_read', queryHelpers::query_MostRead(), 503);
		Cache::put('homePhotoGallery', queryHelpers::query_HomePhotoGallery(), 503);
		Cache::put('homeVideoGallery', queryHelpers::query_HomeVideoGallery(), 503);
		Cache::put('special_video', queryHelpers::query_HomeSpecialVideo(), 503);
		Cache::put('home_videoSlide', queryHelpers::query_HomeVideoSlide(), 503);


		// Cache::put('best_of_week', queryHelpers::query_BestOfWeekNews(), 503);

		// Cache::put('homeMagazine', queryHelpers::query_HomeMagazine(), 503);
		// Cache::put('homeAstrology', queryHelpers::query_HomeAstrology(), 503);
		// Cache::put('multimediaHome', queryHelpers::query_HomeMultimedia(), 503);
		// Cache::put('homePool', queryHelpers::query_HomePool(), 303);
		// Cache::put('special_tag', queryHelpers::query_HomeSpecialTagNews(), 503);
		// Cache::put('special_carousel', queryHelpers::query_SpecialCarousel(), 503);

		Cache::put('special_tag_news', queryHelpers::query_specialSigment(), 503);
	}

	public function homeCategorys($n_category)
	{
	}

	public function newsStore($request, $n_id)
	{
		$n_category = $request['n_category'];
		if ($n_category != '') {
			if ($request['home_lead'] == 1) {
				// Cache::put('leadNews', queryHelpers::query_LeadNews(), 300);
				// Cache::put('leadLiveNews', queryHelpers::query_LiveNews('home_lead'), 300);
				Cache::put('newAppleadNews', queryHelpers::query_AppLeadNews(), 300);
			}
			if ($request['highlight_items'] == 1) {
				// Cache::put('highlight', queryHelpers::query_Highlight(), 300);
				Cache::put('newApphighlight', queryHelpers::query_AppHighlight(), 300);
			}
			if ($request['focus_items'] == 1) {
				// Cache::put('focusitems', queryHelpers::query_Focusitems(), 300);
				Cache::put('newAppfocus_items', queryHelpers::query_AppFocusitems(), 300);
			}
			if ($request['pin_news'] == 1) {
				// Cache::put('pin_news', queryHelpers::query_PinNews(), 300);
				// Cache::put('pinLiveNews', queryHelpers::query_LiveNews('pin_news'), 300);
			}

			if ($request['ticker_news'] == 1) {
				Cache::forget('ticker');
				Cache::forget('Appticker');
			}

			if ($request['edition'] == 'online') {
				// Online category news list update
				$getSlug = News::select('n_id', 'n_category')->where('n_id', $n_id)->with('catName')->first()->toArray();
				Cache::put('category-' . $getSlug['cat_name']['slug'] . '-1-', queryHelpers::query_CategoryNewsList($getSlug['cat_name']['slug'], 'online', ''), 600);
			}

			Cache::put('details-' . $n_id, queryHelpers::query_DetailsNews($n_id), 300);
			Cache::put($n_category . '-' . $n_id . '-more', queryHelpers::query_DetailsMoreNews($n_category, $n_id), 600);

			$liveParentId = generalHelper::getLiveParentId($n_id);
			if ($liveParentId) {
				Cache::put('live-news-' . $n_id, queryHelpers::query_DetailsLiveNews($n_id), 300);
			}

			if ($request['meta_keyword']) {
				Cache::put($request['meta_keyword'] . '-meta_keyword', queryHelpers::query_MetaKeywordNews($request['meta_keyword'], $n_id), 600);
			}

			// Cache::forget('latest');
			// Cache::put('latest', queryHelpers::query_LatestNews(), 503);
			Cache::forget('Applatest');
			Cache::forget('ApphomeCat_' . $n_category);

			// $parentMenuId = generalHelper::getParentId($n_category);
			// $this->homeCategorys($parentMenuId);
			$this->homeCategorys($n_category);
		}
	}

	public function newsUpdate($request, $n_id)
	{
		$n_category = $request['n_category'];
		if ($n_category != '') {
			if ($request['home_lead'] == 1) {
				// Cache::forget('leadNews');
				// Cache::forget('AppleadNews');
				// Cache::put('leadNews', queryHelpers::query_LeadNews(), 300);
				// Cache::put('leadLiveNews', queryHelpers::query_LiveNews('home_lead'), 300);
				Cache::put('newAppleadNews', queryHelpers::query_AppLeadNews(), 300);
			}
			if ($request['highlight_items'] == 1) {
				// Cache::put('highlight', queryHelpers::query_Highlight(), 300);
				Cache::put('newApphighlight', queryHelpers::query_AppHighlight(), 300);
			}
			if ($request['focus_items'] == 1) {
				// Cache::put('focusitems', queryHelpers::query_Focusitems(), 300);
				Cache::put('newAppfocus_items', queryHelpers::query_AppFocusitems(), 300);
			}
			if ($request['pin_news'] == 1) {
				// Cache::put('pin_news', queryHelpers::query_PinNews(), 300);
				// Cache::put('pinLiveNews', queryHelpers::query_LiveNews('pin_news'), 300);
			}
			if ($request['ticker_news'] == 1) {
				Cache::forget('ticker');
			}

			if ($request['edition'] == 'online') {
				// Online category news list update
				$getSlug = News::findNewsTable($n_id)->select('n_id', 'n_category')->where('n_id', $n_id)->with('catName')->first()->toArray();
				Cache::put('category-' . $getSlug['cat_name']['slug'] . '-1-', queryHelpers::query_CategoryNewsList($getSlug['cat_name']['slug'], 'online', ''), 600);
			}


			// Cache::forget('latest');
			// Cache::put('latest', queryHelpers::query_LatestNews(), 503);
			// Cache::forget('details-'.$n_id);
			Cache::put('details-' . $n_id, queryHelpers::query_DetailsNews($n_id), 300);
			Cache::put($n_category . '-' . $n_id . '-more', queryHelpers::query_DetailsMoreNews($n_category, $n_id), 600);

			$liveParentId = generalHelper::getLiveParentId($n_id);
			if ($liveParentId) {
				Cache::put('live-news-' . $liveParentId, queryHelpers::query_DetailsLiveNews($liveParentId), 300);
			}


			$parentMenuId = generalHelper::getParentId($n_category);
			$this->homeCategorys($parentMenuId);
			$this->homeCategorys($n_category);

			// App
			Cache::forget('Applatest');
			Cache::forget('ApphomeCat_' . $n_category);
			Cache::forget('Appdetails-' . $n_id);
		}
	}

	public function newsDestroy($id, $news)
	{
		Cache::forget('details-' . $id);
		// Cache::put('latest', queryHelpers::query_LatestNews(), 503);
		Cache::forget('Applatest');
	}

	public function newsSort($order_name, $mid)
	{
		switch ($order_name) {
			case 'leadnews_order':
				// Cache::put('leadNews', queryHelpers::query_LeadNews(), 300);
				Cache::put('newAppleadNews', queryHelpers::query_AppLeadNews(), 300);
				break;
			case 'highlight_order':
				// Cache::put('highlight', queryHelpers::query_Highlight(), 300);
				Cache::put('newApphighlight', queryHelpers::query_AppHighlight(), 300);
				break;
			case 'focus_order':
				// Cache::put('focusitems', queryHelpers::query_Focusitems(), 300);
				Cache::put('newAppfocus_items', queryHelpers::query_AppFocusitems(), 300);
				break;
			case 'pin_order':
				// Cache::forget('pin_news');
				// Cache::put('pin_news', queryHelpers::query_PinNews(), 300);
				break;
			default:
				$parentMenuId = generalHelper::getParentId($mid);
				$this->homeCategorys($parentMenuId);
				$this->homeCategorys($mid);
				Cache::forget('ApphomeCat_' . $mid);
				break;
		}
	}

	public function adStore($request)
	{
		Cache::forget('desktop-home-banner');
		Cache::forget('mobile-home-banner');
		Cache::forget('desktop-details-banner');
		Cache::forget('mobile-details-banner');
		Cache::forget('desktop-category-banner');
		Cache::forget('mobile-category-banner');
	}

	public function adUpdate($request)
	{
		// echo $request->input('device');exit;
		if ($request->input('device') == 'desktop')
			if ($request->input('page') == 'home')
				Cache::forget('desktop-home-banner');
			elseif ($request->input('page') == 'details')
				Cache::forget('desktop-details-banner');
			else
				Cache::forget('desktop-category-banner');
		elseif ($request->input('page') == 'home')
			Cache::forget('mobile-home-banner');
		elseif ($request->input('page') == 'details')
			Cache::forget('mobile-details-banner');
		else
			Cache::forget('mobile-category-banner');
	}

	public function adDestroy($sql)
	{
		// echo $sql->name;exit;
		Cache::forget('desktop-home-banner');
		Cache::forget('mobile-home-banner');
		Cache::forget('desktop-details-banner');
		Cache::forget('mobile-details-banner');
		Cache::forget('desktop-category-banner');
		Cache::forget('mobile-category-banner');
	}

	public function breakingNewsStore()
	{
		Cache::forget('breakingNews');
	}

	public function breakingNewsUpdate()
	{
		Cache::forget('breakingNews');
	}

	public function breakingNewsDestroy()
	{
		Cache::forget('breakingNews');
	}

	public function galleryStore($request)
	{
		Cache::forget('gallery_' . $request['category']);

		if ($request['special_video'] == 1) {
			// Cache::forget('special_video');
		}
	}

	public function galleryUpdate($request)
	{
		Cache::forget('gallery_' . $request['category']);

		if ($request['special_video'] == 1) {
			// Cache::forget('special_video');
		}
	}

	public function galleryDestroy() {}

	public function poolStore()
	{
		// Cache::forget('homePool');
	}

	public function poolUpdate()
	{
		// Cache::forget('homePool');
	}

	public function poolDestroy()
	{
		// Cache::forget('homePool');
	}

	public function eCacheHandler($type, $edate)
	{

		Cache::forget('PublishDate-' . $type);

		if ($type == 'Publish-Print-New-Date') {
			Cache::forget('todaysNewspaperMenu');
			Cache::forget('printhome');
			// Cache::forget('homeAstrology');
			// Cache::forget('homeCat_32');

			$pdate = generalHelper::getPublishDate('Publish-Print-New-Date');
			$printNav = News::select('n_category', 'edition', 'n_date')->with('catName')->where('edition', 'print')->where('n_date', $pdate)->groupBy('n_category')->get()->toArray();
			foreach ($printNav as $Pvalue) {
				Cache::forget('category-' . $Pvalue['cat_name']['slug'] . '-1-');
			}
		}

		if ($type == 'Publish-Magazine-New-Date') {
			Cache::forget('todaysMagazineMenu');
			// Cache::forget('homeMagazine');

			$mdate = generalHelper::getPublishDate('Publish-Magazine-New-Date');
			$magazineNav = News::select('n_category', 'edition', 'n_date')->with('catName')->where('edition', 'magazine')->where('n_date', $mdate)->groupBy('n_category')->get()->toArray();
			foreach ($magazineNav as $Mvalue) {
				Cache::forget('category-' . $Mvalue['cat_name']['slug'] . '-1-');
			}
		}

		if ($type == 'Publish-E-Magazine-New-Date') {
			Cache::forget('emagazineHome');
		}
	}

	public function screenStore($request) {}

	public function screenDestroy($sql)
	{
		// echo $sql->type;exit;

	}

	public function astrologyCache()
	{
		// Cache::forget('homeAstrology');
	}

	public function newsTop10()
	{
		Cache::forget('top10News');
	}
}

// use App\Helpers\cacheHelpers;
// , cacheHelpers $cacheHelpers->adUpdate();
