<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Session;
use Redirect;
use App\Models\Ads;
use App\Models\Menu;
use App\Models\AdsPosition;
use App\Helpers\clearCacheHelpers;
use App\Http\Requests\AdsRequest;
use App\Helpers\ImageStoreHelpers;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $AdsPosition = AdsPosition::where('status',1)->get();
        return view('admin.ads.index', compact('AdsPosition'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $SelectAdsPosition = [];
        $Menus = Menu::where('m_status',1)->get();

        if ($request->input('position')) {
            $SelectAdsPosition = AdsPosition::select('name','slug')->where('slug',$request->input('position'))->first();
        }

        return view('admin.ads.create', compact('Menus','SelectAdsPosition'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdsRequest $request, ImageStoreHelpers $uploadImage, clearCacheHelpers $clearCacheHelpers)
    {
        $slot = $request->input('time_slot');
        $ad_img = '';

        $menus_id = ($request->input('menus_id')!='' && $request->input('menus_id')!='null')?json_encode($request->input('menus_id')):'all';

        foreach ($slot['start_date'] as $key => $value) {
            if ($slot['start_date'][$key]) {

                if ($request->file('ad_img')!='') {
                    $ad_img = $uploadImage->adImageUpload($request->file('ad_img'),date('Y-m-d'));
                }

                Ads::create([
                    'adtype' => $request->input('adtype'),
                    'name' => $request->input('name'),
                    'device' => $request->input('device'),
                    'page' => $request->input('page'),
                    'ads_positions_slug' => $request->input('ads_positions_slug'),
                    'menus_id' => $menus_id,
                    'n_id' => $request->input('n_id'),
                    'ad_condition' => $request->input('ad_condition'),
                    'ad_order' => $request->input('ad_order'),
                    'status' => $request->input('status'),
                    'start_date' => $slot['start_date'][$key],
                    'end_date' => $slot['end_date'][$key],
                    'ad_img' => $ad_img,
                    'ad_code' => $request->input('ad_code'),
                    'landing_url' => $request->input('landing_url'),
                    'head_code' => $request->input('head_code'),
                    'footer_code' => $request->input('footer_code'),
                    'time_schedule' => $slot['time_schedule'][$key],
                    'created_by' => Auth::user()->id,
                ]);
            }
        }

        $clearCacheHelpers->adStore($request);

        Session::flash('success', "Successfully Inserted");
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($version, Request $request)
    {
        $AdsSql = Ads::with(['adsPosition','createdBy','updatedBy'])->where('device',$version);

        if ($request->input('position')) {
            $AdsSql = $AdsSql->where('ads_positions_slug',$request->input('position'));
        }

        $Ads = $AdsSql->cursor();

        return view('admin.ads.show', compact('Ads'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ad = Ads::find($id);
        $Menus = Menu::where('m_status',1)->get();
        return view('admin.ads.edit', compact('ad','Menus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdsRequest $request, $id, ImageStoreHelpers $uploadImage, clearCacheHelpers $clearCacheHelpers)
    {
        $menus_id = ($request->input('menus_id')!='' && $request->input('menus_id')!='null')?json_encode($request->input('menus_id')):'all';

        $ad_img = $request->input('old_ad_img');

        if ($request->file('ad_img')!='') {
            $ad_img = $uploadImage->adImageEdit($request->file('ad_img'),$request->input('created_at'),$ad_img);
        }

        Ads::where('id', $id)->update([
            'adtype' => $request->input('adtype'),
            'name' => $request->input('name'),
            'device' => $request->input('device'),
            'page' => $request->input('page'),
            'ads_positions_slug' => $request->input('ads_positions_slug'),
            'menus_id' => $menus_id,
            'n_id' => $request->input('n_id'),
            'ad_condition' => $request->input('ad_condition'),
            'ad_order' => $request->input('ad_order'),
            'status' => $request->input('status'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'ad_img' => $ad_img,
            'ad_code' => $request->input('ad_code'),
            'landing_url' => $request->input('landing_url'),
            'head_code' => $request->input('head_code'),
            'footer_code' => $request->input('footer_code'),
            'time_schedule' => $request->input('time_schedule'),
            'updated_by' => Auth::user()->id,
        ]);
        
        $clearCacheHelpers->adUpdate($request);

        Session::flash('success', "Successfully Updated");
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, AdsRequest $request, ImageStoreHelpers $uploadImage, clearCacheHelpers $clearCacheHelpers)
    {
        $ad = Ads::find($id);
        if ($ad->ad_img!='') {
            $uploadImage->adImageDelete($ad->ad_img, $ad->created_at);
        }
        $ad->delete();

        $clearCacheHelpers->adDestroy($ad);
        
        Session::flash('success', "Successfully destroy");
        return Redirect::back();
    }
}
