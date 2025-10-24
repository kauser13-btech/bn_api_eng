<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

// use Jenssegers\Agent\Agent;
use Carbon\Carbon;
use App\Models\Pool;
use App\Models\Menu;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Astrology;
use App\Models\BreakingNews;
use App\Models\PrintSettings;
use App\Models\Miscellaneous;
use App\Helpers\generalHelper;
use App\Helpers\ImageStoreHelpers;
use App\Helpers\customCalendar;
use App\Helpers\queryHelpers;
use App\Models\Quiz;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $banner_desktop = Cache::get('desktop-home-banner');
        $banner_mobile = Cache::get('mobile-home-banner');

        $leadNews = Cache::get('leadNews');

        $leadLiveNews = Cache::get('leadLiveNews');

        $highlight = Cache::get('highlight');

        // $focusitems = Cache::get('focusitems');
        // $pin_news = Cache::get('pin_news');
        // $pin_Live_news = Cache::get('pinLiveNews');

        $latest = Cache::get('latest');

        $most_read = Cache::get('most_read');

        $homeCat_1 = Cache::get('homeCat_1');
        $homeCat_2 = Cache::get('homeCat_2');
        $homeCat_14 = Cache::get('homeCat_14');
        $homeCat_4 = Cache::get('homeCat_4');
        $homeCat_3 = Cache::get('homeCat_3');
        $homeCat_5 = Cache::get('homeCat_5');
        $homeCat_6 = Cache::get('homeCat_6');
        $homeCat_1208 = Cache::get('homeCat_1208');


        $special_video = Cache::get('special_video');
        $home_videoSlide = Cache::get('home_videoSlide');


        return response()->json(
            [
                'banner_desktop' => $banner_desktop,
                'banner_mobile' => $banner_mobile,
                'leadNews' => $leadNews,
                'leadLiveNews' => $leadLiveNews,
                'special_video' => $special_video,
                'home_videoSlide' => $home_videoSlide,
                'highlight' => $highlight,
                // 'focusitems' => $focusitems,
                // 'pin_news' => $pin_news,
                // 'pin_Live_news' => $pin_Live_news,
                'latest' => $latest,
                'most_read' => $most_read,
                'homeCat_1' => $homeCat_1,
                'homeCat_2' => $homeCat_2,
                'homeCat_14' => $homeCat_14,
                'homeCat_4' => $homeCat_4,
                'homeCat_3' => $homeCat_3,
                'homeCat_5' => $homeCat_5,
                'homeCat_6' => $homeCat_6,
                'homeCat_1208' => $homeCat_1208,
            ],
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }

    public function index2()
    {
        $homeCat_1253 = Cache::get('homeCat_1253');
        $homeCat_14 = Cache::get('homeCat_14');
        $homeCat_12 = Cache::get('homeCat_12');
        $homeCat_20 = Cache::get('homeCat_20');
        $homeCat_19 = Cache::get('homeCat_19');
        $homeCat_7 = Cache::get('homeCat_7');
        $homeCat_9 = Cache::get('homeCat_9');
        $homeCat_15 = Cache::get('homeCat_15');
        $homeCat_11 = Cache::get('homeCat_11');
        $homeCat_16  = Cache::get('homeCat_16 ');
        
        return response()->json(
            [
                'homeCat_1253' => $homeCat_1253,
                'homeCat_14' => $homeCat_14,
                'homeCat_12' => $homeCat_12,
                'homeCat_20' => $homeCat_20,
                'homeCat_19' => $homeCat_19,
                'homeCat_7' => $homeCat_7,
                'homeCat_9' => $homeCat_9,
                'homeCat_15' => $homeCat_15,
                'homeCat_11' => $homeCat_11,
                'homeCat_16' => $homeCat_16,
            ],
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }

    public function homePhotoGallery()
    {
        $photo_gallery = Cache::get('homePhotoGallery');
        return response()->json(
            $photo_gallery,
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }

    public function homeVideoGallery()
    {
        $photo_gallery = Cache::get('homeVideoGallery');
        return response()->json(
            $photo_gallery,
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }

    public function specialTagNews()
    {
        $special_tag_news = Cache::get('special_tag_news');
        return response()->json(
            $special_tag_news,
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }



    public function pools()
    {
        $banner_desktop = Cache::get('desktop-home-banner');
        $banner_mobile = Cache::get('mobile-home-banner');

        $pool = Cache::get('homePool');

        $old_pool = Cache::remember('old_pool', 120, function () {
            $sql = Pool::active()->orderBy('id', 'desc')->limit(5)->get();
            $sql->transform(function ($row, $key) {
                $total_vot = ($row->vote_1 + $row->vote_2 + $row->vote_3);
                $row->vote_1_per = ($row->vote_1 != 0) ? round(($row->vote_1 / $total_vot) * 100) : 0;
                $row->vote_2_per = ($row->vote_2 != 0) ? round(($row->vote_2 / $total_vot) * 100) : 0;
                $row->vote_3_per = ($row->vote_3 != 0) ? round(($row->vote_3 / $total_vot) * 100) : 0;
                return $row;
            });

            return $sql;
        });

        return response()->json(
            [
                'banner_desktop' => $banner_desktop,
                'banner_mobile' => $banner_mobile,
                'pool' => $pool,
                'old_pool' => $old_pool,
            ],
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }

    public function webnavs()
    {
        $nav = Cache::rememberForever('nav', function () {
            $menu = Menu::where('m_edition', 'online')->where('m_status', 1)->where('m_visible', 1)->where('m_parent', 0)->orderBy('m_order', 'ASC')->get()->toArray();
            $i = 0;
            $nav = [];
            foreach ($menu as $row) {
                $parent = [];
                $parent['m_id'] = $row['m_id'];
                $parent['m_name'] = $row['m_name'];
                $parent['slug'] = $row['slug'];
                // $parent['child'] = [];

                $submenu = Menu::where('m_edition', 'online')->where('m_parent', $row['m_id'])->where('m_status', 1)->where('m_visible', 1)->orderBy('m_order', 'ASC')->get()->toArray();

                if (count($submenu) != 0) {
                    $child = [];
                    foreach ($submenu as $value) {
                        $child['m_id'] = $value['m_id'];
                        $child['m_name'] = $value['m_name'];
                        $child['slug'] = $value['slug'];
                        $parent['child'][] = $child;
                    }
                } else {
                    $parent['child'] = [];
                }

                $nav[] = $parent;
            }
            return $nav;
        });

        $multimediaMenu = Cache::rememberForever('multimediaMenu', function () {
            return Menu::where('m_status', 1)->where('m_visible', 1)->where('m_edition', 'multimedia')->where('slug', '!=', '#')->orderBy('m_order', 'desc')->get()->toArray();
        });

        return response()->json(
            [
                'nav' => $nav,
                'multimediaMenu' => $multimediaMenu,
            ],
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }

    public function archive($arcDate)
    {
        $currentPage = 'archive-' . $arcDate;
        $sql = Cache::remember($currentPage, 300, function () use ($arcDate) {
            // $sql = Menu::select('m_id','m_name','slug')->where('m_edition','print')->orderBy('m_id', 'ASC')
            //     ->with('getNews', function($q) use($arcDate) {
            //         $q->newsTable(date("Y", strtotime($arcDate)))->isActive()->select('n_id','n_head','main_image','start_at','created_at','n_category','deleted_at','edition')->where('n_date',$arcDate)->orderBy('n_id', 'ASC');
            //     })->get();

            // $sql->transform(function ($row, $key) {
            //     if ( isset($row['getNews'][0]) ) {
            //         $row->main_image = ImageStoreHelpers::showImage('news_images',$row['getNews'][0]['created_at'],$row['getNews'][0]['main_image'],'thumbnail');
            //     }else{
            //         $row->main_image = ImageStoreHelpers::showImage('news_images','','','thumbnail');
            //     }
            //     return $row;
            // });
            // return $sql;

            $print_nav = News::newsTable(date("Y", strtotime($arcDate)))->isActive()->select('n_category')->isActive()->where('edition', 'print')->where('n_date', $arcDate)->with('catName')->groupBy('n_category')->orderBy('n_category', 'ASC')->get()->toArray();

            sort($print_nav);

            // $print_nav = Menu::select('m_id')->where('m_edition','print')->orderBy('m_id', 'ASC')->get()->toArray();
            $data = [];
            foreach ($print_nav as $nav) {
                $arr = [];
                $arr['m_id'] = $nav['cat_name']['m_id'];
                $arr['m_name'] = $nav['cat_name']['m_name'];
                $arr['slug'] = $nav['cat_name']['slug'];
                $arr['get_news'] = News::newsTable(date("Y", strtotime($arcDate)))->isActive()->select('n_id', 'n_head', 'main_image', 'start_at', 'created_at', 'n_category', 'deleted_at', 'edition')->where('n_category', $nav['cat_name']['m_id'])->where('n_date', $arcDate)->orderBy('n_id', 'ASC')->get();

                $arr['get_news']->transform(function ($row, $key) {
                    $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
                    $row->n_head = strip_tags(html_entity_decode($row->n_head));
                    $row->f_date = date("Y/m/d", strtotime($row->start_at));
                    return $row;
                });

                if (count($arr['get_news']) > 0) {
                    $data[] = $arr;
                }
            }
            return $data;
        });

        return response()->json(
            [
                'archiveNews' => $sql,
            ],
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }

    public function todayDate()
    {
        if (date('H:I' > '00:00') && date('H:I' > '00:02')) {
            Cache::forget('todayDate');
        }

        $todayDate = Cache::rememberForever('todayDate', function () {
            // return response()->json(customCalendar::fFormatDateEn2Bn());
            return response()->json(customCalendar::fFormatDateEn2Bn() . customCalendar::hijri());
        });

        return $todayDate;
    }

    public function stockMarquee()
    {
        $compiled = Cache::remember('stockMarquee', 250, function () {
            return view('dse.data_dump')->render();
        });

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

    public function multimedia()
    {
        $banner_desktop = Cache::get('desktop-home-banner');
        $banner_mobile = Cache::get('mobile-home-banner');

        $multimediaMenu = Cache::rememberForever('multimediaMenu', function () {
            return Menu::where('m_status', 1)->where('m_visible', 1)->where('m_edition', 'multimedia')->where('slug', '!=', '#')->orderBy('m_order', 'desc')->get()->toArray();
        });

        $media = Cache::flexible('multimediaPageHome', [300, 600], function () use ($multimediaMenu) {
            $multimediaNews = [];
            foreach ($multimediaMenu as $row) {
                $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'main_image', 'start_at', 'created_at', 'deleted_at', 'n_date')->with('catName')->where('n_category', $row['m_id'])->orderBy('n_order', 'desc')->limit(5)->get();

                $sql->transform(function ($row, $key) {
                    $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
                    $row->f_date = date("Y/m/d", strtotime($row->start_at));
                    $row->date_at = generalHelper::time_elapsed_string($row->start_at);
                    return $row;
                });
                $data['m_name'] = $row['m_name'];
                $data['slug'] = $row['slug'];
                $data['news'] = $sql;
                $multimediaNews[] = $data;
            }
            return $multimediaNews;
        });

        $idCats = array_column($multimediaMenu, 'm_id');

        $latestMedia = Cache::flexible('multimediaLatestMedia', [300, 600], function () use ($idCats) {
            $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'main_image', 'start_at', 'created_at', 'deleted_at', 'n_date')->with('catName')->whereIn('n_category', $idCats)->orderBy('n_order', 'desc')->limit(3)->get();
            $sql->transform(function ($row, $key) {
                $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                $row->date_at = generalHelper::time_elapsed_string($row->start_at);
                return $row;
            });
            return $sql;
        });

        return response()->json(
            [
                'banner_desktop' => $banner_desktop,
                'banner_mobile' => $banner_mobile,
                'latestMedia' => $latestMedia,
                'media' => $media,
            ],
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }

    public function tagNews($tag)
    {
        $news = Cache::flexible('tagNews-' . $tag, [300, 600], function () use ($tag) {
            return queryHelpers::query_RecentNews($tag);
        });

        return response()->json($news);
    }
}
