<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
use App\Helpers\generalHelper;
use App\Helpers\ImageStoreHelpers;
use App\Helpers\customCalendar;
use Exception;

class MakeCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:homecache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private function cacheLeadews()
    {
        try {
            $sql = News::isActive()->select('n_id', 'n_head', 'edition', 'n_details', 'main_image', 'start_at', 'created_at', 'n_category', 'deleted_at')->with('catName')->where('home_lead', 1)->orderBy('leadnews_order', 'desc')->limit(5)->get();

            $sql->transform(function ($row, $key) {
                $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
                $row->n_details = generalHelper::splitText($row->n_details, 400);
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });
            Cache::put('leadNews', $sql);
            \Log::info("Lead Done");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }


    private function cacheHighlight()
    {
        try {
            $sql = News::isActive()->select('n_id', 'n_head', 'edition', 'n_details', 'main_image', 'start_at', 'created_at', 'deleted_at', 'n_category')->with('catName')->where('highlight_items', 1)->orderBy('highlight_order', 'desc')->limit(14)->get();

            $sql->transform(function ($row, $key) {
                $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
                $row->n_details = generalHelper::splitText($row->n_details, 400);
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });
            Cache::put('highlight', $sql);

            \Log::info("Hightlight Done");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }


    private function cacheMostRead()
    {
        try {

            $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'start_at', 'created_at', 'deleted_at')->with('catName')->where('n_date', '>=', Carbon::now()->subDays(1))->orderBy('most_read', 'desc')->limit(30)->get();

            $sql->transform(function ($row, $key) {
                $row->date_at = generalHelper::time_elapsed_string($row->start_at);
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });


            Cache::put('most_read', $sql);

            \Log::info("Most Read Done");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }


    private function cacheFocus()
    {
        try {

            $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'n_details', 'main_image', 'start_at', 'created_at', 'deleted_at')->with('catName')->where('focus_items', 1)->orderBy('focus_order', 'desc')->first();
            $sql->main_image = ImageStoreHelpers::showImage('news_images', $sql->created_at, $sql->main_image, 'thumbnail');
            $sql->n_details = generalHelper::splitText($sql->n_details, 400);
            $sql->f_date = date("Y/m/d", strtotime($sql->start_at));


            Cache::put('focusitems', $sql);

            \Log::info("focusitems");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }



    private function cacheLatest()
    {
        try {

            $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'start_at', 'is_latest', 'deleted_at')->with('catName')->where('is_latest', 1)->orderBy('start_at', 'desc')->limit(30)->get();

            $sql->transform(function ($row, $key) {
                $row->date_at = generalHelper::time_elapsed_string($row->start_at);
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });

            Cache::put('latest', $sql);

            \Log::info("latest");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }


    private function bestOfeek()
    {
        try {
            $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'start_at', 'created_at', 'deleted_at')->with('catName')->where('n_date', '>=', Carbon::now()->subDays(7))->orderBy('most_read', 'desc')->limit(30)->get();

            $sql->transform(function ($row, $key) {
                $row->date_at = generalHelper::time_elapsed_string($row->start_at);
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });

            Cache::put('best_of_week', $sql);

            \Log::info("best_of_week");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }


    private function homeCat_8()
    {
        try {


            $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'start_at', 'created_at', 'deleted_at', 'n_details')->with('catName')->where('n_category', 8)->orderBy('home_cat_order', 'desc')->limit(11)->get();

            $sql->transform(function ($row, $key) {
                $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
                $row->n_details = generalHelper::splitText($row->n_details, 400);
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });
            return $sql;

            Cache::put('homeCat_8', $sql);

            \Log::info("homeCat_8");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }



    private function homeCat_55()
    {
        try {


            $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'start_at', 'created_at', 'deleted_at', 'n_details')->with('catName')->where('n_category', 55)->orderBy('home_cat_order', 'desc')->limit(11)->get();

            $sql->transform(function ($row, $key) {
                $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
                $row->n_details = generalHelper::splitText($row->n_details, 400);
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });
            Cache::put('homeCat_55', $sql);

            \Log::info("homeCat_55");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }



    private function homeCat_16()
    {
        try {
            $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'start_at', 'created_at', 'deleted_at', 'n_details')->with('catName')->where('n_category', 16)->orderBy('home_cat_order', 'desc')->limit(8)->get();

            $sql->transform(function ($row, $key) {
                $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
                $row->n_details = generalHelper::splitText($row->n_details, 400);
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });

            Cache::put('homeCat_16', $sql);

            \Log::info("homeCat_16");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }


    private function homeCat_13()
    {
        try {
            $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'start_at', 'created_at', 'deleted_at', 'n_details')->with('catName')->where('n_category', 13)->orderBy('home_cat_order', 'desc')->limit(10)->get();

            $sql->transform(function ($row, $key) {
                $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
                $row->n_details = generalHelper::splitText($row->n_details, 400);
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });

            Cache::put('homeCat_13', $sql);

            \Log::info("homeCat_13");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }


    private function homeCat_5()
    {
        try {
            $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'start_at', 'created_at', 'deleted_at', 'n_details')->with('catName')->where('n_category', 5)->orderBy('home_cat_order', 'desc')->limit(12)->get();

            $sql->transform(function ($row, $key) {
                $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
                $row->n_details = generalHelper::splitText($row->n_details, 400);
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });

            Cache::put('homeCat_5', $sql);

            \Log::info("homeCat_5");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }



    private function homeCat_15()
    {
        try {
            $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'start_at', 'created_at', 'deleted_at', 'n_details')->with('catName')->where('n_category', 15)->orderBy('home_cat_order', 'desc')->limit(6)->get();

            $sql->transform(function ($row, $key) {
                $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
                $row->n_details = generalHelper::splitText($row->n_details, 400);
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });

            Cache::put('homeCat_15', $sql);

            \Log::info("homeCat_15");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }


    private function homeCat_54()
    {
        try {

            $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'start_at', 'created_at', 'deleted_at', 'n_details')->with('catName')->where('n_category', 54)->orderBy('home_cat_order', 'desc')->limit(5)->get();

            $sql->transform(function ($row, $key) {
                $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
                $row->n_details = generalHelper::splitText($row->n_details, 700);
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });

            Cache::put('homeCat_54', $sql);

            \Log::info("homeCat_54");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }



    private function homeCat_409()
    {
        try {

            $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'start_at', 'created_at', 'deleted_at', 'n_details')->with('catName')->where('n_category', 409)->orderBy('home_cat_order', 'desc')->limit(9)->get();

            $sql->transform(function ($row, $key) {
                $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
                $row->n_details = generalHelper::splitText($row->n_details, 400);
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });

            Cache::put('homeCat_409', $sql);

            \Log::info("homeCat_409");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }



    private function homeCat_279()
    {
        try {

            $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'start_at', 'created_at', 'deleted_at', 'n_details')->with('catName')->where('n_category', 279)->orderBy('home_cat_order', 'desc')->limit(5)->get();

            $sql->transform(function ($row, $key) {
                $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
                $row->n_details = generalHelper::splitText($row->n_details, 400);
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });

            Cache::put('homeCat_279', $sql);

            \Log::info("homeCat_279");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }


    private function homeAstrology()
    {
        try {

            $EPaperPublishDate = generalHelper::getPublishDate('Publish-Print-New-Date');
            $sql = Astrology::isActive()->where('p_status', 1)->where('start_date', $EPaperPublishDate)->orderBy('p_order', 'ASC')->get();

            $sql->transform(function ($row, $key) {
                $row->date_at = generalHelper::bn_date(date("d F, Y", strtotime($row->start_date)));
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });

            Cache::put('homeAstrology', $sql);

            \Log::info("homeAstrology");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }

    private function gallery_1()
    {
        try {
            $sql = Gallery::isActive()->select('id', 'name', 'caption', 'cover_photo', 'type', 'category', 'embed_code', 'start_at', 'status', 'created_at')->where('category', 1)->orderBy('id', 'desc')->limit(5)->get();

            $sql->transform(function ($row, $key) {
                $row->cover_photo = ImageStoreHelpers::showImage('gallery', $row->created_at, $row->cover_photo, 'medium');
                return $row;
            });
            Cache::put('gallery_1', $sql);

            \Log::info("gallery_1");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }



    private function gallery_2()
    {
        try {
            $sql = Gallery::isActive()->select('id', 'name', 'caption', 'cover_photo', 'type', 'category', 'embed_code', 'start_at', 'status', 'created_at')->where('category', 2)->orderBy('id', 'desc')->limit(4)->get();

            $sql->transform(function ($row, $key) {
                $row->cover_photo = ImageStoreHelpers::showImage('gallery', $row->created_at, $row->cover_photo, 'medium');
                return $row;
            });
            Cache::put('gallery_2', $sql);

            \Log::info("gallery_2");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }


    private function homePool()
    {
        try {
            $sql = Gallery::isActive()->select('id', 'name', 'caption', 'cover_photo', 'type', 'category', 'embed_code', 'start_at', 'status', 'created_at')->where('category', 2)->orderBy('id', 'desc')->limit(4)->get();

            $sql->transform(function ($row, $key) {
                $row->cover_photo = ImageStoreHelpers::showImage('gallery', $row->created_at, $row->cover_photo, 'medium');
                return $row;
            });
            Cache::put('homePool', $sql);

            \Log::info("homePool");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }

    private function special_tag()
    {




        try {
            $special_1 = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'news_tags', 'start_at', 'created_at', 'deleted_at')->with('catName')->where('news_tags', 1)->orderBy('home_cat_order', 'desc')->limit(9)->get();
            $special_1->transform(function ($row, $key) {
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });

            $special_2 = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'news_tags', 'start_at', 'created_at', 'deleted_at')->with('catName')->where('news_tags', 2)->orderBy('home_cat_order', 'desc')->limit(9)->get();
            $special_2->transform(function ($row, $key) {
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });

            $special_3 = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'news_tags', 'start_at', 'created_at', 'deleted_at')->with('catName')->where('news_tags', 3)->orderBy('home_cat_order', 'desc')->limit(9)->get();
            $special_3->transform(function ($row, $key) {
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });

            $special_4 = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'news_tags', 'start_at', 'created_at', 'deleted_at')->with('catName')->where('news_tags', 4)->orderBy('home_cat_order', 'desc')->limit(9)->get();
            $special_4->transform(function ($row, $key) {
                $row->f_date = date("Y/m/d", strtotime($row->start_at));
                return $row;
            });

            Cache::put('special_tag', [
                'special_1' => $special_1,
                'special_2' => $special_2,
                'special_3' => $special_3,
                'special_4' => $special_4,
            ]);

            \Log::info("special_tag");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }



    private function banerCache()
    {

        try {

            Cache::put('en-desktop-home-banner', Ads::activeAd()->where('device', 'desktop')->where('page', 'home')->get());
            Cache::put('en-mobile-home-banner', Ads::activeAd()->where('device', 'mobile')->where('page', 'home')->get());
            \Log::info("banerCache");
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
    }


    private function detailbanerCache()
    {

        try {

            Cache::put('desktop-details-banner', Ads::activeAd()->where('device', 'desktop')->where('page', 'details')->get());
            Cache::put('mobile-details-banner', Ads::activeAd()->where('device', 'mobile')->where('page', 'details')->get());
        } catch (Exception $e) {
            // \Log::info("NID = {$n_id}=== {$e->getMessage()}");
        }
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $time1 = time();
        $this->cacheLeadews();
        $this->cacheHighlight();
        $this->cacheMostRead();
        $this->cacheFocus();
        $this->cacheLatest();
        $this->bestOfeek();
        $this->homeCat_8();
        $this->homeCat_16();
        $this->homeCat_55();
        $this->homeCat_13();
        $this->homeCat_5();
        $this->homeCat_15();
        $this->homeCat_54();
        $this->homeCat_409();
        $this->homeCat_279();
        $this->homeAstrology();
        $this->gallery_1();
        $this->gallery_2();
        $this->homePool();
        $this->special_tag();
        $this->banerCache();
        $this->detailbanerCache();
        $time2 = time();
        $seconds_diff =  $time2 -  $time1;
        $time = ($seconds_diff / 3600);
        \Log::info('Time ' . $seconds_diff);
        return Command::SUCCESS;
    }
}



// $banner_desktop = Cache::remember('en-desktop-home-banner', 300, function () {
//     return Ads::activeAd()->where('device','desktop')->where('page','home')->get();
// });
// $banner_mobile = Cache::remember('en-mobile-home-banner', 300, function () {
//     return Ads::activeAd()->where('device','mobile')->where('page','home')->get();
// });