<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\News;
use App\Models\Writers;
use App\Helpers\generalHelper;
use App\Helpers\queryHelpers;
use Illuminate\Support\Facades\Cache;
use App\Helpers\ImageStoreHelpers;

class AuthorController extends Controller
{
    public function index(int $aid){
        $banner_desktop = Cache::remember('desktop-category-banner', 300, function () {
            return queryHelpers::query_Banner('desktop','category');
		});
		$banner_mobile = Cache::remember('mobile-category-banner', 300, function () {
            return queryHelpers::query_Banner('mobile','category');
		});

		$profile = Cache::remember('author-'.$aid, 500, function () use($aid) {
			$row = Writers::find($aid);
			$row->img = ImageStoreHelpers::showImage('profile',$row->created_at, $row->img);

			return $row;
		});
		
		$autorCurrentPage = 'author-page-'.$aid.'-'.request()->get('page',1);
		$newsList = Cache::remember($autorCurrentPage, 300, function () use($aid, $profile) {
			$sql = News::isActive()->select('n_id','n_solder','n_head','edition','n_subhead','main_image','start_at','created_at','deleted_at','n_category','n_writer','n_reporter')->with('catName')->where('n_writer', $aid)->orWhere('n_reporter', $aid)->orderBy('n_id', 'desc')->paginate(30);
		
			// if($profile->type=='writers'){
			// 	$sql->where('n_writer', $aid);
			// }else{
			// 	$sql->where('n_reporter', $aid);
			// }
			// $sql = $sql->orderBy('n_id', 'desc')->paginate(30);

			$sql->getCollection()->transform(function ($row, $key) {
				$row->main_image = ImageStoreHelpers::showImage('news_images',$row->created_at,$row->main_image,'thumbnail');
				$row->n_details = generalHelper::splitText($row->n_details, 400);
                 $row->date_at = generalHelper::bn_date(date("d F, Y", strtotime($row->start_date)));
				$row->f_date = date("Y/m/d", strtotime($row->start_at));
				return $row;
			});

			return $sql;
		});
        

		return response()->json([
			'banner_desktop' => $banner_desktop,
			'banner_mobile' => $banner_mobile,
			'profile' => $profile,
			'newsList' => $newsList,
		]);
    }

}
