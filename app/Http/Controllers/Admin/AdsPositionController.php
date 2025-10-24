<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

use Auth;
use Session;
use Redirect;
use App\Models\AdsPosition;
use App\Http\Requests\AdsPositionRequest;

class AdsPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $position = AdsPosition::with(['createdBy','updatedBy'])->get();
        return view('admin.adsposition.index',compact('position'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.adsposition.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdsPositionRequest $request)
    {
        AdsPosition::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'page' => $request->input('page'),
            'device' => $request->input('device'),
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
        $position = AdsPosition::find($id);
        return view('admin.adsposition.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdsPositionRequest $request, $id)
    {
        AdsPosition::where('id', $id)->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'page' => $request->input('page'),
            'device' => $request->input('device'),
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
    public function destroy($id, AdsPositionRequest $request)
    {
        // AdsPosition::where('id', $id)->update([
        //     'deleted_by' => Auth::user()->id,
        //     'deleted_at' => date('Y-m-d H:i:s'),
        // ]);
        // Session::flash('success', "Successfully Deleted");
        // return Redirect::back();
    }

    /**
     * Api Find Desktop or Mobile Position 
     *
     * @param   $device, $page
     */
    public function apiFindPosition($device, $page, $txt='')
    {
        $results[] = [];

        $sql = AdsPosition::where('device', $device)->where('page', $page);
        
        if ($txt!='' && $txt != 'undefined') {
            $sql = $sql->where('name', 'like', $txt.'%');
        }else{
            $results[] = [
                "id"=> '',
                "text"=> 'None'
            ];
        }
        $sql = $sql->limit(10)->get();

        foreach ($sql as $value) {
            // if($id == $value->id){continue;}

            $results[] = [
                "id"=> $value->slug,
                "text"=> $value->name
            ];
        }
        $arr = [
            "results" => $results
        ];

        return response()->json($arr);
    }

}
