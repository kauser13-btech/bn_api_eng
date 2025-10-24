<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Auth;
use App\Models\Menu;
use App\Models\News;
use App\Models\User;
use App\Models\Ads;


class ReportController extends Controller
{
    public function dailyNewsReport(Request $request)
    {
        $rdate = $request->input('rdate');
        $range = $request->input('range');
        switch ($range) {
            case 0:
                $range_date = $rdate;
                break;
            case 1:
                $range_date = date('Y-m-d');
                break;
            case 2:
                $range_date = date('Y-m-d', strtotime('-1 days'));
                break;
            case 7:
            case 15:
            case 30:
            case 90:
                $range_date = date('Y-m-d', strtotime('-' . $range . ' days'));
                break;
            default:
                $range_date = $rdate;
                break;
        }

        $user = User::withCount([
            'total_posts' => function ($query) use ($range_date, $range) {
                if ($range == 0 || $range == 1 || $range == 2) {
                    $query->where('n_date', $range_date);
                } else {
                    $query->where('n_date', '>', $range_date);
                }
            },
            'total_update' => function ($query) use ($range_date, $range) {
                if ($range == 0 || $range == 1 || $range == 2) {
                    $query->where('n_date', $range_date);
                } else {
                    $query->where('n_date', '>', $range_date);
                }
            }
        ])
            ->withSum([
                'total_read' => function ($query) use ($range_date, $range) {
                    if ($range == 0 || $range == 1 || $range == 2) {
                        $query->where('n_date', $range_date);
                    } else {
                        $query->where('n_date', '>', $range_date);
                    }
                },
            ], 'most_read')
            ->where('status', 1)->where('role', '!=', 'subscriber')->get();
        // ->where('type','online')

        return view('admin.report.dailyNewsReport', compact('user', 'rdate', 'range_date'));
    }

    public function dailyTitleReport(Request $request)
    {
        $sdate = $request->input('sdate');        
        $edate = $request->input('edate');

        $news = News::select('n_id', 'n_solder', 'n_head', 'edition', 'n_details', 'main_image', 'start_at', 'created_at', 'deleted_at', 'n_category', 'most_read')->with(['createdBy', 'updatedBy', 'catName'])->where('edition', 'online')->whereBetween('n_date', [$sdate, $edate])->orderBy('n_id', 'ASC')->get();


        return view('admin.report.dailyTitleReport', compact('news', 'sdate', 'edate'));
    }

    public function monthlyNewsReport(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $user = [];
        if ($startDate != '' && $endDate != '') {
            $user = User::withCount([
                'total_posts' => function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('n_date', [$startDate, $endDate]);
                },
                'total_update' => function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('n_date', [$startDate, $endDate]);
                }
            ])
                ->withSum([
                    'total_read' => function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('n_date', [$startDate, $endDate]);
                    },
                ], 'most_read')
                ->where('status', 1)->where('role', '!=', 'subscriber')->get();
            // ->where('type','online')
        }
        return view('admin.report.monthlyNewsReport', compact('user', 'startDate', 'endDate'));
    }

    public function catReport(Request $request)
    {
        $range = $request->input('range');
        $rdate = $request->input('rdate');
        $cat = [];
        if ($range != 'null') {
            switch ($range) {
                case 0:
                    $range_date = 0;
                    break;
                case 1:
                    $range_date = date('Y-m-d');
                    break;
                case 2:
                    $range_date = date('Y-m-d', strtotime('-1 days'));
                    break;
                case 7:
                case 15:
                case 30:
                case 90:
                    $range_date = date('Y-m-d', strtotime('-' . $range . ' days'));
                    break;
                default:
                    $range_date = date('Y-m-d');
                    break;
            }

            $cat = Menu::withCount([
                'total_posts' => function ($query) use ($range_date, $range, $rdate) {
                    if ($range == 0) {
                        $g_date = explode("-", $rdate);
                        $year = $g_date[0];
                        $month = $g_date[1];
                        $query->whereMonth('n_date', '=', $month)->whereYear('n_date', '=', $year);
                    } elseif ($range == 1 || $range == 2) {
                        $query->where('n_date', $range_date);
                    } else {
                        $query->where('n_date', '>', $range_date);
                    }
                },
            ])
                ->withSum([
                    'total_read' => function ($query) use ($range_date, $range, $rdate) {
                        if ($range == 0) {
                            $g_date = explode("-", $rdate);
                            $year = $g_date[0];
                            $month = $g_date[1];
                            $query->whereMonth('n_date', '=', $month)->whereYear('n_date', '=', $year);
                        } elseif ($range == 1 || $range == 2) {
                            $query->where('n_date', $range_date);
                        } else {
                            $query->where('n_date', '>', $range_date);
                        }
                    },
                ], 'most_read')
                ->where('m_status', 1)->where('m_visible', 1)->where('m_edition', 'online')->orderBy('m_order', 'asc')->get();
            // ->where('type','online')
        }

        return view('admin.report.catReport', compact('cat', 'range'));
    }


    public function apiFindads($s_date, $e_date, $txt)
    {
        $results[] = [];

        $sql = Ads::where('ads_positions_slug', 'watermark-ad')->where(function ($query) use ($s_date, $e_date) {
            $query->whereBetween('start_date', [$s_date, $e_date])
                ->orWhereBetween('end_date', [$s_date, $e_date])
                ->orWhereNull('end_date');
        });

        if ($txt != '' && $txt != 'undefined') {
            $sql = $sql->where('name', 'like', $txt . '%');
        } else {
            $results[] = [
                "id" => '',
                "text" => 'None'
            ];
        }
        $sql = $sql->orderBy('id', 'desc')->take(100)->get();

        foreach ($sql as $value) {
            $results[] = [
                "id" => $value->id,
                "text" => $value->name
            ];
        }
        $arr = [
            "results" => $results
        ];



        return response()->json($arr);
    }

    public function watermarkAd(Request $request)
    {
        $s_date = $request->input('s_date');
        $e_date = $request->input('e_date');
        $watermark = $request->input('watermark');
        $newsList = [];

        // $watermark_ads = Ads::activeAd()->where('ads_positions_slug','watermark-ad')->orderBy('id','desc')->get();

        if ($watermark && $s_date && $e_date) {
            $newsList = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'start_at', 'watermark', 'created_by', 'created_at', 'deleted_at')->with(['createdBy', 'catName'])->whereBetween('n_date', [$s_date, $e_date])->where('watermark', $watermark)->get();
        }

        return view('admin.report.watermarkAd', compact('s_date', 'e_date', 'newsList'));
    }

    public function specialTag(Request $request)
    {
        $news_tags = $request->input('news_tags');
        $rdate = $request->input('rdate');
        $newsList = [];
        $g_date = explode("-", $rdate);
        $year = $g_date[0];
        $month = $g_date[1];

        if ($rdate && $news_tags) {
            $newsList = News::isActive()->select('n_id', 'n_head', 'n_category', 'edition', 'start_at', 'most_read', 'created_at', 'deleted_at')->with('catName')->whereMonth('n_date', '=', $month)->whereYear('n_date', '=', $year)->where('news_tags', $news_tags)->orderBy('most_read', 'desc')->get();
        }

        return view('admin.report.specialTag', compact('rdate', 'newsList'));
    }
}
