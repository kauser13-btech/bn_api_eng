<?php

namespace App\Helpers;

use App\Models\Ads;
use Carbon\Carbon;
use App\Models\Pool;
use App\Models\Menu;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Astrology;
use App\Models\BreakingNews;
use App\Models\PrintSettings;
use App\Models\Miscellaneous;
use App\Models\Tag;
use App\Helpers\generalHelper;
use App\Helpers\ImageStoreHelpers;
use Illuminate\Support\Facades\URL;

class queryHelpers
{
    public static function query_Banner($device, $page)
    {
        $adSQL = Ads::activeAd()->where('device', $device)->where('page', $page)->orderBy('ad_order', 'ASC')->get();
        $adSQL->transform(function ($row, $key) {
            $row->storage_src = ImageStoreHelpers::showImage('ads_images', $row->created_at, 'folderURL', '');
            return $row;
        });
        return $adSQL;
    }

    public static function query_LeadNews()
    {
        $sql = News::isActive()->select('n_id', 'n_solder', 'n_head', 'edition', 'n_details', 'main_image', 'main_video', 'start_at', 'created_at', 'n_category', 'deleted_at')->with('catName')->where('home_lead', 1)->where('sticky', 0)->orderBy('leadnews_order', 'desc')->limit(13)->get();
        $stickyNews = News::isActive()->select('n_id', 'n_solder', 'n_head', 'edition', 'n_details', 'main_image', 'main_video', 'start_at', 'created_at', 'n_category', 'deleted_at')->with('catName')->where('home_lead', 1)->where('sticky', 1)->orderBy('leadnews_order', 'desc')->limit(13)->get();

        if ($stickyNews) {
            $custom = collect($stickyNews);
            $sql = $custom->merge($sql);
        }

        $sql->transform(function ($row, $key) {
            $row->mob_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'mob');
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
            $row->n_details = generalHelper::splitText($row->n_details, 600);
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });
        return $sql;
    }

    public static function query_AppLeadNews()
    {
        $arr = News::with('catName')->isActive()->select('n_id', 'n_head', 'n_details', 'main_image', 'main_video', 'start_at', 'created_at', 'deleted_at', 'n_category')->where('home_lead', 1)->orderBy('leadnews_order', 'desc')->limit(8)->get()->toArray();
        $return_array = [];
        foreach ($arr as $row) {
            $stor = [];
            $stor['id'] = $row['n_id'];
            $stor['title'] = $row['n_head'];
            $stor['image'] = ImageStoreHelpers::showImage('news_images', $row['created_at'], $row['main_image'], 'thumbnail');
            $stor['datetime'] = $row['start_at'];
            $stor['category'] = $row['n_category'];
            $stor['category_name'] = $row['cat_name']['m_name'];
            $stor['summery'] = generalHelper::splitText($row['n_details'], 300);
            $return_array[] = $stor;
        }
        return $return_array;
    }

    public static function query_Highlight()
    {
        $sql = News::isActive()->select('n_id', 'n_solder', 'n_head', 'edition', 'n_details', 'main_image', 'main_video', 'start_at', 'created_at', 'deleted_at', 'n_category')->with('catName')->where('highlight_items', 1)->where('sticky', 0)->orderBy('highlight_order', 'desc')->limit(8)->get();
        $stickyNews = News::isActive()->select('n_id', 'n_solder', 'n_head', 'edition', 'n_details', 'main_image', 'main_video', 'start_at', 'created_at', 'deleted_at', 'n_category')->with('catName')->where('highlight_items', 1)->where('sticky', 1)->orderBy('highlight_order', 'desc')->limit(8)->get();

        if ($stickyNews) {
            $custom = collect($stickyNews);
            $sql = $custom->merge($sql);
        }

        $sql->transform(function ($row, $key) {
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
            $row->n_details = generalHelper::splitText($row->n_details, 400);
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });
        return $sql;
    }

    public static function query_AppHighlight()
    {
        $arr = News::isActive()->select('n_id', 'n_head', 'n_details', 'main_image', 'main_video', 'start_at', 'created_at', 'deleted_at', 'n_category')->with('catName')->where('highlight_items', 1)->orderBy('highlight_order', 'desc')->limit(20)->get()->toArray();
        $return_array = [];
        foreach ($arr as $row) {
            $stor = [];
            $stor['id'] = $row['n_id'];
            $stor['title'] = $row['n_head'];
            $stor['image'] = ImageStoreHelpers::showImage('news_images', $row['created_at'], $row['main_image'], 'thumbnail');
            $stor['datetime'] = $row['start_at'];
            $stor['category'] = $row['n_category'];
            $stor['category_name'] = $row['cat_name']['m_name'];
            $stor['summery'] = generalHelper::splitText($row['n_details'], 300);
            $return_array[] = $stor;
        }
        return $return_array;
    }

    public static function query_AppFocusitems()
    {
        $arr = News::isActive()->select('n_id', 'n_head', 'n_details', 'main_image', 'main_video', 'start_at', 'created_at', 'n_details', 'n_category', 'deleted_at')->with('catName')->where('focus_items', 1)->orderBy('focus_order', 'desc')->limit(10)->get()->toArray();
        $return_array = [];
        foreach ($arr as $row) {
            $stor = [];
            $stor['id'] = $row['n_id'];
            $stor['title'] = $row['n_head'];
            $stor['image'] = ImageStoreHelpers::showImage('news_images', $row['created_at'], $row['main_image'], 'thumbnail');
            $stor['datetime'] = $row['start_at'];
            $stor['category'] = $row['n_category'];
            $stor['category_name'] = $row['cat_name']['m_name'];
            $stor['summery'] = generalHelper::splitText($row['n_details'], 300);
            $return_array[] = $stor;
        }
        return $return_array;
    }

    public static function query_Focusitems()
    {
        $sql = News::isActive()->select('n_id', 'n_solder', 'n_head', 'edition', 'n_details', 'main_image', 'main_video', 'start_at', 'created_at', 'deleted_at', 'n_category')->with('catName')->where('focus_items', 1)->where('sticky', 0)->orderBy('focus_order', 'desc')->limit(12)->get();
        $stickyNews = News::isActive()->select('n_id', 'n_solder', 'n_head', 'edition', 'n_details', 'main_image', 'main_video', 'start_at', 'created_at', 'deleted_at', 'n_category')->with('catName')->where('focus_items', 1)->where('sticky', 1)->orderBy('focus_order', 'desc')->limit(12)->get();

        if ($stickyNews) {
            $custom = collect($stickyNews);
            $sql = $custom->merge($sql);
        }

        $sql->transform(function ($row, $key) {
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
            $row->n_details = generalHelper::splitText($row->n_details, 400);
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });
        return $sql;
    }

    public static function query_PinNews()
    {
        $sql = News::isActive()->select('n_id', 'n_solder', 'n_head', 'edition', 'n_details', 'start_at', 'created_at', 'deleted_at', 'n_category', 'main_image', 'main_video')->with('catName')->where('pin_news', 1)->where('sticky', 0)->orderBy('pin_order', 'desc')->limit(3)->get();
        $stickyNews = News::isActive()->select('n_id', 'n_solder', 'n_head', 'edition', 'n_details', 'start_at', 'created_at', 'deleted_at', 'n_category', 'main_image', 'main_video')->with('catName')->where('pin_news', 1)->where('sticky', 1)->orderBy('pin_order', 'desc')->limit(3)->get();

        if ($stickyNews) {
            $custom = collect($stickyNews);
            $sql = $custom->merge($sql);
        }

        $sql->transform(function ($row, $key) {
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
            $row->n_details = generalHelper::splitText($row->n_details, 400);
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });
        return $sql;
    }

    public static function query_LatestNews()
    {
        $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'start_at', 'is_latest', 'deleted_at', 'created_at')->with('catName')->where('is_latest', 1)->orderBy('start_at', 'desc')->limit(30)->get();

        $sql->transform(function ($row, $key) {
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, '');
            $row->date_at = generalHelper::time_elapsed_string($row->start_at);
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });
        return $sql;
    }

    public static function query_MostRead($cat = '')
    {
        $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'main_video', 'start_at', 'created_at', 'deleted_at')->with('catName')->where('start_at', '>=', Carbon::now()->subDays(1))->orderBy('most_read', 'desc');

        if ($cat != '') {
            $sql = $sql->whereHas('catName', function ($query) use ($cat) {
                $query->where('slug', $cat);
            });
        }

        $sql = $sql->limit(30)->get();

        $sql->transform(function ($row, $key) {
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, '');
            $row->date_at = generalHelper::time_elapsed_string($row->start_at);
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });
        return $sql;
    }

    public static function query_BestOfWeekNews()
    {
        $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'main_video', 'start_at', 'created_at', 'deleted_at')->with('catName')->where('n_date', '>=', Carbon::now()->subDays(7))->orderBy('most_read', 'desc')->limit(30)->get();

        $sql->transform(function ($row, $key) {
            $row->date_at = generalHelper::time_elapsed_string($row->start_at);
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });
        return $sql;
    }

    public static function query_HomeCategory_With_Details($n_cat, $limit, $length)
    {
        $leadNews = News::isActive()->select('n_id', 'n_solder', 'n_head', 'n_category', 'category_lead', 'edition', 'main_image', 'main_video', 'created_at', 'n_details', 'start_at', 'deleted_at')->where('category_lead', '1')->with('catName')->where('n_category', $n_cat)->orderBy('n_order', 'ASC')->orderBy('n_id', 'desc')->first();


        $sql = News::isActive()->select('n_id', 'n_solder', 'n_head', 'n_category', 'edition', 'main_image', 'main_video', 'start_at', 'created_at', 'deleted_at', 'n_details')->with('catName')->where('n_category', $n_cat)->where('home_category', 1)->orderBy('home_cat_order', 'desc')->limit($limit);

        if ($leadNews) {
            $sql = $sql->where('n_id', '!=', $leadNews['n_id']);
        }

        $sql = $sql->get();

        if ($leadNews) {
            $custom = collect([$leadNews]);
            $sql = $custom->merge($sql);
        }


        $sql->transform(function ($row, $key) use ($length) {
            $row->mob_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'mob');
            $row->thumb_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, '');
            $row->n_details = generalHelper::splitText($row->n_details, $length);
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });


        return $sql;
    }

    public static function query_HomeCategory_Without_Details($n_cat, $limit)
    {
        $leadNews = News::isActive()->select('n_id', 'n_solder', 'n_head', 'n_category', 'category_lead', 'edition', 'main_image', 'main_video', 'created_at', 'n_details', 'start_at', 'deleted_at')->where('category_lead', '1')->where('n_category', $n_cat)->with('catName')->orderBy('n_order', 'ASC')->orderBy('n_id', 'desc')->first();

        $sql = News::isActive()->select('n_id', 'n_solder', 'n_head', 'n_category', 'edition', 'main_image', 'main_video', 'start_at', 'created_at', 'deleted_at')->with('catName')->where('n_category', $n_cat)->where('home_category', 1)->orderBy('home_cat_order', 'desc')->limit($limit);

        if ($leadNews) {
            $sql = $sql->where('n_id', '!=', $leadNews['n_id']);
        }

        $sql = $sql->get();

        if ($leadNews) {
            $custom = collect([$leadNews]);
            $sql = $custom->merge($sql);
        }

        $sql->transform(function ($row, $key) {
            $row->mob_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'mob');
            $row->thumb_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, '');
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });
        return $sql;
    }

    public static function query_HomeAstrology()
    {
        $EPaperPublishDate = generalHelper::getPublishDate('Publish-Print-New-Date');

        $sql = Astrology::isActive()->where('p_status', 1)->where('start_date', $EPaperPublishDate)->orderBy('p_order', 'ASC')->get();

        $sql->transform(function ($row, $key) {
            $row->date_at = generalHelper::bn_date(date("d F, Y", strtotime($row->start_date)));
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });
        return $sql;
    }

    public static function query_HomePhotoGallery()
    {
        $sql = Gallery::isActive()->select('id', 'name', 'caption', 'cover_photo', 'images', 'type', 'category', 'embed_code', 'start_at', 'status', 'created_at')->where('type', 'photo')->orderBy('id', 'desc')->limit(5)->get();

        $sql->transform(function ($row, $key) {
            $row->cover_photo = ImageStoreHelpers::showImage('gallery', $row->created_at, $row->cover_photo, 'medium');
            $row->images = json_encode(unserialize($row->images));
            $row->imagesUrl = ImageStoreHelpers::showImage('gallery', $row->created_at, 'folderURL', '');
            return $row;
        });
        return $sql;
    }

    public static function query_HomeVideoGallery()
    {
        $sql = Gallery::isActive()->select('id', 'name', 'caption', 'cover_photo', 'type', 'category', 'embed_code', 'start_at', 'status', 'created_at')->where('type', 'video')->orderBy('id', 'desc')->limit(25)->get();

        $sql->transform(function ($row, $key) {
            $row->cover_photo = ImageStoreHelpers::showImage('gallery', $row->created_at, $row->cover_photo, 'medium');
            return $row;
        });
        return $sql;
    }

    public static function query_HomeSpecialVideo()
    {
        $sql = Gallery::isActive()->select('id', 'name', 'caption', 'cover_photo', 'type', 'category', 'embed_code', 'start_at', 'status', 'created_at')->where('type', 'video')->where('special_video', 1)->orderBy('id', 'desc')->first();
        if ($sql) {
            $sql->cover_photo = ImageStoreHelpers::showImage('gallery', $sql->created_at, $sql->cover_photo, 'medium');
            $sql->embed_code = html_entity_decode($sql->embed_code);
        }

        return $sql;
    }

    public static function query_HomeVideoSlide()
    {
        $sql = Gallery::isActive()->select('id', 'name', 'caption', 'cover_photo', 'type', 'category', 'embed_code', 'start_at', 'status', 'created_at')->where('slide_video', 1)->orderBy('g_order', 'desc')->limit(10)->get();

        $sql->transform(function ($row, $key) {
            $row->cover_photo = ImageStoreHelpers::showImage('gallery', $row->created_at, $row->cover_photo, 'medium');
            return $row;
        });
        return $sql;
    }

    public static function query_HomePool()
    {
        return Pool::active()->orderBy('start_date', 'desc')->first();
    }

    public static function query_HomeSpecialTagNews()
    {
        $special_1 = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'main_video', 'start_at', 'created_at', 'deleted_at')->with('catName')->where('n_category', 29)->where('home_category', 1)->orderBy('home_cat_order', 'desc')->limit(9)->get();
        $special_1->transform(function ($row, $key) {
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });

        $special_2 = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'main_video', 'start_at', 'created_at', 'deleted_at')->with('catName')->where('n_category', 35)->where('home_category', 1)->orderBy('home_cat_order', 'desc')->limit(9)->get();
        $special_2->transform(function ($row, $key) {
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });

        $special_3 = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'main_video', 'start_at', 'created_at', 'deleted_at')->with('catName')->where('n_category', 52)->where('home_category', 1)->orderBy('home_cat_order', 'desc')->limit(9)->get();
        $special_3->transform(function ($row, $key) {
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });

        $special_4 = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'main_video', 'start_at', 'created_at', 'deleted_at')->with('catName')->where('n_category', 27)->where('home_category', 1)->orderBy('home_cat_order', 'desc')->limit(9)->get();
        $special_4->transform(function ($row, $key) {
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });

        $special_5 = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'main_video', 'start_at', 'created_at', 'deleted_at')->with('catName')->where('n_category', 31)->where('home_category', 1)->orderBy('home_cat_order', 'desc')->limit(9)->get();
        $special_5->transform(function ($row, $key) {
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });

        // $special_6 = News::isActive()->select('n_id','n_head','n_category','edition','main_image', 'main_video','news_tags','start_at','created_at','deleted_at')->with('catName')->where('news_tags',14)->where('home_category',1)->orderBy('home_cat_order', 'desc')->limit(18)->get();
        // $special_6->transform(function ($row, $key) {
        //     $row->main_image = ImageStoreHelpers::showImage('news_images',$row->created_at,$row->main_image,'thumbnail');
        //     $row->f_date = date("Y/m/d", strtotime($row->start_at));
        //     return $row;
        // });

        return [
            'special_1' => $special_1,
            'special_2' => $special_2,
            'special_3' => $special_3,
            'special_4' => $special_4,
            'special_5' => $special_5,
        ];
    }

    public static function query_HomeMagazine()
    {
        $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'home_category', 'main_image', 'main_video', 'n_date', 'start_at', 'created_at', 'deleted_at')->where('edition', 'magazine')->with('catName')->where('home_category', 1)->orderBy('n_id', 'desc')->limit(20)->get();

        $sql->transform(function ($row, $key) {
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });
        return $sql;
    }

    public static function query_DetailsNews($n_id)
    {
        $sql = News::findNewsTable($n_id)->with([
            'catName',
            'getWriters',
            'getReporter',
            'createdBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->isActive()->find($n_id);
        if ($sql) {
            $sql->n_solder = strip_tags(html_entity_decode($sql->n_solder));
            $sql->n_head = strip_tags(html_entity_decode($sql->n_head));
            $sql->n_subhead = ($sql->n_subhead) ?  '<li>' . str_replace("\n", '</li><li>', html_entity_decode($sql->n_subhead)) . '</li>' : '';
            $sql->n_details = str_replace('/ckfinder/innerfiles/', 'https://asset.banglanews24.com/public/news_images/ckfinder/innerfiles/', htmlentities(html_entity_decode($sql->n_details)));
            $ifOg = ($sql->watermark != '') ? 'og' : '';
            $sql->openGraphImg = ImageStoreHelpers::showImage('news_images', $sql->created_at, $sql->main_image, $ifOg);
            $sql->datePublished = date('h:i A, F Y, l', strtotime($sql->start_at));
            $sql->dateModified = date('h:i A, F Y, l', strtotime(($sql->edit_at) ? $sql->edit_at : $sql->start_at));
            $sql->date_at = generalHelper::bn_date(date("d F, Y H:i", strtotime($sql->start_at)));
            $sql->edit_at = $sql->edit_at ? generalHelper::bn_date(date("l, d F, Y H:i", strtotime($sql->edit_at))) : '';
            $sql->main_image = ImageStoreHelpers::showImage('news_images', $sql->created_at, $sql->main_image, '');
            $sql->meta_description = $sql->meta_description ? strip_tags(html_entity_decode($sql->meta_description)) : generalHelper::splitText(strip_tags(html_entity_decode($sql->n_details)), 400);
            $sql->writers_img = ($sql->getWriters) ? ImageStoreHelpers::showImage('profile', $sql->getWriters->created_at, $sql->getWriters->img) : '';
            $sql->writers_name = ($sql->getWriters) ? $sql->getWriters->name : '';

            $sql->reporter_img = ($sql->getReporter) ? ImageStoreHelpers::showImage('profile', $sql->getReporter->created_at, $sql->getReporter->img) : '';
            $sql->reporter_name = ($sql->getReporter) ? $sql->getReporter->name : '';

            $sql->f_date = date("Y/m/d", strtotime($sql->start_at));
            $sql->embedded_code = html_entity_decode($sql->embedded_code);
        }
        return $sql;
    }

    public static function query_MetaKeywordNews($get_keyword, $n_id)
    {
        $keyword = explode(',', $get_keyword);
        $sql = News::select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'main_video', 'start_at', 'created_at', 'deleted_at')->isActive()->with('catName')
            ->Where(function ($query) use ($keyword) {
                for ($i = 0; $i < count($keyword); $i++) {
                    if ($keyword[$i]) {
                        $query->orwhere('meta_keyword', 'like', '%' . trim($keyword[$i]) . '%');
                    }
                }
            })
            ->where('n_id', '!=', $n_id)->orderBy('n_id', 'desc')->limit(4)->get();

        $sql->transform(function ($row, $key) {
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
            $row->date_at = generalHelper::time_elapsed_string($row->start_at);
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });
        return $sql;
    }

    public static function query_DetailsMoreNews($cat, $n_id)
    {
        $sql = News::with([
            'catName',
            'getWriters',
            'getReporter',
            'createdBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->isActive()->where('n_category', $cat)->where('n_id', '!=', $n_id)->orderBy('n_id', 'desc')->limit(4)->get();
        $sql->transform(function ($row, $key) use ($n_id) {
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, '');
            $row->n_solder = strip_tags(html_entity_decode($row->n_solder));
            $row->n_head = strip_tags(html_entity_decode($row->n_head));
            $row->n_subhead = strip_tags(html_entity_decode($row->n_subhead));
            $row->n_details = generalHelper::splitText($row->n_details, 2000);
            $row->date_at = generalHelper::bn_date(date("l, d F, Y, H:i", strtotime($row->start_at)));
            $row->edit_at = generalHelper::bn_date(date("l, d F, Y, H:i", strtotime($row->edit_at)));
            $row->writers_img = ($row->getWriters) ? ImageStoreHelpers::showImage('profile', $row->getWriters->created_at, $row->getWriters->img) : '';
            $row->writers_name = ($row->getWriters) ? $row->getWriters->name : '';
            $row->writers_profession = ($row->getWriters) ? $row->getWriters->profession : '';

            $row->reporter_img = ($row->getReporter) ? ImageStoreHelpers::showImage('profile', $row->getReporter->created_at, $row->getReporter->img) : '';
            $row->reporter_name = ($row->getReporter) ? $row->getReporter->name : '';
            $row->reporter_profession = ($row->getReporter) ? $row->getReporter->profession : '';

            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            $row->embedded_code = html_entity_decode($row->embedded_code);

            return $row;
        });
        return $sql;
    }

    public static function query_CategoryNewsList($cat, $checkEdition, $pdate = '')
    {
        // $getY = $pdate ? date("Y", strtotime($pdate)) : '';
        $getY = ($checkEdition == 'online') ? request()->get('y') : ($pdate ? date("Y", strtotime($pdate)) : '');

        $sql = News::newsTable($getY)->isActive()->select('n_id', 'n_solder', 'n_head', 'n_category', 'edition', 'main_image', 'main_video', 'created_at', 'n_details', 'start_at', 'deleted_at')->with('catName')->whereHas('catName', function ($query) use ($cat, $checkEdition) {
            $query->where('slug', $cat)->where('m_edition', $checkEdition);
        });

        if ($checkEdition == 'print') {
            $APP_URL_Edition = 'print-edition';
            $getPublishDate = ($pdate == '') ? generalHelper::getPublishDate('Publish-Print-New-Date') : $pdate;
            $sql = $sql->where('n_date', $getPublishDate)->orderBy('n_order', 'ASC');
        } elseif ($checkEdition == 'magazine') {
            $APP_URL_Edition = 'feature';
            // isActive()->
            // $checkMagazine = News::select('n_date','n_category')->whereHas('catName', function($query) use($cat) {
            //     $query->where('slug',$cat)->where('m_edition','magazine');
            // })->orderBy('n_id', 'desc')->first();

            // if(isset($checkMagazine['n_date'])){
            //     $sql = $sql->where('n_date',$checkMagazine['n_date'])->orderBy('n_order', 'ASC');
            // }else{
            //     $getPublishDate = generalHelper::getPublishDate('Publish-Magazine-New-Date');
            //     $sql = $sql->where('n_date',$getPublishDate)->orderBy('n_order', 'ASC');
            // }

            $sql = $sql->orderBy('n_date', 'desc')->orderBy('n_order', 'ASC');
        }else if($checkEdition == 'multimedia'){
            $APP_URL_Edition = 'multimedia';
            $sql = $sql->orderBy('home_cat_order', 'desc');
        } else {
            $APP_URL_Edition = 'online';
            $categoryLead = News::newsTable($getY)->isActive()->select('n_id', 'n_solder', 'n_head', 'n_category', 'category_lead', 'edition', 'main_image', 'main_video', 'created_at', 'n_details', 'start_at', 'deleted_at')->where('category_lead', '1')->with('catName')->whereHas('catName', function ($query) use ($cat) {
                $query->where('slug', $cat);
            })->orderBy('n_id', 'desc')->first();

            if (isset($categoryLead['n_id'])) {
                $sql = $sql->where('n_id', '!=', $categoryLead['n_id']);
            }

            $sql = $sql->orderBy('home_cat_order', 'desc');
        }

        $current_url = env('APP_API_URL') . '/api/' . $APP_URL_Edition . '/' . $cat;

        $sql = $sql->paginate(20)->setPath($current_url);
        $data = $sql->getCollection();

        if (isset($categoryLead['n_id']) && $sql->currentPage() == 1) {
            $custom = collect([$categoryLead]);
            $data = $custom->merge($data);
        }

        $data->transform(function ($row, $key) use ($APP_URL_Edition) {
            $row->thumb_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, '');
            $row->n_head = strip_tags(html_entity_decode($row->n_head));
            $row->n_details = generalHelper::splitText(strip_tags(html_entity_decode($row->n_details)), 400);
            $row->date_at = ($APP_URL_Edition == 'online') ? generalHelper::time_elapsed_string($row->start_at) : generalHelper::bn_date(date("d F, Y", strtotime($row->start_at)));
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });

        $sql->setCollection($data);

        return $sql;
    }

    public static function query_CategoryNewsListTst($cat, $checkEdition, $catArcDate)
    {
        $sql = News::newsTable($catArcDate)->isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'main_video', 'created_at', 'n_details', 'start_at', 'deleted_at')->with('catName')->whereHas('catName', function ($query) use ($cat, $checkEdition) {
            $query->where('slug', $cat)->where('m_edition', $checkEdition);
        });
        exit;

        if ($checkEdition == 'print') {
            $APP_URL_Edition = 'print-edition';
            // $getPublishDate = generalHelper::getPublishDate('Publish-Print-New-Date');
            // $sql = $sql->where('n_date',$getPublishDate)->orderBy('n_order', 'ASC');
            $sql = $sql->orderBy('n_date', 'desc')->orderBy('n_order', 'ASC');
        } elseif ($checkEdition == 'magazine') {
            $APP_URL_Edition = 'feature';
            $sql = $sql->orderBy('n_date', 'desc')->orderBy('n_order', 'ASC');
        } elseif ($checkEdition == 'multimedia') {
            $APP_URL_Edition = 'multimedia';
            $sql = $sql->orderBy('n_id', 'desc');
        } else {
            $APP_URL_Edition = 'online';
            $categoryLead = News::newsTable(request()->get('y'))->isActive()->select('n_id', 'n_head', 'n_category', 'category_lead', 'edition', 'main_image', 'main_video', 'created_at', 'n_details', 'start_at', 'deleted_at')->where('category_lead', '1')->orderBy('n_order', 'ASC')->with('catName')->whereHas('catName', function ($query) use ($cat) {
                $query->where('slug', $cat);
            })->orderBy('n_id', 'desc')->first();

            if (isset($categoryLead['n_id'])) {
                $sql = $sql->where('n_id', '!=', $categoryLead['n_id'])->orderBy('n_id', 'desc');
            } else {
                $sql = $sql->orderBy('n_id', 'desc');
            }
        }

        $current_url = env('APP_API_URL') . '/api/' . $APP_URL_Edition . '/' . $cat;

        $sql = $sql->paginate(20)->setPath($current_url);
        $data = $sql->getCollection();

        if (isset($categoryLead['n_id']) && $sql->currentPage() == 1) {
            $custom = collect([$categoryLead]);
            $data = $custom->merge($data);
        }

        $data->transform(function ($row, $key) use ($APP_URL_Edition) {
            $row->thumb_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, '');
            $row->n_head = strip_tags(html_entity_decode($row->n_head));
            $row->n_details = generalHelper::splitText(strip_tags(html_entity_decode($row->n_details)), 400);
            $row->date_at = ($APP_URL_Edition == 'online') ? generalHelper::time_elapsed_string($row->start_at) : generalHelper::bn_date(date("d F, Y", strtotime($row->start_at)));
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });

        $sql->setCollection($data);

        return $sql;
    }


    public static function query_Top10News()
    {
        $top10News = Miscellaneous::where('status', 1)->where('type', 'top10')->first();
        $top10NewsIds = json_decode($top10News->arr_data);

        $sql = News::isActive()->select('n_id', 'n_solder', 'n_head', 'edition', 'n_details', 'main_image', 'main_video', 'start_at', 'created_at', 'n_category', 'deleted_at')->with('catName')->whereIn('n_id', $top10NewsIds)->orderByRaw("FIELD(n_id, " . implode(",", $top10NewsIds) . ")")->get();

        $sql->transform(function ($row, $key) {
            $row->mob_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'mob');
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
            $row->n_details = generalHelper::splitText($row->n_details, 400);
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });
        return $sql;
    }

    public static function query_HomePrintCategory_104()
    {
        $EPaperPublishDate = '2023-09-25';

        $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'n_details', 'home_category', 'main_image', 'main_video', 'n_date', 'start_at', 'created_at', 'deleted_at')->where('n_category', 104)->where('n_date', $EPaperPublishDate)->with('catName')->orderBy('n_order', 'ASC')->get();

        $sql->transform(function ($row, $key) {
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, '');
            $row->n_details = generalHelper::splitText($row->n_details, 400);
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });
        return $sql;
    }

    public static function query_RecentNews($cat = '')
    {
        $sql = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'main_video', 'start_at', 'created_at', 'deleted_at')->with('catName');

        if ($cat == 'recent') {
            $tagInfo = [];
            $sql->where('start_at', '>=', Carbon::now()->subDays(1))->orderBy('n_id', 'desc');
        } else {
            $tagInfo = Tag::where('status', 1)->where('id', $cat)->first();

            $sql->where('news_tags', $cat)->orderBy('n_id', 'desc');
        }

        $sql = $sql->limit(200)->get();

        $sql->transform(function ($row, $key) {
            $row->mob_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'mob');
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            $row->date_at = generalHelper::time_elapsed_string($row->start_at);
            return $row;
        });
        return [
            "data" => $sql,
            "tagInfo" => $tagInfo,
        ];
    }

    public static function query_specialSigment()
    {
        $specialSigment = Miscellaneous::where('status', 1)->where('type', 'special-sigment')->first();
        if (!$specialSigment) {
            return [];
        }
        $specialSigmentData = json_decode($specialSigment->arr_data);
        if (!$specialSigmentData) {
            return [];
        }

        $specialSigmentTagId = $specialSigmentData->tag_id;

        $sql = News::isActive()->select('n_id', 'n_solder', 'n_head', 'edition', 'n_details', 'main_image', 'main_video', 'start_at', 'created_at', 'n_category', 'deleted_at')->with('catName')->where('news_tags', $specialSigmentTagId)->orderBy('special_order', 'desc')->limit(7)->get();

        $sql->transform(function ($row, $key) {
            $row->mob_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'mob');
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
            $row->n_details = generalHelper::splitText($row->n_details, 400);
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });
        return [
            "tag_id" => $specialSigmentTagId,
            "display" => $specialSigmentData->display,
            "title" => $specialSigmentData->title,
            "desktop_img" => $specialSigmentData->desktop_img ? ImageStoreHelpers::showImage('special_sigment', 'folder', $specialSigmentData->desktop_img) : $specialSigmentData->desktop_img,
            "mobile_img" => $specialSigmentData->mobile_img ? ImageStoreHelpers::showImage('special_sigment', 'folder', $specialSigmentData->mobile_img) : $specialSigmentData->mobile_img,
            "newsData" => $sql,
        ];
    }

    public static function query_LiveNews($type)
    {
        $sqlLive = News::isActive()->select('n_id', 'n_solder', 'n_head', 'edition', 'n_details', 'main_image', 'main_video', 'start_at', 'created_at', 'n_category', 'deleted_at')->with('catName')->where($type, 1)->where('is_active_live', 1)->where('is_live', 1)->orderBy('n_id', 'desc')->first();
        if (!$sqlLive) {
            return [];
        }

        $sql = News::select('n_id', 'n_solder', 'n_head', 'edition', 'n_details', 'main_image', 'main_video', 'start_at', 'created_at', 'n_category', 'deleted_at')->with('catName')->where('n_status', 3)->where('start_at', '<=', date('Y-m-d H:i:s'))->where('parent_id', $sqlLive->n_id)->orderBy('n_id', 'desc')->first();

        if ($sql) {
            $sqlLive->mob_image = $sql->mob_image;
            $sqlLive->main_image = $sql->main_image;
            $sqlLive->created_at = $sql->created_at;
            $sqlLive->n_head = $sql->n_head;
        }

        $sqlLive->mob_image = ImageStoreHelpers::showImage('news_images', $sqlLive->created_at, $sqlLive->main_image, 'mob');
        $sqlLive->main_image = ImageStoreHelpers::showImage('news_images', $sqlLive->created_at, $sqlLive->main_image, 'thumbnail');
        $sqlLive->n_details = generalHelper::splitText($sqlLive->n_details, 400);
        $sqlLive->f_date = date("Y/m/d", strtotime($sqlLive->start_at));

        return $sqlLive;
    }


    public static function query_DetailsLiveNews($n_id)
    {
        $sql = News::with([
            'catName',
            'getWriters',
            'getReporter',
            'createdBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->where('n_status', 3)->where('start_at', '<=', date('Y-m-d H:i:s'))->where('parent_id', $n_id)->orderBy('n_id', 'desc')->get();
        
        $sql->transform(function ($row, $key) use ($n_id) {
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, '');
            $row->n_solder = strip_tags(html_entity_decode($row->n_solder));
            $row->n_head = strip_tags(html_entity_decode($row->n_head));
            $row->n_subhead = strip_tags(html_entity_decode($row->n_subhead));
            $row->n_details = str_replace('/ckfinder/innerfiles/', 'https://asset.banglanews24.com/public/news_images/ckfinder/innerfiles/', htmlentities(html_entity_decode($row->n_details)));
            $row->date_at = generalHelper::bn_date(date("H:i, l d", strtotime($row->start_at)));
            $row->edit_at = $row->edit_at ? generalHelper::bn_date(date("l, d F, Y H:i", strtotime($row->edit_at))) : '';
            $row->writers_img = ($row->getWriters) ? ImageStoreHelpers::showImage('profile', $row->getWriters->created_at, $row->getWriters->img) : '';
            $row->writers_name = ($row->getWriters) ? $row->getWriters->name : '';

            $row->reporter_img = ($row->getReporter) ? ImageStoreHelpers::showImage('profile', $row->getReporter->created_at, $row->getReporter->img) : '';
            $row->reporter_name = ($row->getReporter) ? $row->getReporter->name : '';

            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            $row->embedded_code = html_entity_decode($row->embedded_code);

            return $row;
        });
        return $sql;
    }

    public static function query_SpecialCarousel()
    {
        $special_news = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'news_tags', 'start_at', 'created_at', 'deleted_at')->with('catName')->where('home_slide', 1)->orderBy('home_slide_order', 'desc')->limit(10)->get();

        $special_news->transform(function ($row, $key) {
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });

        return $special_news;
    }

    public static function query_HomeMultimedia()
    {
        $special_news = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'main_image', 'news_tags', 'start_at', 'created_at', 'deleted_at')->with('catName')->where('multimedia_slide', 1)->orderBy('multimedia_slide_order', 'desc')->limit(10)->get();

        $special_news->transform(function ($row, $key) {
            $row->main_image = ImageStoreHelpers::showImage('news_images', $row->created_at, $row->main_image, 'thumbnail');
            $row->f_date = date("Y/m/d", strtotime($row->start_at));
            return $row;
        });

        return $special_news;
    }
}
