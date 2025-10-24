<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Session;
use Redirect;
use App\Models\Writers;
use App\Http\Requests\WritersRequest;
use App\Helpers\clearCacheHelpers;
use App\Http\Controllers\Controller;
use App\Helpers\ImageStoreHelpers;
// use Illuminate\Http\Request;

class WritersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Writers::with(['createdBy','updatedBy'])->orderBy('w_order', 'asc')->get();
        return view('admin.writers.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WritersRequest $request, ImageStoreHelpers $uploadImage)
    {
        $img = $uploadImage->profileImageUpload($request->file('img'),date('Y-m-d'),'');
        
        Writers::create([
            'name' => htmlentities($request->input('name')),
            'profession' => htmlentities($request->input('profession')),
            'w_order' => $request->input('w_order'),
            'details' => htmlentities($request->input('details')),
            'img' => $img,
            'type' => $request->input('type'),
            'status' => $request->input('status'),
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WritersRequest $request, $id, ImageStoreHelpers $uploadImage)
    {
        $img = $request->file('img') ? $uploadImage->profileImageUpload($request->file('img'),$request->input('created_at'),$request->input('old_img')):$request->input('old_img');
        
        Writers::where('id', $id)->update([
            'name' => htmlentities($request->input('name')),
            'profession' => htmlentities($request->input('profession')),
            'w_order' => $request->input('w_order'),
            'details' => htmlentities($request->input('details')),
            'img' => $img,
            'type' => $request->input('type'),
            'status' => $request->input('status'),
            'updated_by' => Auth::user()->id,
        ]);
        Session::flash('success', "Successfully Updated");
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
