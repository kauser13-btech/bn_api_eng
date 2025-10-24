<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Session;
use Redirect;
use App\Models\Screen;
use App\Helpers\clearCacheHelpers;
use App\Http\Requests\ScreenRequest;
use App\Helpers\ImageStoreHelpers;
use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

class ScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Screen::with(['createdBy','updatedBy'])->get();
        return view('admin.screen.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.screen.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScreenRequest $request, ImageStoreHelpers $uploadImage, clearCacheHelpers $clearCacheHelpers)
    {
        $cover_photo = $uploadImage->screenImageUpload($request->file('cover_photo'));

        Screen::create([
            'type' => $request->input('type'),
            'cover_photo' => $cover_photo,
            's_date' => date('Y-m-d'),
            'created_by' => Auth::user()->id,
        ]);

        $clearCacheHelpers->screenStore($request);

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
        exit;
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
        exit;
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ScreenRequest $request, $id)
    {
        exit;
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, ScreenRequest $request, ImageStoreHelpers $uploadImage, clearCacheHelpers $clearCacheHelpers)
    {
        $row = Screen::find($id);

        $uploadImage->screenImageDelete($row->cover_photo,$row->s_date);
        
        $row->delete();

        $clearCacheHelpers->screenDestroy($row);

        Session::flash('success', "Successfully destroy");
        return Redirect::back();
    }
}
