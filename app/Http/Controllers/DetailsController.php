<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\News;
use App\Models\Paper;
use App\Models\Gallery;
use App\Models\LinkBetweenNews;
use Jenssegers\Agent\Agent;
use App\Models\BreakingNews;
use App\Helpers\queryHelpers;
use App\Helpers\generalHelper;
use App\Helpers\ImageStoreHelpers;
use App\Jobs\UpdateNewsCount;

class DetailsController extends Controller
{
    public function index(Request $request, $n_id, $title = '')
    {
        $HTTP_auth = ($request->header('Authorization') !== 'Basic base64:IqIxEkPjdl1Dnl9mjTKU6zTZD0') ? 1 : 1;

        try {
            // News::findNewsTable($n_id)->where('n_id',$n_id)->increment('most_read', 1);
            dispatch(new UpdateNewsCount($n_id));
        } catch (\Exception $e) {
        }

        $banner_desktop = Cache::get('desktop-details-banner');
        $banner_mobile = Cache::get('mobile-details-banner');

        $latest = Cache::get('latest');
        $most_read = Cache::get('most_read');

        $details = Cache::flexible('details-' . $n_id, [300, 600], function () use ($n_id) {
            return queryHelpers::query_DetailsNews($n_id);
        });


        if (!isset($details) || $HTTP_auth == 0) {
            $details = ['n_id' => $n_id, 'n_solder' => '', 'n_head' => '', 'n_subhead' => '', 'news_tags' => '', 'n_author' => '', 'n_writer' => '', 'n_reporter' => '', 'n_details' => '', 'n_category' => '', 'main_image' => '', 'watermark' => '', 'n_caption' => '', 'category_lead' => '', 'home_lead' => '', 'highlight_items' => '', 'focus_items' => '', 'instant_articles' => '', 'ticker_news' => '', 'home_category' => '', 'title_info' => '', 'meta_keyword' => '', 'meta_description' => '', 'embedded_code' => '', 'main_video' => '', 'most_read' => '', 'divisions' => '', 'districts' => '', 'upazilas' => '', 'n_status' => '', 'n_order' => '', 'home_cat_order' => '', 'leadnews_order' => '', 'highlight_order' => '', 'focus_order' => '', 'edition' => '', 'n_date' => '', 'start_at' => '', 'end_at' => '', 'edit_at' => '', 'created_by' => '', 'updated_by' => '', 'created_at' => '', 'updated_at' => '', 'deleted_by' => '', 'deleted_at' => '', 'restore_by' => '', 'openGraphImg' => '', 'datePublished' => '', 'dateModified' => '', 'date_at' => '', 'writers_img' => '', 'writers_name' => '', 'f_date' => '', 'cat_name' => [], 'get_writers' => ''];

            return response()->json(
                [
                    'banner_desktop' => $banner_desktop,
                    'banner_mobile' => $banner_mobile,
                    'details' => $details,
                    // 'news_tags' => [],
                    'latest' => $latest,
                    'most_read' => $most_read,
                    'related' => [],
                    'more_news' => [],
                    'live_news_list' => [],
                ],
                200,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                JSON_INVALID_UTF8_SUBSTITUTE
            );
        }

        if ($details->is_live == 1) {
            $liveNewsList = Cache::flexible('live-news-' . $n_id, [600, 600], function () use ($n_id) {
                return queryHelpers::query_DetailsLiveNews($n_id);
            });
        } else {
            $liveNewsList = [];
        }

        // if($details->news_tags!=''){
        //     $tag_id = $details->news_tags;
        //     $news_tags = Cache::flexible('news_tags-'.$tag_id, [505,505], function() use($tag_id, $n_id){
        //         $sql = News::select('n_id','n_head','n_category','edition','main_image','start_at','created_at','deleted_at')->isActive()->with('newsTag')->where('news_tags',$tag_id)->where('n_id','!=',$n_id)->limit(29)->orderBy('start_at', 'desc')->get();

        //         $sql->transform(function ($row, $key) {
        //             $row->f_date = date("Y/m/d", strtotime($row->start_at));
        //             return $row;
        //         });
        //         return $sql;
        //     });
        // }else{
        //     $news_tags = [];
        // }

        if ($details->meta_keyword != '') {
            $get_keyword = $details->meta_keyword;
            $related = Cache::flexible($details->meta_keyword . '-meta_keyword', [400, 600], function () use ($get_keyword, $n_id) {
                return queryHelpers::query_MetaKeywordNews($get_keyword, $n_id);
            });
        } else {
            $related = '';
        }

        $cat = $details->n_category;
        $more = Cache::flexible($cat . '-' . $n_id . '-more', [400, 600], function () use ($cat, $n_id) {
            return queryHelpers::query_DetailsMoreNews($cat, $n_id);
        });


        // print_r($more);exit;
        return response()->json(
            [
                'banner_desktop' => $banner_desktop,
                'banner_mobile' => $banner_mobile,
                'details' => $details,
                // 'news_tags' => $news_tags,
                'latest' => $latest,
                'most_read' => $most_read,
                'related' => $related,
                'more_news' => $more,
                'live_news_list' => $liveNewsList,
            ],
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );

        /*return response()->json([
            'banner' => json_decode(json_encode($banner, JSON_INVALID_UTF8_SUBSTITUTE)),
            'details' => json_decode(json_encode($details, JSON_INVALID_UTF8_SUBSTITUTE)),
            'news_tags' => json_decode(json_encode($news_tags, JSON_INVALID_UTF8_SUBSTITUTE)),
            'latest' => json_decode(json_encode($latest, JSON_INVALID_UTF8_SUBSTITUTE)),
            'most_read' => json_decode(json_encode($most_read, JSON_INVALID_UTF8_SUBSTITUTE)),
            'related' => json_decode(json_encode($related, JSON_INVALID_UTF8_SUBSTITUTE)),
            'more_news' => json_decode(json_encode($more, JSON_INVALID_UTF8_SUBSTITUTE)),
        ]);*/
    }

    public function hit(Request $request)
    {
        $n_id = $request->input('n_id');
        try {
            // News::findNewsTable($n_id)->where('n_id',$n_id)->increment('most_read', 1);
            dispatch(new UpdateNewsCount($n_id));
            return $n_id;
        } catch (\Exception $e) {
        }
    }

    public function printnews($n_id = '')
    {
        if ($n_id) {
            $getnewsby_id = Cache::remember('Printdetails-' . $n_id, 505, function () use ($n_id) {
                return News::findNewsTable($n_id)->with('catName')->isActive()->find($n_id);
            });

            return view('desktop.print_news', compact('getnewsby_id'));
        }
    }

    public function epaper($date, $page = 1)
    {
        $ticker = Cache::remember('ticker', 502, function () {
            return News::isActive()->select('n_id', 'n_head', 'edition', 'start_at', 'deleted_at')->where('ticker_news', 1)->orderBy('n_id', 'desc')->limit(20)->get();
        });

        $page = Paper::isActive()->where('p_date', $date)->where('page', $page)->first();
        $todaysPaper = Paper::isActive()->where('p_date', $date)->get();

        return view('desktop.epaper', compact('ticker', 'page', 'date', 'todaysPaper'));
    }

    public function epaperView(Request $request)
    {
        $pageid = $request->input('pageid');
        $tagid = $request->input('tagid');
        $pdate = $request->input('pdate');

        $img = "page-" . $pageid . "-tag-" . $tagid . ".jpg";

        $LinkBetweenNews = LinkBetweenNews::where('p_date', $pdate)->where(function ($query) use ($img) {
            $query->where('head_img', $img)->orWhere('tail_img', $img);
        })->first();

        $details = '';
        if ($LinkBetweenNews && $LinkBetweenNews->n_id != '') {
            $n_id = $LinkBetweenNews->n_id;
            $details = Cache::remember('details-' . $n_id, 505, function () use ($n_id) {
                return News::findNewsTable($n_id)->with('catName')->isActive()->find($n_id);
            });
        }

        $compiled = view('desktop.inc.epaper-view', compact('LinkBetweenNews', 'pageid', 'tagid', 'pdate', 'details'))->render();

        return response()->json(
            [
                'success' => 'success',
                'compiled' => $compiled,
            ],
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }

    public function multimediaDetails(Request $request, $n_id)
    {
        try {
            dispatch(new UpdateNewsCount($n_id));
        } catch (\Exception $e) {
        }

        $banner_desktop = Cache::get('desktop-details-banner');
        $banner_mobile = Cache::get('mobile-details-banner');


        $details = Cache::flexible('details-' . $n_id, [300, 600], function () use ($n_id) {
            return queryHelpers::query_DetailsNews($n_id);
        });

        $getCat = $details->n_category;

        $more = Cache::flexible('multimediaMore-' . $n_id, [400, 600], function () use ($n_id, $getCat) {
            $sql = News::select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'main_video', 'start_at', 'created_at', 'deleted_at')->isActive()->with('catName')->where('n_id', '!=', $n_id)->where('n_category', $getCat)->orderBy('n_id', 'desc')->limit(8)->get();

            $sql->transform(function ($row, $key) {
                $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                $row->date_at = generalHelper::bn_date(date("d F, Y", strtotime($row->start_at)));
                return $row;
            });
            return $sql;
        });

        return response()->json(
            [
                'banner_desktop' => $banner_desktop,
                'banner_mobile' => $banner_mobile,
                'details' => $details,
                'more' => $more,
            ],
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }
}
