<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Helpers\ImageStoreHelpers;
use App\Models\News;
use App\Models\Menu;
use Carbon\Carbon;

class RssFeedController extends Controller
{
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	// public function sitemap(){
	// 	return response()->view('rssfeed.sitemap')->header('Content-Type', 'text/xml');
	// }

	public function sitemap_section(){
		$urlslist = Menu::where('m_edition','online')->where('slug','!=','#')->where('m_status',1)->where('m_visible',1)->orderBy('m_order', 'ASC')->get();

		return response()->json($urlslist);
		// return response()->view('rssfeed.sitemap-section',compact('urlslist'))->header('Content-Type', 'text/xml');
	}
	public function daily_sitemap($getDate){
		$date = date($getDate);
		$year = date('Y', strtotime($date));
		// newsTable($year)->
		$urldetails = News::isActive()->select('n_id','n_head','n_category','main_image','edition','start_at','created_at','deleted_at','n_date')->with('catName')->where('n_date',$getDate)->orderBy('n_date', 'desc')->get();

		$urldetails->transform(function ($row, $key) {
		    $row->main_image = ImageStoreHelpers::showImage('news_images',$row->created_at,$row->main_image,'thumbnail');
		    $row->start_at = date('c', strtotime($row->start_at));
		    return $row;
		});

		return response()->json($urldetails);
		// return response()->view('rssfeed.sitemap-daily',compact('urldetails'))->header('Content-Type', 'text/xml');
		
	}
	public function fb_rss(){
		$rss_data = News::isActive()->select('n_id','n_head','main_image','start_at','created_at','deleted_at','n_date','n_details','n_author','meta_description')->where('instant_articles',1)->orderBy('n_date', 'desc')->limit(100)->get();
		return response()->view('rssfeed.fb_rss',compact('rss_data'))->header('Content-Type', 'text/xml');
	}

	public function recent_rss(){
        $urldetails = News::isActive()->select('n_id','n_head','n_category','main_image','edition','start_at','created_at','deleted_at','n_date')->with('catName')->where('n_date', '>=', Carbon::now()->subDays(1))->orderBy('n_id', 'desc')->get();

        $urldetails->transform(function ($row, $key) {
            $row->main_image = ImageStoreHelpers::showImage('news_images',$row->created_at,$row->main_image,'thumbnail');
            $row->start_at = date('D, d M Y H:i:s', strtotime($row->start_at));
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });

        return response()->json($urldetails);
    }

}
