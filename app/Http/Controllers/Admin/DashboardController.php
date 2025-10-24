<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Session;
use Redirect;
use App\Models\User;
use App\Models\Ads;
use App\Models\News;
use Illuminate\Http\Request;
use App\Models\Miscellaneous;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ImageStoreHelpers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $userSql = User::where('status', '1');

        $newsSql = News::with(['createdBy', 'updatedBy', 'catName']);

        if ($request->get('n_date')) {
            $newsSql = $newsSql->newsTable(date('Y', strtotime($request->get('n_date'))));
        }

        if ($request->get('n_head')) {
            // $newsSql->where('n_head',$request->get('n_head'));
            $newsSql->where('n_head', 'like', '%' . $request->get('n_head') . '%');
        }
        if ($request->get('n_id')) {
            $newsSql->findNewsTable($request->get('n_id'))->where('n_id', $request->get('n_id'));
        }
        if ($request->has('n_status')) {
            $newsSql->where('n_status', $request->get('n_status'));
        }
        if ($request->get('user_id')) {
            $newsSql->where('created_by', $request->get('user_id'));
        }
        if ($request->get('n_date')) {
            $newsdate = $request->get('n_date');
            $newsSql->where('n_date', $newsdate);
        } else {
            $newsdate = date('Y-m-d');
        }

        if (Auth::user()->type == 'online') {
            $newsSql = $newsSql->whereIn('edition', ['online', 'multimedia']);
            $userSql = $userSql->where('type', 'online');
        } elseif (Auth::user()->type == 'print') {
            $newsSql = $newsSql->whereIn('edition', ['print', 'magazine']);
            $userSql = $userSql->where('type', 'print');
        }

        $news = $newsSql->orderBy('start_at', 'desc')->paginate(300);
        $user = $userSql->get();

        return view('admin.dashboard', compact('news', 'newsdate', 'user'));
    }

    public function profile()
    {
        $watermark_ads = Ads::activeAd()->where('ads_positions_slug', 'watermark-ad')->orderBy('id', 'desc')->get();
        return view('admin.profile', compact('watermark_ads'));
    }

    public function profileUpdate(Request $request, ImageStoreHelpers $uploadImage)
    {
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'profile_img' => 'nullable|mimes:jpg,png,gif',
        ]);

        if ($request->input('password')) {
            $password = Hash::make($request->input('password'));
        } else {
            $password = Auth::user()->password;
        }

        $profile_img = $request->file('profile_img') ? $uploadImage->profileImageUpload($request->file('profile_img'), Auth::user()->created_at, Auth::user()->img) : Auth::user()->img;

        User::where('id', Auth::user()->id)->update([
            'name' => $request->input('name'),
            'password' => $password,
            'img' => $profile_img,
            'designation' => $request->input('designation'),
            'folder_location' => $request->input('folder_location'),
            'watermark_ad' => $request->input('watermark_ad'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($request->input('all_user') == 'allpfolder') {
            User::where('type', 'print')->where('status', 1)->update([
                'folder_location' => $request->input('folder_location'),
            ]);
        }

        Session::flash('success', "Successfully Updated");
        return Redirect::back();
    }

    public function error403()
    {
        return view('admin.errorPage');
    }

    public function electionResult()
    {
        $top10news = Miscellaneous::where('status', 1)->where('type', 'election')->first();
        return view('admin.miscellaneous.electionResult', compact('top10news'));
    }

    public function watermarkAd()
    {
        $watermark_ads = Ads::activeAd()->where('ads_positions_slug', 'watermark-ad')->orderBy('id', 'desc')->get();
        $activeAd = Miscellaneous::where('status', 1)->where('id', 2)->first();
        return view('admin.miscellaneous.watermarkAd', compact('watermark_ads', 'activeAd'));
    }

    public function miscellaneousUpdate(Request $request)
    {
        if (Auth::user()->role == 'subscriber') {
            Session::flash('unauthorized', "403 | This action is unauthorized.");
            return Redirect::back();
        }
        $id = $request->get('id');
        Miscellaneous::where('id', $id)->update([
            'arr_data' => json_encode($request->input('arr_data')),
        ]);
        Cache::forget('electionResult');
        Session::flash('success', "Successfully Updated");
        return Redirect::back();
    }
}
