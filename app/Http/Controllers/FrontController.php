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

class FrontController extends Controller
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

        $focusitems = Cache::get('focusitems');

        $pin_news = Cache::get('pin_news');

        $pin_Live_news = Cache::get('pinLiveNews');

        $latest = Cache::get('latest');

        $most_read = Cache::get('most_read');

        $homeCat_1 = Cache::get('homeCat_1');

        $homeCat_2 = Cache::get('homeCat_2');

        $homeCat_8 = Cache::get('homeCat_8');

        $homeCat_55 = Cache::get('homeCat_55');

        $homeCat_16 = Cache::get('homeCat_16');

        $homeCat_13 = Cache::get('homeCat_13');

        $homeCat_5 = Cache::get('homeCat_5');

        $homeCat_15 = Cache::get('homeCat_15');

        $homeCat_54 = Cache::get('homeCat_54');

        $homeCat_469 = Cache::get('homeCat_469');

        $homeCat_279 = Cache::get('homeCat_279');

        $homeCat_502 = Cache::get('homeCat_502');

        $homeCat_32 = Cache::get('homeCat_32');

        $photo_gallery = Cache::get('gallery_1');

        $multimedia = Cache::get('multimediaHome');

        $special_video = Cache::get('special_video');

        return response()->json(
            [
                'banner_desktop' => $banner_desktop,
                'banner_mobile' => $banner_mobile,
                'leadNews' => $leadNews,
                'leadLiveNews' => $leadLiveNews,
                'special_video' => $special_video,
                'highlight' => $highlight,
                'focusitems' => $focusitems,
                'pin_news' => $pin_news,
                'pin_Live_news' => $pin_Live_news,
                'latest' => $latest,
                'most_read' => $most_read,
                'homeCat_1' => $homeCat_1,
                'homeCat_2' => $homeCat_2,
                'homeCat_8' => $homeCat_8,
                'homeCat_55' => $homeCat_55,
                'homeCat_16' => $homeCat_16,
                'homeCat_13' => $homeCat_13,
                'homeCat_5' => $homeCat_5,
                'homeCat_15' => $homeCat_15,
                'homeCat_54' => $homeCat_54,
                'homeCat_469' => $homeCat_469,
                'homeCat_279' => $homeCat_279,
                'homeCat_32' => $homeCat_32,
                'homeCat_502' => $homeCat_502,
                'multimedia' => $multimedia,
                'photo_gallery' => $photo_gallery,
            ],
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function homeLead()
    {
        $banner_desktop = Cache::get('desktop-home-banner');
        $banner_mobile = Cache::get('mobile-home-banner');

        $leadNews = Cache::get('leadNews');

        $leadLiveNews = Cache::get('leadLiveNews');

        $highlight = Cache::get('highlight');

        $focusitems = Cache::get('focusitems');

        $pin_news = Cache::get('pin_news');

        $pin_Live_news = Cache::get('pinLiveNews');

        return response()->json(
            [
                'banner_desktop' => $banner_desktop,
                'banner_mobile' => $banner_mobile,
                'leadNews' => $leadNews,
                'leadLiveNews' => $leadLiveNews,
                'highlight' => $highlight,
                'focusitems' => $focusitems,
                'pin_news' => $pin_news,
                'pin_Live_news' => $pin_Live_news,
            ],
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function homeLatest()
    {
        $latest = Cache::get('latest');

        return response()->json(
            [
                'latest' => $latest,
            ],
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function homeMostRead()
    {
        $most_read = Cache::get('most_read');

        return response()->json(
            [
                'most_read' => $most_read,
            ],
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function homeMultimedia()
    {
        $multimedia = Cache::get('multimediaHome');

        return response()->json(
            [
                'multimedia' => $multimedia,
            ],
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function homeGallery()
    {
        $photo_gallery = Cache::get('gallery_1');

        $special_video = Cache::get('special_video');

        return response()->json(
            [
                'photo_gallery' => $photo_gallery,
                'special_video' => $special_video,
            ],
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function homeCatNews($cat_id)
    {
        $homeCatNews = Cache::get('homeCat_'.$cat_id);

        return response()->json(
            [
                'homeCat_'.$cat_id => $homeCatNews,
            ],
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

    public function countDown()
    {
        $schedule = [
            '2023-03-23' => [
                'sehri' => '4:39',
                'iftar' => '18:14',
            ],
            '2023-03-24' => [
                'sehri' => '4:39',
                'iftar' => '18:14',
            ],
            '2023-03-25' => [
                'sehri' => '4:38',
                'iftar' => '18:15',
            ],
            '2023-03-26' => [
                'sehri' => '4:36',
                'iftar' => '18:15',
            ],
            '2023-03-27' => [
                'sehri' => '4:35',
                'iftar' => '18:16',
            ],
            '2023-03-28' => [
                'sehri' => '4:34',
                'iftar' => '18:16',
            ],
            '2023-03-29' => [
                'sehri' => '4:33',
                'iftar' => '18:17',
            ],
            '2023-03-30' => [
                'sehri' => '4:31',
                'iftar' => '18:17',
            ],
            '2023-03-31' => [
                'sehri' => '4:30',
                'iftar' => '18:18',
            ],
            '2023-04-01' => [
                'sehri' => '4:29',
                'iftar' => '18:18',
            ],
            '2023-04-02' => [
                'sehri' => '4:28',
                'iftar' => '18:19',
            ],
            '2023-04-03' => [
                'sehri' => '4:27',
                'iftar' => '18:19',
            ],
            '2023-04-04' => [
                'sehri' => '4:26',
                'iftar' => '18:19',
            ],
            '2023-04-05' => [
                'sehri' => '4:24',
                'iftar' => '18:20',
            ],
            '2023-04-06' => [
                'sehri' => '4:24',
                'iftar' => '18:20',
            ],
            '2023-04-07' => [
                'sehri' => '4:23',
                'iftar' => '18:21',
            ],
            '2023-04-08' => [
                'sehri' => '4:22',
                'iftar' => '18:21',
            ],
            '2023-04-09' => [
                'sehri' => '4:21',
                'iftar' => '18:21',
            ],
            '2023-04-10' => [
                'sehri' => '4:20',
                'iftar' => '18:22',
            ],
            '2023-04-11' => [
                'sehri' => '4:19',
                'iftar' => '18:22',
            ],
            '2023-04-12' => [
                'sehri' => '4:18',
                'iftar' => '18:23',
            ],
            '2023-04-13' => [
                'sehri' => '4:17',
                'iftar' => '18:23',
            ],
            '2023-04-14' => [
                'sehri' => '4:15',
                'iftar' => '18:23',
            ],
            '2023-04-15' => [
                'sehri' => '4:14',
                'iftar' => '18:24',
            ],
            '2023-04-16' => [
                'sehri' => '4:13',
                'iftar' => '18:24',
            ],
            '2023-04-17' => [
                'sehri' => '4:12',
                'iftar' => '18:24',
            ],
            '2023-04-18' => [
                'sehri' => '4:11',
                'iftar' => '18:25',
            ],
            '2023-04-19' => [
                'sehri' => '4:10',
                'iftar' => '18:25',
            ],
            '2023-04-20' => [
                'sehri' => '4:09',
                'iftar' => '18:26',
            ],
            '2023-04-21' => [
                'sehri' => '4:08',
                'iftar' => '18:26',
            ],
            '2023-04-22' => [
                'sehri' => '4:07',
                'iftar' => '18:27',
            ],
        ];
        $countDown = [];
        $today = date('Y-m-d');
        if (array_key_exists($today, $schedule)) {
            $todaySchedule = $schedule[$today];
            $sehriCount = date('Y-m-d H:i:s', strtotime($today . ' ' . $todaySchedule['sehri'] . ':00'));
            $iftarCount = date('Y-m-d H:i:s', strtotime($today . ' ' . $todaySchedule['iftar'] . ':00'));
            if ($sehriCount > date('Y-m-d H:i:s')) {
                // sehri
                $countDown['image_desktop'] = 'https://asset.banglanews24.com/files/shares/ads/sehri-Iftar-countdown/Saheri-desktop.jpg';
                $countDown['image_mobile'] = 'https://asset.banglanews24.com/files/shares/ads/sehri-Iftar-countdown/Saheri-mobile.jpg';
                $countDown['sehri'] = generalHelper::bn_date($todaySchedule['sehri']);
                $countDown['iftar'] = generalHelper::bn_date(date('g:i', strtotime($todaySchedule['iftar'])));
                $countDown['countDown'] = date('M j, Y G:i:s', strtotime($sehriCount));
            } elseif ($iftarCount > date('Y-m-d H:i:s')) {
                // iftar
                $countDown['image_desktop'] = 'https://asset.banglanews24.com/files/shares/ads/sehri-Iftar-countdown/Iftar-desktop.jpg';
                $countDown['image_mobile'] = 'https://asset.banglanews24.com/files/shares/ads/sehri-Iftar-countdown/Iftar-mobile.jpg';
                $countDown['sehri'] = generalHelper::bn_date($todaySchedule['sehri']);
                $countDown['iftar'] = generalHelper::bn_date(date('g:i', strtotime($todaySchedule['iftar'])));
                $countDown['countDown'] = date('M j, Y G:i:s', strtotime($iftarCount));
            } else {
                // sehri Next day
                $today = date('Y-m-d', strtotime(' +1 day'));
                if (array_key_exists($today, $schedule)) {
                    $todaySchedule = $schedule[$today];
                    $sehriCount = date('Y-m-d H:i:s', strtotime($today . ' ' . $todaySchedule['sehri'] . ':00'));
                    $iftarCount = date('Y-m-d H:i:s', strtotime($today . ' ' . $todaySchedule['iftar'] . ':00'));
                    if ($sehriCount > date('Y-m-d H:i:s')) {
                        $countDown['image_desktop'] = 'https://asset.banglanews24.com/files/shares/ads/sehri-Iftar-countdown/Saheri-desktop.jpg';
                        $countDown['image_mobile'] = 'https://asset.banglanews24.com/files/shares/ads/sehri-Iftar-countdown/Saheri-mobile.jpg';
                        $countDown['sehri'] = generalHelper::bn_date($todaySchedule['sehri']);
                        $countDown['iftar'] = generalHelper::bn_date(date('g:i', strtotime($todaySchedule['iftar'])));
                        $countDown['countDown'] = date('M j, Y G:i:s', strtotime($sehriCount));
                    }
                } else {
                    return response()->json([
                        'status' => 0,
                        'countDownData' => [],
                    ]);
                }
            }
        } else {
            return response()->json([
                'status' => 0,
                'countDownData' => [],
            ]);
        }



        return response()->json([
            'status' => 1,
            'countDownData' => $countDown,
        ]);
    }

    // $related = Post::whereHas('tags', function ($q) use ($post) {
    // return $q->whereIn('name', $post->tags->pluck('name'));
    // })
    // ->where('id', '!=', $post->id) // So you won't fetch same post
    // ->get();


    public function top10News()
    {
        $banner_desktop = Cache::remember('desktop-home-banner', 300, function () {
            return queryHelpers::query_Banner('desktop', 'home');
        });

        $banner_mobile = Cache::remember('mobile-home-banner', 300, function () {
            return queryHelpers::query_Banner('mobile', 'home');
        });

        $top10News = Cache::remember('top10News', 300, function () {
            return queryHelpers::query_Top10News();
        });

        $latest = Cache::remember('latest', 503, function () {
            return queryHelpers::query_LatestNews();
        });

        return response()->json(
            [
                'banner_desktop' => $banner_desktop,
                'banner_mobile' => $banner_mobile,
                'top_news' => $top10News,
                'latest' => $latest,
            ],
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }

    public function todaysQuiz()
    {
        $quiz = generalHelper::getTodaysQuize();
        return response()->json([
            'quiz' => $quiz,
        ]);
    }


    public function quizAdd(Request $request)
    {
        $today = Date('d-m-Y');
        $checkQuiz = Quiz::where('q_index', $today)->where('mobile', trim($request->input('mobile')))->first();

        if ($checkQuiz) {
            $status = 0;
        } else {
            Quiz::create([
                'q_index' => $today,
                'q_status' => generalHelper::checkQuiz($request->input('answer')),
                'name' => htmlentities($request->input('name')),
                'mobile' => $request->input('mobile'),
                'email' => $request->input('email'),
                'division' => $request->input('division'),
                'district' => $request->input('district'),
                'address' => htmlentities($request->input('address')),
            ]);
            $status = 1;
        }


        return response()->json([
            'status' => $status,
            'msg' => 'Thank you',
        ]);
    }

    public function tagNews($tag)
    {
        $news = Cache::flexible('tagNews-' . $tag, [300, 600], function () use ($tag) {
            return queryHelpers::query_RecentNews($tag);
        });

        return response()->json($news);
    }
}
