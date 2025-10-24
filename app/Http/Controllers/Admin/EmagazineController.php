<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\clearCacheHelpers;
use App\Helpers\ImageStoreHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Emagazine;
use App\Models\EmagazineCat;
use App\Http\Requests\EmagazineRequest;
use App\Http\Requests\EmagazineCatRequest;
use App\Models\PrintSettings;
use Auth;
use Session;
use Redirect;


class EmagazineController extends Controller
{

    public function catAdd()
    {
        $list = EmagazineCat::orderBy('id', 'desc')->paginate(15);
        return view('admin.emagazine.cat', compact('list'));
    }

    public function catStore(EmagazineCatRequest $request)
    {
        EmagazineCat::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'created_by' => Auth::user()->id,
        ]);

        Session::flash('success', "Successfully Destroyed");
        return Redirect::back();
    }

    public function catEdit($id)
    {
        $sql = EmagazineCat::find($id);
        return view('admin.emagazine.catEdit', compact('sql'));
    }

    public function catUpdate(EmagazineCatRequest $request)
    {
        EmagazineCat::where('id', $request->input('id'))->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'updated_by' => Auth::user()->id,
        ]);

        Session::flash('success', "Successfully Updated");
        return Redirect::back();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $magazineNewDate = PrintSettings::where('type', 'Magazine-New-Date')->orderBy('id', 'desc')->first();

        $sql = Emagazine::with('catName')->where('p_date',$magazineNewDate->pdate)->orderBy('page_id','ASC')->paginate(30);
        return view('admin.emagazine.index', compact('sql', 'magazineNewDate'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $magazineNewDate = PrintSettings::where('type', 'Magazine-New-Date')->orderBy('id', 'desc')->first();
        $catList = EmagazineCat::orderBy('id', 'desc')->limit(20)->get();
        return view('admin.emagazine.create', compact('catList', 'magazineNewDate'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmagazineRequest $request, ImageStoreHelpers $uploadImage, clearCacheHelpers $clearCacheHelpers)
    {
        $magazineNewDate = PrintSettings::where('type', 'Magazine-New-Date')->orderBy('id', 'desc')->first();

        $image = $uploadImage->emagazineUpload($request->file('image'), $magazineNewDate->pdate);

        Emagazine::create([
            'cat' => $request->input('cat'),
            'page_id' => $request->input('page_id'),
            'status' => $request->input('status'),
            'image' => $image,
            'p_date' => $magazineNewDate->pdate,
            'created_by' => Auth::user()->id,
        ]);

        // $clearCacheHelpers->EmagazineStore($request);

        Session::flash('success', "Successfully Inserted");
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, ImageStoreHelpers $uploadImage, clearCacheHelpers $clearCacheHelpers)
    {
        $row = Emagazine::find($id);
        $uploadImage->emagazineDelete($row->image,$row->p_date);
        $row->delete();
        $clearCacheHelpers->screenDestroy($row);
        Session::flash('success', "Successfully destroy");
        return Redirect::back();
    }

    function apiFindMagazineCat($txt)
    {
        $results[] = [];

        $sql = EmagazineCat::whereNotNull('name');

        if ($txt != '' && $txt != 'undefined') {
            $sql = $sql->where('name', 'like', $txt . '%');
        } else {
            $results[] = [
                "id" => '',
                "text" => 'None'
            ];
        }
        $sql = $sql->orderBy('id', 'desc')->get();

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
}
