<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Session;
use Redirect;
use App\Models\Astrology;
use App\Helpers\generalHelper;
use App\Helpers\clearCacheHelpers;
use App\Http\Requests\AstrologyRequest;

class AstrologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $EPaperNewDate = generalHelper::getPublishDate('E-Paper-New-Date');
        $sql = Astrology::with(['createdBy', 'updatedBy'])->where('start_date', $EPaperNewDate)->orderBy('p_order', 'ASC')->get();
        return view('admin.astrology.index', compact('sql', 'EPaperNewDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $EPaperNewDate = generalHelper::getPublishDate('E-Paper-New-Date');
        return view('admin.astrology.create', compact('EPaperNewDate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AstrologyRequest $request)
    {
        $astrologyOrder = ['Aries' => 1, 'Taurus' => 2, 'Gemini' => 3, 'Cancer' => 4, 'Leo' => 5, 'Virgo' => 6, 'Libra' => 7, 'Scorpio' => 8, 'Sagittarius' => 9, 'Capricorn' => 10, 'Aquarius' => 11, 'Pisces' => 12,];

        Astrology::create([
            'text' => htmlentities($request->input('text')),
            'category' => $request->input('category'),
            'start_date' => $request->input('start_date'),
            'p_order' => $astrologyOrder[$request->input('category')],
            'p_status' => $request->input('p_status'),
            'created_by' => Auth::user()->id,
        ]);

        Session::flash('success', "Successfully Inserted");
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sql = Astrology::find($id);
        return view('admin.astrology.edit', compact('sql'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, clearCacheHelpers $clearCacheHelpers)
    {

        Astrology::where('id', $id)->update([
            'text' => htmlentities($request->input('text')),
            'category' => $request->input('category'),
            'start_date' => $request->input('start_date'),
            'p_order' => $request->input('p_order'),
            'p_status' => $request->input('p_status'),
            'updated_by' => Auth::user()->id,
        ]);

        $clearCacheHelpers->astrologyCache();

        Session::flash('success', "Successfully Updated");
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, clearCacheHelpers $clearCacheHelpers)
    {

        Astrology::where('id', $id)->delete();

        $clearCacheHelpers->astrologyCache();

        Session::flash('success', "Successfully Destroyed");
        return Redirect::back();
    }
}
