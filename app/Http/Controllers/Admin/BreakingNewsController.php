<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Session;
use Redirect;
use App\Models\BreakingNews;
use App\Helpers\clearCacheHelpers;
use App\Http\Requests\BreakingNewsRequest;
use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

class BreakingNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = BreakingNews::with(['createdBy','updatedBy'])->get();
        return view('admin.breakingnews.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.breakingnews.create');
    }

    /**
     * Store a newly created resource in storage.t
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BreakingNewsRequest $request , clearCacheHelpers $clearCacheHelpers)
    {
        BreakingNews::create([
            'text' => htmlentities(strip_tags($request->input('text'))),
            'start_at' => $request->input('start_at'),
            'end_at' => $request->input('end_at'),
            'b_status' => $request->input('b_status'),
            'created_by' => Auth::user()->id,
        ]);

        $clearCacheHelpers->breakingNewsStore();

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
        $row = BreakingNews::find($id);
        return view('admin.breakingnews.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BreakingNewsRequest $request, $id, clearCacheHelpers $clearCacheHelpers)
    {
        BreakingNews::where('id', $id)->update([
            'text' => htmlentities(strip_tags($request->input('text'))),
            'start_at' => $request->input('start_at'),
            'end_at' => $request->input('end_at'),
            'b_status' => $request->input('b_status'),
            'updated_by' => Auth::user()->id,
        ]);

        $clearCacheHelpers->breakingNewsUpdate();

        Session::flash('success', "Successfully Updated");
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, BreakingNewsRequest $request, clearCacheHelpers $clearCacheHelpers)
    {
        BreakingNews::destroy($id);

        $clearCacheHelpers->breakingNewsDestroy();
        
        Session::flash('success', "Successfully Destroyed");
        return Redirect::back();
    }
}
