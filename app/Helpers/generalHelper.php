<?php

namespace App\Helpers;

use DateTime;
use App\Models\Menu;
use App\Models\News;
use App\Models\PrintSettings;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;

class generalHelper
{

    public static function bn_date($date)
    {
        $engDATE = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'ago', 'just now', 'second', 'minute', 'year');
        $bangDATE = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০', 'জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর', 'শনিবার', 'রবিবার', 'সোমবার', 'মঙ্গলবার', '
            বুধবার', 'বৃহস্পতিবার', 'শুক্রবার', 'আগে', 'এই মাত্র', 'সেকেন্ড', 'মিনিট', 'বছর');
        $convertedDATE = str_replace($engDATE, $bangDATE, $date);
        return $convertedDATE;
    }

    public static function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'বছর',
            'm' => 'মাস',
            'w' => 'সপ্তাহ',
            'd' => 'দিন',
            'h' => 'ঘণ্টা',
            'i' => 'মিনিট',
            's' => 'সেকেন্ড',
        );
        $engDATE = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
        $bangDATE = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০');
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = str_replace($engDATE, $bangDATE, $diff->$k) . ' ' . $v;
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' আগে' : 'এই মাত্র';
    }

    public static function splitText($text, $maxLength)
    {
        if (strlen($text) > $maxLength) {
            $replace = html_entity_decode($text);
            $replace = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $replace);
            $replace = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $replace);
            $replace = preg_replace("/<img[^>]+\>/i", "", $replace);
            $replace = preg_replace('/<iframe.*?\/iframe>/i', '', $replace);
            $replace = strip_tags($replace);
            $replace = preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $replace);
            $replace = preg_replace("/&#?[a-z0-9]+;/i","",$replace);
            return preg_replace('/\s+?(\S+)?$/', '', substr($replace, 0, $maxLength)) . '...';
        }
        return strip_tags(html_entity_decode($text));
    }

    public static function adMenuCheck($categoryName = null, $adCategoryData, $adCondition = 1)
    {
        if ($adCategoryData == 'all')
            return true;
        $menuArray = Cache::rememberForever('adMenuCheck', function () {
            $menu = Menu::where('m_status', 1)->select('m_id', 'slug')->get()->toArray();
            return $menu;
        });
        $key = array_search($categoryName, array_column($menuArray, 'slug'));
        $menuId = $menuArray[$key]['m_id'];
        $isMenu = in_array($menuId, json_decode($adCategoryData));
        if ($adCondition)
            return $isMenu;
        else
            return !$isMenu;
    }

    public static function desktopMenu()
    {
        $DesktopNav = Cache::rememberForever('desktopMenu', function () {
            $html = '';
            $menu = Menu::where('m_status', 1)->where('m_visible', 1)->where('m_parent', 0)->where('m_edition', 'online')->orderBy('m_order', 'ASC')->get();
            $i = 0;
            foreach ($menu as $row) {
                $submenu = Menu::where('m_parent', $row->m_id)->where('m_status', 1)->where('m_visible', 1)->where('m_edition', 'online')->orderBy('m_order', 'ASC')->get();

                if (count($submenu) == 0) {
                    $html .= '<li class="nav-item"><a class="nav-link" href="' . url("/online/" . $row->slug) . '">' . $row->m_name . '</a></li>';
                } else {
                    // $disableClick = ($row->slug=='others')?'role="button" data-bs-toggle="dropdown" aria-expanded="false"':'';
                    $html .= '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="' . url("/online/" . $row->slug) . '">' . $row->m_name . '</a>';
                    $html .= '<ul class="dropdown-menu dropdown-menu-right">';
                    foreach ($submenu as $value) {
                        $html .= '<li class="nav-item dropdown"><a class="dropdown-item" href="' . url("/online/" . $value->slug) . '">' . $value->m_name . '</a></li>';
                    }
                    $html .= '</ul>
                    </li>';
                }
                $i++;
            }
            return $html;
        });
        echo $DesktopNav;
    }

    public function todaysNewspaperMenu()
    {
        $pdate = self::getPublishDate('Publish-Print-New-Date');

        return Cache::rememberForever('todaysNewspaperMenu', function () use ($pdate) {
            $getMenuList = News::select('n_category')->where('edition', 'print')->where('n_date', $pdate)->groupBy('n_category')->get()->toArray();
            return Menu::select('m_id', 'm_name', 'slug', 'm_status', 'm_visible', 'm_order')->where('m_status', 1)->where('m_visible', 1)->whereIn('m_id', $getMenuList)->orderBy('m_order', 'ASC')->get();
        });
    }

    public static function appTodaysNewspaperMenu()
    {
        $pdate = self::getPublishDate('Publish-Print-New-Date');

        return Cache::rememberForever('todaysNewspaperMenu', function () use ($pdate) {
            $getMenuList = News::select('n_category')->where('edition', 'print')->where('n_date', $pdate)->groupBy('n_category')->get()->toArray();
            return Menu::select('m_id', 'm_name', 'slug', 'm_status', 'm_visible', 'm_order')->where('m_status', 1)->where('m_visible', 1)->whereIn('m_id', $getMenuList)->orderBy('m_order', 'ASC')->get();
        });
    }

    public static function mobileMenu()
    {
        $DesktopNav = Cache::rememberForever('mobileMenu', function () {
            $html = '';
            $menu = Menu::where('m_status', 1)->where('m_visible', 1)->where('m_parent', 0)->orderBy('m_order', 'ASC')->get();
            $i = 0;
            foreach ($menu as $row) {
                $submenu = Menu::where('m_parent', $row->m_id)->where('m_status', 1)->where('m_visible', 1)->orderBy('m_order', 'ASC')->get();

                if (count($submenu) == 0) {
                    $html .= '<li class="nav-item"><a class="nav-link" href="' . url("/online/" . $row->slug) . '">' . $row->m_name . '</a></li>';
                } else {
                    $html .= '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="' . url("/online/" . $row->slug) . '" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">' . $row->m_name . '</a>';
                    $html .= '<ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                    if ($row->slug != 'others') {
                        $html .= '<li><a class="dropdown-item" href="' . url("/online/" . $row->slug) . '">' . $row->m_name . '</a></li>';
                    }
                    foreach ($submenu as $value) {
                        $html .= '<li><a class="dropdown-item" href="' . url("/online/" . $value->slug) . '">' . $value->m_name . '</a></li>';
                    }
                    $html .= '</ul>
                    </li>';
                }
                $i++;
            }
            return $html;
        });
        echo $DesktopNav;
    }

    public static function amplify($html)
    {
        # Replace img, audio, and video elements with amp custom elements
        $html = stripslashes($html);
        $html = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
        $html = strip_tags($html, "<p><img><iframe>");
        $return = '';
        preg_match_all("/<iframe[^>]*src=[\"|']([^'\"]+)[\"|'][^>]*>/i", $html, $output);
        if (isset($output[1][0])) {

            $mystring = $output[1][0];
            $findme   = 'https://www.youtube.com/embed/';
            $pos = strpos($mystring, $findme);
            if ($pos === false) {
                $html = strip_tags($html, "<p><a><img>");
                $return = '';
            } else {
                $embed = str_replace("https://www.youtube.com/embed/", '', $output[1][0]);
                $get_embed = explode("?", $embed);
                $return = $get_embed[0];
            }
        }
        $html = preg_replace('/<iframe\s+.*?\.*?<\/iframe>/', '<iframe></iframe>', $html);

        $html = preg_replace('/\\<(.*?)(width="(.*?)")(.*?)(height="(.*?)")(.*?)\\>/i', '<$1$4$7>', $html);
        $html = preg_replace('/\\<(.*?)(height="(.*?)")(.*?)(width="(.*?)")(.*?)\\>/i', '<$1$4$7>', $html);
        $html = preg_replace('/(width|height)=["\']\d*["\']\s?/', "", $html);

        $html = str_ireplace(
            ['<img', '<video', '/video>', '<audio', '/audio>', '<iframe', '/iframe>'],
            ['<amp-img height="250" width="320" layout="responsive"', '<amp-video', '/amp-video>', '<amp-audio', '/amp-audio>', '<amp-youtube data-videoid="' . $return . '" height="250" width="320" layout="responsive"', '/amp-youtube>'],
            $html
        );
        # Add closing tags to amp-img custom element
        $html = preg_replace('/<amp-img(.*?)>/', '<amp-img$1></amp-img>', $html);
        // remove inline style
        $html = preg_replace('/ style[^>]*/', '', $html);
        // remove empty p tags
        $html = preg_replace("/<p[^>]*>[\s|&nbsp;]*<\/p>/", '', $html);
        $html = preg_replace("/&#?[a-z0-9]+;/i", "", $html);
        return $html;
    }

    public static function getSubmenus($m_id)
    {
        $menuList = Menu::where('m_parent', $m_id)->where('m_status', 1)->where('s_news', 1)->where('m_visible', 1)->orderBy('m_order', 'ASC')->pluck('m_id')->toArray();
        $menuList[] = (int) $m_id;
        return $menuList;
    }
    
    public static function getLiveParentId($n_id)
    {
        $news = News::where('n_id', $n_id)->first();
        if($news->is_live == 1) {
            return $news->n_id;
        }elseif($news->parent_id != 0){
            $parentNews = News::where('n_id', $news->parent_id)->first();
            if($parentNews) {
                return $parentNews->n_id;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public static function getParentId($m_id)
    {
        $parentmenu = Menu::where('m_id', $m_id)->where('m_status', 1)->where('m_visible', 1)->first();
        if ($parentmenu) {
            if ($parentmenu->m_parent == 0) {
                return $m_id;
            } else {
                return $parentmenu->m_parent;
            }
        }
        return $m_id;
    }

    // SEO Friendly Filter Function
    public static function slug($string)
    {
        $string = html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8');
        $string = trim($string); // Trim String
        $string = strtolower($string); //Unwanted:  {UPPERCASE} ; / ? : @ & = + $ , . ! ~ * ' ( )
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);  //Strip any unwanted characters
        $string = preg_replace("/[\s-]+/", " ", $string); // Clean multiple dashes or whitespaces
        $string = preg_replace("/[\s_]/", "-", $string); //Convert whitespaces and underscore to dash
        return $string;
    }

    public static function getPublishDate($type)
    {
        return Cache::remember('PublishDate-' . $type, 500, function () use ($type) {
            $EPaperPublishDate = PrintSettings::where('type', $type)->orderBy('id', 'desc')->first();
            return $EPaperPublishDate->pdate;
        });
    }

    public static function checkEdition($slug)
    {
        return Cache::remember('checkEdition-' . $slug, 500, function () use ($slug) {
            $edition = Menu::where('slug', $slug)->first();
            return $edition->m_edition;
        });
    }


    public static function quiz_list()
    {
        $quiz = [
            "12-10-2023" => ["q" => "ওয়ানডে ক্রিকেটে বর্তমান বিশ্বচ্যাম্পিয়ন কোন দল?", "op1" => "অস্ট্রেলিয়া", "op2" => "ভারত", "op3" => "ইংল্যান্ড", "op4" => "দক্ষিণ আফ্রিকা", "a" => "op3"],
            "13-10-2023" => ["q" => "প্রথম বিশ্বকাপের স্বাগতিক কোন দেশ?", "op1" => "ইংল্যান্ড", "op2" => "ওয়েস্ট ইন্ডিজ", "op3" => "অস্ট্রেলিয়া", "op4" => "ভারত", "a" => "op1"],
            "14-10-2023" => ["q" => "কোন বিশ্বকাপে পাকিস্তানকে হারিয়েছিল বাংলাদেশ?", "op1" => "২০০৭", "op2" => "২০১১", "op3" => "১৯৯৯", "op4" => "২০১৯", "a" => "op3"],
            "15-10-2023" => ["q" => "বিশ্বকাপে বাংলাদেশের প্রথম ম্যান অব দ্য ম্যাচ কে?", "op1" => "সাকিব আল হাসান", "op2" => "খালেদ মাহমুদ", "op3" => "মাহমুদ উল্লাহ", "op4" => "মিনহাজুল আবেদীন নান্নু", "a" => "op4"],
            "16-10-2023" => ["q" => "বিশ্বকাপে বাংলাদেশের পক্ষে প্রথম সেঞ্চুরি করেন কে?", "op1" => "তামিম ইকবাল", "op2" => "মাহমুদ উল্লাহ", "op3" => "সাকিব আল হাসান", "op4" => "মুশফিকুর রহিম", "a" => "op2"],
            "17-10-2023" => ["q" => "সবচেয়ে বেশিবার বিশ্বকাপ জিতেছে কোন দল?", "op1" => "ওয়েস্ট ইন্ডিজ", "op2" => "ইংল্যান্ড", "op3" => "অস্ট্রেলিয়া", "op4" => "ভারত", "a" => "op3"],
            "18-10-2023" => ["q" => "২০২৩ বিশ্বকাপে ভারতের মোট কয়টি ভেন্যুতে খেলা হবে?", "op1" => "৮টি", "op2" => "১০টি", "op3" => "৯টি", "op4" => "১১টি", "a" => "op2"],
            "19-10-2023" => ["q" => "বিশ্বকাপে বাংলাদেশের পক্ষে সবচেয়ে বেশি রান করেন কে?", "op1" => "মাহমুদ উল্লাহ", "op2" => "মুশফিকুর রহিম", "op3" => "মোহাম্মদ আশরাফুল", "op4" => "সাকিব আল হাসান", "a" => "op4"],
            "20-10-2023" => ["q" => "বিশ্বকাপে বাংলাদেশের পক্ষে সবচেয়ে বেশি উইকেট পান কে?", "op1" => "মাশরাফি বিন মর্তুজা", "op2" => "মোহাম্মদ রফিক", "op3" => "সাকিব আল হাসান", "op4" => "তাসকিন আহমেদ", "a" => "op3"],
            "21-10-2023" => ["q" => "বিশ্বকাপের প্রথম আসর বসেছিল কত সালে?", "op1" => "১৯৭৩", "op2" => "১৯৭৫", "op3" => "১৯৮১", "op4" => "১৯৮৩", "a" => "op2"],
            "22-10-2023" => ["q" => "২০২৩ বিশ্বকাপে মোট কয়টি দল অংশ নিচ্ছে?", "op1" => "১০", "op2" => "১২", "op3" => "১৩", "op4" => "১৪", "a" => "op1"],
            "23-10-2023" => ["q" => "বিশ্বকাপের প্রথম হ্যাটট্রিক করেছেন কোন বোলার?", "op1" => "মাইকেল হোল্ডিং", "op2" => "শেন ওয়ার্ন", "op3" => "চেতন শর্মা", "op4" => "ওয়াসিম আকরাম", "a" => "op3"],
            "24-10-2023" => ["q" => "সবচেয়ে বেশিবার চ্যাম্পিয়ন দলের সদস্য ছিলেন কোন ক্রিকেটার?", "op1" => "ভিভ রিচার্ডস", "op2" => "শচীন টেন্ডুলকার", "op3" => "শেন ওয়ার্ন", "op4" => "রিকি পন্টিং", "a" => "op4"],
            "25-10-2023" => ["q" => "২০০৭ বিশ্বকাপে বাংলাদেশ দল কয়টি ম্যাচ জিতেছিল?", "op1" => "২", "op2" => "৩", "op3" => "৪", "op4" => "৫", "a" => "op2"],
            "26-10-2023" => ["q" => "প্রথম তিনটি বিশ্বকাপ কোন দেশে অনুষ্ঠিত হয়েছে?", "op1" => "ওয়েস্ট ইন্ডিজ", "op2" => "ইংল্যান্ড", "op3" => "ভারত", "op4" => "অস্ট্রেলিয়া", "a" => "op2"],
            "27-10-2023" => ["q" => "উপমহাদেশে প্রথম বিশ্বকাপ অনুষ্ঠিত হয় কত সালে?", "op1" => "১৯৮৭", "op2" => "১৯৯২", "op3" => "১৯৯৬", "op4" => "২০১১", "a" => "op1"],
            "28-10-2023" => ["q" => "বিশ্বকাপে সর্বোচ্চ রানের রেকর্ডটি কার?", "op1" => "বিরাট কোহলি", "op2" => "রিটি পন্টিং", "op3" => "রোহিত শর্মা", "op4" => "শচীন টেন্ডুলকার", "a" => "op4"],
            "29-10-2023" => ["q" => "২০২৩ বিশ্বকাপে প্রথম সেঞ্চুরি কার?", "op1" => "রাচিন রবীন্দ্র", "op2" => "ডেভন কনওয়ে", "op3" => "কুইন্টন ডি কক", "op4" => "বিরাট কোহলি", "a" => "op2"],
            "30-10-2023" => ["q" => "বাংলাদেশের কতজন আম্পায়ার এবারের বিশ্বকাপে ম্যাচ পরিচালনা করেছেন?", "op1" => "৩", "op2" => "২", "op3" => "১", "op4" => "৪", "a" => "op3"],
            "31-10-2023" => ["q" => "এই বিশ্বকাপে কোন দলের তিনজন এক ম্যাচে সেঞ্চুরি করেছেন?", "op1" => "দক্ষিণ আফ্রিকা", "op2" => "নিউজিল্যান্ড", "op3" => "ভারত", "op4" => "অস্ট্রেলিয়া", "a" => "op1"],
            "01-11-2023" => ["q" => "এবার ইংল্যান্ডকে কত রানের ব্যবধানে হারিয়েছে দক্ষিণ আফ্রিকা?", "op1" => "৩০১", "op2" => "১৯২", "op3" => "২২৩", "op4" => "২২৯", "a" => "op4"],
            "02-11-2023" => ["q" => "বিশ্বকাপে আফগানিস্তানকে কতবার হারিয়েছে বাংলাদেশ দল?", "op1" => "১", "op2" => "২", "op3" => "৩", "op4" => "৪", "a" => "op3"],
            "03-11-2023" => ["q" => "২০২৩ বিশ্বকাপের উদ্বোধনী ম্যাচে মুখোমুখি হয়েছিল কোন দুই দল?", "op1" => "ভারত-পাকিস্তান", "op2" => "বাংলাদেশ-আফগানিস্তান", "op3" => "ইংল্যান্ড-অস্ট্রেলিয়া", "op4" => "ইংল্যান্ড-নিউজিল্যান্ড", "a" => "op4"],
            "04-11-2023" => ["q" => "২০২৩ বিশ্বকাপে বাংলাদেশের প্রথম প্রতিপক্ষ ছিল কোন দল?", "op1" => "ভারত", "op2" => "আফগানিস্তান", "op3" => "নিউজিল্যান্ড", "op4" => "দক্ষিণ আফ্রিকা", "a" => "op2"],
            "05-11-2023" => ["q" => "২০১৯ বিশ্বকাপের প্লেয়ার অব দ্য টুর্নামেন্ট কে হয়েছিলেন?", "op1" => "সাকিব আল হাসান", "op2" => "বেন স্টোকস", "op3" => "রোহিত শর্মা", "op4" => "কেন উইলিয়ামসন", "a" => "op4"],
            "06-11-2023" => ["q" => "২০০৭ বিশ্বকাপে ভারতের বিপক্ষে ম্যাচসেরা হয়েছিলেন কে?", "op1" => "তামিম ইকবাল", "op2" => "মাশরাফি বিন মর্তুজা", "op3" => "সাকিব আল হাসান", "op4" => "মুশফিকুর রহিম", "a" => "op2"],
            "07-11-2023" => ["q" => "রঙিন পোশাকের প্রথম বিশ্বকাপ কোন সালে?", "op1" => "১৯৮৭", "op2" => "১৯৯২", "op3" => "১৯৯৬", "op4" => "১৯৯৯", "a" => "op2"],
            "08-11-2023" => ["q" => "ক্রিকেটে ‘চোকার্স’ বলা হয় কোন দলকে?", "op1" => "নিউজিল্যান্ড", "op2" => "অস্ট্রেলিয়া", "op3" => "দক্ষিণ আফ্রিকা", "op4" => "পাকিস্তান", "a" => "op3"],
            "09-11-2023" => ["q" => "২০২৩ বিশ্বকাপের ফাইনাল অনুষ্ঠিত হবে কোন মাঠে?", "op1" => "ইডেন গার্ডেনস", "op2" => "চিন্নাস্বামী স্টেডিয়াম", "op3" => "অরুণ জেটলি স্টেডিয়াম", "op4" => "নরেন্দ্র মোদি স্টেডিয়াম", "a" => "op4"],
            "10-11-2023" => ["q" => "এবারের বিশ্বকাপে শচীন টেন্ডুলকারের কোন রেকর্ড ছুঁয়েছেন বিরাট কোহলি?", "op1" => "আন্তর্জাতিক রান", "op2" => "ওয়ানডে সেঞ্চুরি", "op3" => "সর্বোচ্চ ইনিংস", "op4" => "সবচেয়ে বেশি বিশ্বকাপ ম্যাচ", "a" => "op2"],
            "11-11-2023" => ["q" => "আন্তর্জাতিক ক্রিকেটে প্রথমবার টাইমড আউট হওয়া ব্যাটারের নাম কী?", "op1" => "অ্যাঞ্জেলো ম্যাথুস", "op2" => "পাথুম নিশাঙ্কা", "op3" => "সাকিব আল হাসান", "op4" => "কুশল মেন্ডিস", "a" => "op1"],
            "12-11-2023" => ["q" => "২০২৩ বিশ্বকাপে সবার আগে কোন দল সেমিফাইনাল নিশ্চিত করেছে?", "op1" => "দক্ষিণ আফ্রিকা", "op2" => "অস্ট্রেলিয়া", "op3" => "ভারত", "op4" => "নিউজিল্যান্ড", "a" => "op3"],
            "13-11-2023" => ["q" => "২০২৩ বিশ্বকাপের আগে পর্যন্ত সেরা বোলিং ফিগার কার?", "op1" => "উইনস্টন ডেভিস", "op2" => "মোহাম্মদ সামি", "op3" => "গ্লেন মাকগ্রা", "op4" => "মুত্তিয়া মুরালিধরন", "a" => "op3"],
            "14-11-2023" => ["q" => "ওয়ানডে বিশ্বকাপের প্রথম হ্যাটট্রিকটি কে করেছেন?", "op1" => "কপিল দেব", "op2" => "কোর্টনি ওয়ালশ", "op3" => "ওয়াসিম আকরাম", "op4" => "চেতন শর্মা", "a" => "op4"],
            "15-11-2023" => ["q" => "এবারের আগে কোন ওয়ানডে বিশ্বকাপে সবচেয়ে বেশি ছক্কা মারা হয়েছিল?", "op1" => "২০০৩", "op2" => "২০০৭", "op3" => "২০১১", "op4" => "২০১৫", "a" => "op4"],
            "16-11-2023" => ["q" => "২০২৩ আসরের আগে বিশ্বকাপে মোট কয়টি ম্যাচ জিতেছিল আফগানিস্তান?", "op1" => "১", "op2" => "২", "op3" => "৩", "op4" => "৪", "a" => "op1"],
            "17-11-2023" => ["q" => "বিশ্বকাপে সর্বনিম্ন ইনিংস কোন দলের?", "op1" => "বাংলাদেশ", "op2" => "কেনিয়া", "op3" => "কানাডা", "op4" => "শ্রীলঙ্কা", "a" => "op3"],
            "18-11-2023" => ["q" => "বিশ্বকাপে দ্রুততম সেঞ্চুরিটি কার?", "op1" => "শহিদ আফ্রিদি", "op2" => "রোহিত শর্মা", "op3" => "রাসি ফন ডার ডুসেন", "op4" => "গ্লেন ম্যাক্সওয়েল", "a" => "op4"],
            "19-11-2023" => ["q" => "বিশ্বকাপে মাহমুদ উল্লাহর মোট সেঞ্চুরি কয়টি?", "op1" => "১", "op2" => "২", "op3" => "৩", "op4" => "৪", "a" => "op3"],
            "20-11-2023" => ["q" => "২০২৩ বিশ্বকাপে শ্রীলঙ্কাকে কত উইকেটে হারিয়েছে বাংলাদেশ?", "op1" => "১", "op2" => "২", "op3" => "৩", "op4" => "৪", "a" => "op3"],
            "21-11-2023" => ["q" => "বিশ্বকাপে টানা চার ম্যাচে সেঞ্চুরি করেছেন একজন ব্যাটার। তিনি কে?", "op1" => "কুমার সাঙ্গাকারা", "op2" => "শচীন টেন্ডুলকার", "op3" => "রিকি পন্টিং", "op4" => "রোহিত শর্মা", "a" => "op1"],
            "22-11-2023" => ["q" => "বিশ্বকাপে আফগানিস্তানের প্রথম সেঞ্চুরিয়ান কে?", "op1" => "রহমানউল্লাহ গুরবাজ", "op2" => "ইব্রাহিম জাদরান", "op3" => "হাশমতউল্লাহ শহীদি", "op4" => "রশিদ খান", "a" => "op2"],
        ];

        return $quiz;
    }

    public static function getTodaysQuize()
    {
        $today = Date('d-m-Y');
        $quiz = self::quiz_list()[$today];

        return $quiz;
    }


    public static function checkQuiz($answer)
    {
        $today = Date('d-m-Y');
        $quiz = self::quiz_list()[$today];

        return $quiz['a'] == $answer ? 1 : 0;
    }

    public static function getImageAsData($url)
    {
        $url = $url;
        $image = file_get_contents($url);
        if ($image !== false) {
            return 'data:image/jpg;base64,' . base64_encode($image);
        }
    }
}
