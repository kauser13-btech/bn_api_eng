<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageStoreHelpers;
use Auth;
use Session;
use Redirect;
use App\Models\Miscellaneous;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;

class MiscellaneousController extends Controller
{

	public function electionResult()
	{
		$top10news = Miscellaneous::where('status', 1)->where('type', 'election')->first();
		return view('admin.miscellaneous.electionResult', compact('top10news'));
	}

	public function miscellaneousUpdate(Request $request)
	{
		if (Auth::user()->role == 'subscriber') {
			Session::flash('unauthorized', "403 | This action is unauthorized.");
			return Redirect::back();
		}
		$top10n_id = $request->get('id');
		Miscellaneous::where('id', $top10n_id)->update([
			'arr_data' => json_encode($request->input('arr_data')),
		]);
		Cache::forget('electionResult');
		Session::flash('success', "Successfully Updated");
		return Redirect::back();
	}

	public function watermarkAd()
	{
		$watermark_ads = Ads::activeAd()->where('ads_positions_slug', 'watermark-ad')->orderBy('id', 'desc')->get();
		$activeAd = Miscellaneous::where('status', 1)->where('id', 2)->first();
		return view('admin.miscellaneous.watermarkAd', compact('watermark_ads', 'activeAd'));
	}


	public function specialSigment()
	{
		$activeSpecial = Miscellaneous::where('status', 1)->where('id', 3)->first();

		// dd(json_decode($activeSpecial->arr_data));
		$tag_id = json_decode($activeSpecial->arr_data) != '' ? json_decode($activeSpecial->arr_data)->tag_id : 1;
		$tag = Tag::where('id', $tag_id)->first();
		return view('admin.miscellaneous.specialsigment', compact('activeSpecial', 'tag'));
	}

	public function miscellaneousSigmentUpdate(Request $request, ImageStoreHelpers $uploadImage)
	{
		if (Auth::user()->role == 'subscriber') {
			Session::flash('unauthorized', "403 | This action is unauthorized.");
			return Redirect::back();
		}

		$old_desk_image = $request->input('old_special_desktop_image');
		if ($request->file('special_desktop_image')) {
			$get_desk_image = $request->file('special_desktop_image');
			$desk_image = $uploadImage->specialSigmentImgUpload($get_desk_image, $old_desk_image);
		} else {
			$desk_image = $old_desk_image;
		}

		$old_mob_image = $request->input('old_special_mobile_image');
		if ($request->file('special_mobile_image')) {
			$get_mob_image = $request->file('special_mobile_image');
			$mob_image = $uploadImage->specialSigmentImgUpload($get_mob_image, $old_mob_image);
		} else {
			$mob_image = $old_mob_image;
		}

		$dataArray = [
			"title" => $request->input('special_title'),
			"display" => $request->input('special_display'),
			"tag_id" => $request->input('news_tags'),
			"desktop_img" => $desk_image,
			"mobile_img" => $mob_image
		];

		Miscellaneous::where('id', 3)->update([
			'arr_data' => json_encode($dataArray),
		]);

		Session::flash('success', "Successfully Updated");
		return Redirect::back();
	}

	public function newsCard($n_id, $ad_id, $card_id)
	{
		$card_sql = Ads::activeAd()->where('ads_positions_slug', 'news_card');
		$card_list = $card_sql->orderBy('id', 'desc')->get();

		if ($card_id != 0) {
			$news_card = $card_sql->where('id', $card_id);
		} else {
			$news_card = $card_sql->orderBy('id', 'desc');
		}
		$news_card_ad = $news_card->first();

		$watermark_sql = Ads::activeAd()->where('ads_positions_slug', 'watermark-ad');
		$watermark_list = $watermark_sql->orderBy('id', 'desc')->get();

		$watermark_ad = $watermark_sql->where('id', $ad_id)->first();

		$news = News::select('n_id', 'n_solder', 'n_head', 'n_caption', 'main_image', 'n_date', 'created_at')->find($n_id);

		return view('admin.miscellaneous.newsCard', compact('news', 'watermark_list', 'card_list', 'news_card_ad', 'watermark_ad'));
	}
}
