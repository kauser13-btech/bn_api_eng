<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Session;
use Redirect;
use App\Models\Pool;
use App\Helpers\clearCacheHelpers;
use App\Http\Requests\PoolRequest;

class PoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pool = Pool::with(['createdBy', 'updatedBy'])->get();
        return view('admin.pool.index', compact('pool'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pool.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PoolRequest $request, clearCacheHelpers $clearCacheHelpers)
    {
        Pool::create([
            'text' => strip_tags($request->input('text')),
            'option_1' => htmlentities($request->input('option_1')),
            'option_2' => htmlentities($request->input('option_2')),
            'option_3' => htmlentities($request->input('option_3')),
            'start_date' => $request->input('start_date'),
            'p_status' => $request->input('p_status'),
            'created_by' => Auth::user()->id,
        ]);

        $clearCacheHelpers->poolStore();
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
        $pool = Pool::find($id);
        return view('admin.pool.edit', compact('pool'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PoolRequest $request, $id, clearCacheHelpers $clearCacheHelpers)
    {
        Pool::where('id', $id)->update([
            'text' => strip_tags($request->input('text')),
            'option_1' => htmlentities($request->input('option_1')),
            'option_2' => htmlentities($request->input('option_2')),
            'option_3' => htmlentities($request->input('option_3')),
            'start_date' => $request->input('start_date'),
            'p_status' => $request->input('p_status'),
            'updated_by' => Auth::user()->id,
        ]);

        $clearCacheHelpers->poolUpdate();

        Session::flash('success', "Successfully Updated");
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, PoolRequest $request, clearCacheHelpers $clearCacheHelpers)
    {
        Pool::where('id', $id)->delete();

        $clearCacheHelpers->poolDestroy();

        Session::flash('success', "Successfully Destroyed");
        return Redirect::back();
    }

    /**
     *
     * @Custom function Poll vote update
     */
    public function voteUpdate(Request $request, clearCacheHelpers $clearCacheHelpers)
    {
        if ($request->header('Authorization') === 'Basic base64:IqIxEkPjdl1Dnl9mjTKU6zTZD0') {
            $option = $request->input('poll');
            if ($option != '' && is_numeric($option)) {
                Pool::where('id', $request->input('id'))->increment('vote_' . $option, 30);
                $clearCacheHelpers->poolUpdate();
                return 1;
            } else {
                return 0;
            }
        }
    }
}
