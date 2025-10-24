<?php

namespace App\Http\Controllers;


use App\Helpers\generalHelper;
use App\Helpers\queryHelpers;
use Carbon\Carbon;
use App\Models\Menu;
use App\Models\News;
use App\Models\Gallery;
use App\Models\BreakingNews;
use App\Helpers\ImageStoreHelpers;
use Illuminate\Support\Facades\Cache;

class AppController extends Controller{
    public function home(){
        $ticker = Cache::remember('Appticker', 500, function(){
            return News::isActive()->select('n_id as id','n_head as title')->where('ticker_news',1)->orderBy('id', 'desc')->limit(20)->get();
        });
//        $leadNews = Cache::remember('AppleadNews', 300, function(){
//            $arr = News::with('catName')->isActive()->select('n_id','n_head','n_details','main_image','start_at','created_at','deleted_at','n_category')->where('home_lead',1)->orderBy('leadnews_order', 'desc')->limit(8)->get()->toArray();
//            $return_array = [];
//            foreach($arr as $row){
//                $stor = [];
//                $stor['id'] = $row['n_id'];
//                $stor['title'] = $row['n_head'];
//                $stor['image'] = ImageStoreHelpers::showImage('news_images',$row['created_at'],$row['main_image'],'thumbnail');
//                $stor['datetime'] = $row['start_at'];
//                $stor['category'] = $row['n_category'];
//                $stor['category_name'] = $row['cat_name']['m_name'];
//                $stor['summery'] = generalHelper::splitText($row['n_details'], 300);
//                $return_array[]=$stor;
//            }
//            return $return_array;
//        });
        $leadNews = Cache::remember('newAppleadNews', 300, function(){
            return queryHelpers::query_AppLeadNews();
        });

        $highlight = Cache::remember('newApphighlight', 300, function(){
            return queryHelpers::query_AppHighlight();
        });

        $focus_items = Cache::remember('newAppfocus_items', 300, function(){
            return queryHelpers::query_AppFocusitems();
        });

//        $highlight = Cache::remember('Apphighlight', 300, function(){
//            $arr = News::isActive()->select('n_id','n_head','n_details','main_image','start_at','created_at','deleted_at','n_category')->with('catName')->where('highlight_items',1)->orderBy('highlight_order', 'desc')->limit(10)->get()->toArray();
//            $return_array = [];
//            foreach($arr as $row){
//                $stor = [];
//                $stor['id'] = $row['n_id'];
//                $stor['title'] = $row['n_head'];
//                $stor['image'] = ImageStoreHelpers::showImage('news_images',$row['created_at'],$row['main_image'],'thumbnail');
//                $stor['datetime'] = $row['start_at'];
//                $stor['category'] = $row['n_category'];
//                $stor['category_name'] = $row['cat_name']['m_name'];
//                $stor['summery'] = generalHelper::splitText($row['n_details'], 300);
//                $return_array[]=$stor;
//            }
//            return $return_array;
//        });
//        $focus_items = Cache::remember('Appfocus_items', 300, function(){
//            $arr = News::isActive()->select('n_id','n_head','n_details','main_image','start_at','created_at','n_details','n_category','deleted_at')->with('catName')->where('focus_items',1)->orderBy('focus_order', 'desc')->limit(10)->get()->toArray();
//            $return_array = [];
//            foreach($arr as $row){
//                $stor = [];
//                $stor['id'] = $row['n_id'];
//                $stor['title'] = $row['n_head'];
//                $stor['image'] = ImageStoreHelpers::showImage('news_images',$row['created_at'],$row['main_image'],'thumbnail');
//                $stor['datetime'] = $row['start_at'];
//                $stor['category'] = $row['n_category'];
//                $stor['category_name'] = $row['cat_name']['m_name'];
//                $stor['summery'] = generalHelper::splitText($row['n_details'], 300);
//                $return_array[]=$stor;
//            }
//            return $return_array;
//        });

        $homeCat = [1=>'জাতীয়', 16=>'সারাবাংলা', 13=>'বিশ্ব',5=>'বাণিজ্য',55=>'বিনোদন',57=>'তথ্যপ্রযুক্তি',8=>'খেলা',54=>'জীবনযাপন',279=>'ইসলামী জীবন'];
        $return_array = [];
        foreach ($homeCat as $key=>$value) {
            $all_cat_news[] = Cache::remember('ApphomeCat_'.$key, 300, function() use($key,$value) {
                $arr = News::isActive()->select('n_id','n_head','n_details','main_image','start_at','created_at','n_category','deleted_at')->where('n_category',$key)->orderBy('home_cat_order', 'desc')->limit(4)->get()->toArray();
                $get_array = [];
                $get_array['category_id'] = $key;
                $get_array['category_name'] = $value;
                foreach($arr as $row){
                    $stor = [];
                    $stor['id'] = $row['n_id'];
                    $stor['title'] = $row['n_head'];
                    $stor['image'] = ImageStoreHelpers::showImage('news_images',$row['created_at'],$row['main_image'],'thumbnail');
                    $stor['datetime'] = $row['start_at'];
                    $stor['summery'] = generalHelper::splitText($row['n_details'], 300);
                    $get_array['news'][] = $stor;
                }

                return $return_array[] = $get_array;
            });
        }

        $most_read = Cache::remember('Appmost_read', 504, function(){
            $arr = News::isActive()->with('catName')->select('n_id','n_head','n_details','start_at','deleted_at','created_at','main_image','n_category')->where('start_at', '>=', Carbon::now()->subDays(1))->orderBy('most_read', 'desc')->limit(40)->get()->toArray();
            $return_array = [];
            foreach($arr as $row){
                $stor = [];
                $stor['id'] = $row['n_id'];
                $stor['title'] = $row['n_head'];
                $stor['image'] = ImageStoreHelpers::showImage('news_images',$row['created_at'],$row['main_image'],'thumbnail');
                $stor['datetime'] = $row['start_at'];
                $stor['category'] = $row['n_category'];
                $stor['category_name'] = $row['cat_name']['m_name'];
                $stor['summery'] = generalHelper::splitText($row['n_details'], 300);
                $return_array[]=$stor;
            }
            return $return_array;
        });

        $latest = Cache::remember('Applatest', 503, function(){
            $arr = News::isActive()->with('catName')->select('n_id','n_head','n_details','start_at','is_latest','deleted_at','created_at','main_image','n_category')->where('is_latest',1)->orderBy('start_at', 'desc')->limit(40)->get()->toArray();
            $return_array = [];
            foreach($arr as $row){
                $stor = [];
                $stor['id'] = $row['n_id'];
                $stor['title'] = $row['n_head'];
                $stor['image'] = ImageStoreHelpers::showImage('news_images',$row['created_at'],$row['main_image'],'thumbnail');
                $stor['datetime'] = $row['start_at'];
                $stor['category'] = $row['n_category'];
                $stor['category_name'] = $row['cat_name']['m_name'];
                $stor['summery'] = generalHelper::splitText($row['n_details'], 300);
                $return_array[]=$stor;
            }
            return $return_array;
        });


        $gallery_17 = Cache::remember('Appgallery_17', 500, function(){
            $arr = Gallery::isActive()->select('id','name','caption','cover_photo','type','category','embed_code','start_at','status','created_at')->where('category',1)->orderBy('g_order', 'desc')->limit(15)->get()->toArray();
            $return_array = [];
            foreach($arr as $row){
                if($row['cover_photo']){
                    $img = ImageStoreHelpers::showImage('gallery',$row['created_at'],$row['cover_photo'],'medium');
                }else{
                    $img = 'https://img.youtube.com/vi/'.$row['embed_code'].'/hqdefault.jpg';
                }
                $stor = [];
                $stor['id'] = $row['id'];
                $stor['title'] = $row['name'];
                $stor['caption'] = $row['caption'];
                $stor['image'] = $img;
                $stor['category'] = $row['category'];
                $return_array[]=$stor;
            }
            return $return_array;
        });

        return response()->json([
            'top_news' => $leadNews,
            'highlight' => $highlight,
            'all_cat_news' => $all_cat_news,
            'latest_news' => $latest,
            'most_read' => $most_read,
            'photo_gallery' => $gallery_17
        ]);
    }

    public function categorynews($m_id){
        $currentPage = $m_id.'-'.request()->get('page',1);
        $category = Cache::remember('Appcategory-' . $currentPage, 505, function() use($m_id) {
            $arr = News::with('catName')->isActive()->select('n_id','n_head','n_details','main_image','created_at','start_at','n_category','deleted_at')->where('n_category', $m_id)->orderBy('n_id', 'desc')->paginate(19);

            $return_array = [];
            foreach($arr as $row){
                $stor = [];
                $stor['id'] = $row['n_id'];
                $stor['title'] = $row['n_head'];
                $stor['image'] = ImageStoreHelpers::showImage('news_images',$row['created_at'],$row['main_image'],'thumbnail');
                $stor['datetime'] = $row['start_at'];
                $stor['category'] = $row['n_category'];
                $stor['category_name'] = $row['catName']->m_name;
                $stor['summery'] = generalHelper::splitText($row['n_details'], 300);
                $return_array[]=$stor;
            }
            return [
                'cat_news' => $return_array,
                'hasMorePages' =>$arr->hasMorePages()
            ];
        });
        return response()->json($category);
    }

    public function categoryvideos($m_id){
        $currentPage = $m_id.'-'.request()->get('page',1);
        $category = Cache::remember('Appvideocategory-' . $currentPage, 505, function() use($m_id) {
            $arr = Gallery::isActive()->select('id','name','caption','cover_photo','type','category','embed_code','start_at','status','created_at')->where('category',$m_id)->orderBy('id', 'desc')->paginate(19);
            $return_array = [];
            foreach($arr as $row){
                $stor = [];
                $stor['id'] = $row['id'];
                $stor['title'] = $row['caption'];
                if($row['cover_photo']){
                    $stor['image'] = ImageStoreHelpers::showImage('gallery',$row['created_at'],$row['cover_photo'],'medium');
                }else{
                    $stor['image'] = 'https://img.youtube.com/vi/'.$row['embed_code'].'/hqdefault.jpg';
                }
                $stor['caption'] = $row['caption'];
                $stor['category'] = $row['category'];
                $stor['url'] = $row['embed_code'];
//                $stor['summery'] = generalHelper::splitText($row['n_details'], 300);
                $return_array[]=$stor;
            }
            return [
                'cat_news' => $return_array,
                'hasMorePages' =>$arr->hasMorePages()
            ];
        });
        return response()->json($category);
    }

    public function details($n_id){
        $details = Cache::remember('Appdetails-'.$n_id, 505, function() use($n_id){
            $row = News::with('catName')->isActive()->find($n_id);
            $return_array['id'] = $row['n_id'];
            $return_array['title'] = $row['n_head'];
            $return_array['image'] = ImageStoreHelpers::showImage('news_images',$row['created_at'],$row['main_image'],'thumbnail');
            $return_array['author'] = $row['n_author'];
            $return_array['details'] = html_entity_decode($row['n_details']);
            $return_array['category'] = $row['n_category'];
            $return_array['datetime'] = $row['start_at'];
            $return_array['category_name'] = $row['catName']->m_name;
            $return_array['news_url'] = url('details/'.$row['n_id']);
            return $return_array;
        });
        return response()->json($details);
    }
    public function menu_list(){
        $appMenu = Cache::rememberForever('appMenu', function () {
            $menus = Menu::select('m_id','m_name','slug')->where('m_edition','online')->where('m_status',1)->where('m_visible',1)->whereNotIn('m_id', [487])->orderBy('m_order', 'ASC')->get();
            $sub_menus = generalHelper::appTodaysNewspaperMenu();
            $menu_array = $this->generateMenu($menus,1);
            $sub_menu_array = $this->generateMenu($sub_menus,0);
            $menu['online'] = $menu_array;
            $menu['print'] = $sub_menu_array;
            return $menu;
        });
        return response()->json($appMenu);
    }

    public function generateMenu($menus,$main=0){
        $menu_array = [];
        // if ($main){
        //     $menu_array[] = [
        //         "id"=> "today-all",
        //         "title"=> "আজকের সব খবর",
        //         "icon"=> "list-box"
        //     ];
        // }
        foreach($menus as $row){
            $stor = [];
            $stor['id'] = $row['m_id'];
            $stor['title'] = $row['m_name'];
            $stor['icon'] = '';
            $menu_array[]=$stor;
        }
        return $menu_array;
    }




    /*
        Old App Api
    */
    public function oldhome(){
        $ticker_news = Cache::remember('oldAppticker', 500, function(){
            return News::isActive()->select('n_id as id','n_head as title')->where('ticker_news',1)->orderBy('id', 'desc')->limit(20)->get();
        });
        $ticker = [
            'breakingnews'=>[],
            'scroller1'=>$ticker_news,
            'scroller2'=>[]
        ];
        $leadNews = Cache::remember('oldAppleadNews', 300, function(){
            $arr = News::with('catName')->isActive()->select('n_id','n_head','main_image','start_at','created_at','deleted_at','n_category')->where('home_lead',1)->orderBy('leadnews_order', 'desc')->limit(8)->get()->toArray();
            $return_array = [];
            foreach($arr as $row){
                $stor = [];
                $stor['id'] = $row['n_id'];
                $stor['title'] = $row['n_head'];
                $stor['image'] = ImageStoreHelpers::showImage('news_images',$row['created_at'],$row['main_image'],'thumbnail');
                $stor['datetime'] = $row['start_at'];
                $stor['category'] = $row['n_category'];
                $stor['category_name'] = $row['cat_name']['m_name'];
                $return_array[]=$stor;
            }
            return $return_array;
        });
        $highlight = Cache::remember('oldApphighlight', 300, function(){
            $arr = News::isActive()->select('n_id','n_head','main_image','start_at','created_at','deleted_at','n_category')->with('catName')->where('highlight_items',1)->orderBy('highlight_order', 'desc')->limit(5)->get()->toArray();
            $return_array = [];
            foreach($arr as $row){
                $stor = [];
                $stor['id'] = $row['n_id'];
                $stor['title'] = $row['n_head'];
                $stor['image'] = ImageStoreHelpers::showImage('news_images',$row['created_at'],$row['main_image'],'thumbnail');
                $stor['datetime'] = $row['start_at'];
                $stor['category'] = $row['n_category'];
                $stor['category_name'] = $row['cat_name']['m_name'];
                $return_array[]=$stor;
            }
            return $return_array;
        });
        $focus_items = Cache::remember('oldAppfocus_items', 300, function(){
            $arr = News::isActive()->select('n_id','n_head','main_image','start_at','created_at','n_details','n_category','deleted_at')->with('catName')->where('focus_items',1)->orderBy('focus_order', 'desc')->limit(8)->get()->toArray();
            $return_array = [];
            foreach($arr as $row){
                $stor = [];
                $stor['id'] = $row['n_id'];
                $stor['title'] = $row['n_head'];
                $stor['image'] = ImageStoreHelpers::showImage('news_images',$row['created_at'],$row['main_image'],'thumbnail');
                $stor['datetime'] = $row['start_at'];
                $stor['category'] = $row['n_category'];
                $stor['category_name'] = $row['cat_name']['m_name'];
                $return_array[]=$stor;
            }
            return $return_array;
        });

        $homeCat = [112=>'জাতীয়', 113=>'রাজনীতি', 111=>'অপরাধ',8=>'বিনোদন',3=>'আন্তর্জাতিক',7=>'খেলাধুলা'];
        $return_array = [];
        foreach ($homeCat as $key=>$value) {
            $all_cat_news[] = Cache::remember('oldApphomeCat_'.$key, 300, function() use($key,$value) {
                $arr = News::isActive()->select('n_id','n_head','main_image','start_at','created_at','n_category','deleted_at')->where('n_category',$key)->orderBy('home_cat_order', 'desc')->limit(4)->get()->toArray();
                $get_array = [];
                $get_array['category_id'] = $key;
                $get_array['category_name'] = $value;
                foreach($arr as $row){
                    $stor = [];
                    $stor['id'] = $row['n_id'];
                    $stor['title'] = $row['n_head'];
                    $stor['image'] = ImageStoreHelpers::showImage('news_images',$row['created_at'],$row['main_image'],'thumbnail');
                    $stor['datetime'] = $row['start_at'];
                    $get_array['news'][] = $stor;
                }

                return $return_array[] = $get_array;
            });
        }

        $most_read = Cache::remember('oldAppmost_read', 504, function(){
            $arr = News::isActive()->with('catName')->select('n_id','n_head','start_at','deleted_at','created_at','main_image','n_category')->where('start_at', '>=', Carbon::now()->subDays(1))->orderBy('most_read', 'desc')->limit(6)->get()->toArray();
            $return_array = [];
            foreach($arr as $row){
                $stor = [];
                $stor['id'] = $row['n_id'];
                $stor['title'] = $row['n_head'];
                $stor['image'] = ImageStoreHelpers::showImage('news_images',$row['created_at'],$row['main_image'],'thumbnail');
                $stor['datetime'] = $row['start_at'];
                $stor['category'] = $row['n_category'];
                $stor['category_name'] = $row['cat_name']['m_name'];
                $return_array[]=$stor;
            }
            return $return_array;
        });

        $latest = Cache::remember('oldApplatest', 503, function(){
            $arr = News::isActive()->with('catName')->select('n_id','n_head','start_at','is_latest','deleted_at','created_at','main_image','n_category')->where('is_latest',1)->orderBy('start_at', 'desc')->limit(6)->get()->toArray();
            $return_array = [];
            foreach($arr as $row){
                $stor = [];
                $stor['id'] = $row['n_id'];
                $stor['title'] = $row['n_head'];
                $stor['image'] = ImageStoreHelpers::showImage('news_images',$row['created_at'],$row['main_image'],'thumbnail');
                $stor['datetime'] = $row['start_at'];
                $stor['category'] = $row['n_category'];
                $stor['category_name'] = $row['cat_name']['m_name'];
                $return_array[]=$stor;
            }
            return $return_array;
        });

        $gallery_4 = Cache::remember('oldAppgallery_4', 500, function(){
            $arr = Gallery::isActive()->select('id','name','caption','cover_photo','type','category','embed_code','start_at','status','created_at')->where('category',4)->orderBy('id', 'desc')->limit(5)->get()->toArray();
            $return_array = [];
            foreach($arr as $row){
                if($row['cover_photo']){
                    $img = ImageStoreHelpers::showImage('gallery',$row['created_at'],$row['cover_photo'],'medium');
                }else{
                    $img = 'https://img.youtube.com/vi/'.$row['embed_code'].'/hqdefault.jpg';
                }
                $stor = [];
                $stor['id'] = $row['id'];
                $stor['title'] = $row['name'];
                $stor['caption'] = $row['caption'];
                $stor['image'] = $img;
                $stor['url'] = $row['embed_code'];
                $stor['category'] = $row['category'];
                $return_array[]=$stor;
            }
            return $return_array;
        });

        $programIds = [6,9,10,11,12,13,14,15];
        foreach ($programIds as $pid) {
            $gallery_program[] = Cache::remember('oldAppgallery_'.$pid, 500, function() use($pid){
                $row = Gallery::isActive()->select('id','name','caption','cover_photo','type','category','embed_code','start_at','status','created_at')->where('category',$pid)->orderBy('id', 'desc')->first();

                $return_array = [];
                if ($row){
                    $row->toArray();
                    if($row['cover_photo']){
                        $img = ImageStoreHelpers::showImage('gallery',$row['created_at'],$row['cover_photo'],'medium');
                    }else{
                        $img = 'https://img.youtube.com/vi/'.$row['embed_code'].'/hqdefault.jpg';
                    }
                    $return_array = [];
                    $return_array['id'] = $row['id'];
                    $return_array['title'] = $row['name'];
                    $return_array['caption'] = $row['caption'];
                    $return_array['image'] = $img;
                    $return_array['url'] = $row['embed_code'];
                    $return_array['category'] = $row['category'];
                }

                return $return_array;
            });
        }

        $gallery_17 = Cache::remember('oldAppgallery_17', 500, function(){
            $arr = Gallery::isActive()->select('id','name','caption','cover_photo','type','category','embed_code','start_at','status','created_at')->where('category',17)->orderBy('id', 'desc')->limit(10)->get()->toArray();
            $return_array = [];
            foreach($arr as $row){
                if($row['cover_photo']){
                    $img = ImageStoreHelpers::showImage('gallery',$row['created_at'],$row['cover_photo'],'medium');
                }else{
                    $img = 'https://img.youtube.com/vi/'.$row['embed_code'].'/hqdefault.jpg';
                }
                $stor = [];
                $stor['id'] = $row['id'];
                $stor['title'] = $row['name'];
                $stor['caption'] = $row['caption'];
                $stor['image'] = $img;
                $stor['category'] = $row['category'];
                $return_array[]=$stor;
            }
            return $return_array;
        });

        return response()->json([
            'ticker' => $ticker,
            'top_news' => $leadNews,
            'highlight' => $highlight,
            'focus_news' => $focus_items,
            'all_cat_news' => $all_cat_news,
            'latest_news' => $latest,
            'most_read' => $most_read,
            'news24_report' => $gallery_4,
            'tv_programs' => $gallery_program,
            'photo_gallery' => $gallery_17
        ]);
    }
    public function old_details($n_id){
        $details = Cache::remember('oldAppdetails-'.$n_id, 505, function() use($n_id){
            $row = News::with('catName')->isActive()->find($n_id);

            $ifOg = ($row->watermark!='') ? 'og' : '';
            $return_array['openGraphImg'] = ImageStoreHelpers::showImage('news_images',$row->created_at,$row->main_image,$ifOg);
            $return_array['meta_description'] = $row->meta_description ? strip_tags(html_entity_decode($row->meta_description)): generalHelper::splitText(strip_tags(html_entity_decode($row->n_details)), 400);

            if($row->edition=='online'){
                $edition = 'online';
            }else if($row->edition=='print'){
                $edition = 'print-edition';
            }else{
                $edition = 'feature';
            }


            $return_array['id'] = $row['n_id'];
            $return_array['title'] = $row['n_head'];
            $return_array['image'] = ImageStoreHelpers::showImage('news_images',$row['created_at'],$row['main_image'],'thumbnail');
            $return_array['author'] = $row['n_author'];
            $return_array['details'] = html_entity_decode($row['n_details']);
            $return_array['category'] = $row['n_category'];
            $return_array['datetime'] = $row['start_at'];
            $return_array['datetime_readable'] = $row['start_at'];
            $return_array['category_name'] = $row['catName']->m_name;
            $return_array['news_url'] = str_replace("bn-api.banglanews24.com","banglanews24.com",URL($edition.'/'.$row->catName->slug.'/'.date("Y/m/d", strtotime($row->start_at)).'/'.$row->n_id));
            return $return_array;
        });
        return response()->json([
            'news'=>$details
        ]);
    }
    public function old_categorynews($m_id,$p_id=1){
        $currentPage = $m_id.'-'.request()->get('page',1);
        $category = Cache::remember('oldAppcategory-' . $currentPage, 505, function() use($m_id) {
            $arr = News::with('catName')->isActive()->select('n_id','n_head','main_image','created_at','start_at','n_category','deleted_at')->where('n_category', $m_id)->orderBy('n_id', 'desc')->paginate(19);

            $return_array = [];
            foreach($arr as $row){
                $stor = [];
                $stor['id'] = $row['n_id'];
                $stor['title'] = $row['n_head'];
                $stor['image'] = ImageStoreHelpers::showImage('news_images',$row['created_at'],$row['main_image'],'thumbnail');
                $stor['datetime'] = $row['start_at'];
                $stor['category'] = $row['n_category'];
                $stor['category_name'] = $row['catName']->m_name;
                $return_array[]=$stor;
            }
            // $return['paginator'] = array('records'=>$total_news,'page'=>$page,'pageCount'=>$pageCount,'limit'=>$par_page,'prevPage'=>$prevPage,'nextPage'=>$nextPage);

            return [
                'cat_news' => $return_array,
                'hasMorePages' =>$arr->hasMorePages()
            ];
        });
        return response()->json($category);
    }

    public function appDetailsWebView($n_id){
        $details = Cache::remember('app_html_details-'.$n_id, 505, function() use($n_id){
            $sql = News::findNewsTable($n_id)->with(['catName','getWriters'])->isActive()->find($n_id);
            if($sql){
                $ifOg = ($sql->watermark!='') ? 'og' : '';
                $sql->openGraphImg = ImageStoreHelpers::showImage('news_images',$sql->created_at,$sql->main_image,$ifOg);
                $sql->n_solder = strip_tags(html_entity_decode($sql->n_solder));
                $sql->n_head = strip_tags(html_entity_decode($sql->n_head));
                $sql->n_subhead = strip_tags(html_entity_decode($sql->n_subhead));
                $sql->n_details = str_replace('/ckfinder/innerfiles/' , 'https://asset.banglanews24.com/public/news_images/ckfinder/innerfiles/' , htmlentities(html_entity_decode($sql->n_details)));
                $sql->main_image = ImageStoreHelpers::showImage('news_images',$sql->created_at,$sql->main_image,'');
                $sql->meta_description = $sql->meta_description ? strip_tags(html_entity_decode($sql->meta_description)): generalHelper::splitText(strip_tags(html_entity_decode($sql->n_details)), 400);


                if($sql->edition=='online'){
                    $edition = 'online';
                }else if(ed=='print'){
                    $edition = 'print-edition';
                }else{
                    $edition = 'feature';
                }

                $sql->n_url = URL($edition.'/'.$sql->catName->slug.'/'.date("Y/m/d", strtotime($sql->start_at)).'/'.$sql->n_id);
            }
            return $sql;
        });

        return response()->json(['details' => $details]);
    }

    public function my_news( $array="",$p_id=1 ){
        if(empty($array)){
            return '';
        }
        $array = explode("+",$array);
        $arr = News::with('catName')->isActive()->select('n_id','n_head','main_image','created_at','start_at','n_category','deleted_at')->whereIn('n_category', $array)->orderBy('n_id', 'desc')->paginate(19);

        $return_array = [];
        foreach($arr as $row){
            $stor = [];
            $stor['id'] = $row['n_id'];
            $stor['title'] = $row['n_head'];
            $stor['image'] = ImageStoreHelpers::showImage('news_images',$row['created_at'],$row['main_image'],'thumbnail');
            $stor['datetime'] = $row['start_at'];
            $stor['category'] = $row['n_category'];
            $stor['category_name'] = $row['catName']->m_name;
            $stor['summery'] = generalHelper::splitText($row['n_details'], 300);
            $return_array[]=$stor;
        }
        // $return['paginator'] = array('records'=>$total_news,'page'=>$page,'pageCount'=>$pageCount,'limit'=>$par_page,'prevPage'=>$prevPage,'nextPage'=>$nextPage);

        return response()->json([
            'my_news' => $return_array,
            'hasMorePages' =>$arr->hasMorePages()
        ]);
    }

    public function top_news(){
        $leadNews = Cache::remember('AppTopNews', 300, function(){
            $arr = News::with('catName')->isActive()->select('n_id','n_head','n_details','main_image','start_at','created_at','deleted_at','n_category')->where('home_lead',1)->orderBy('leadnews_order', 'desc')->limit(20)->get()->toArray();
            $return_array = [];
            foreach($arr as $row){
                $stor = [];
                $stor['id'] = $row['n_id'];
                $stor['title'] = $row['n_head'];
                $stor['image'] = ImageStoreHelpers::showImage('news_images',$row['created_at'],$row['main_image'],'thumbnail');
                $stor['datetime'] = $row['start_at'];
                $stor['category'] = $row['n_category'];
                $stor['category_name'] = $row['cat_name']['m_name'];
                $stor['summery'] = generalHelper::splitText($row['n_details'], 300);
                $return_array[]=$stor;
            }
            return $return_array;
        });

        return response()->json([
            'top_news' => $leadNews,
        ]);
    }


    
}
