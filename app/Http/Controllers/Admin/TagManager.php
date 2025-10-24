<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Session;
use Redirect;
use App\Models\Tag;
use App\Http\Controllers\Controller;
use App\Helpers\ImageStoreHelpers;
use Illuminate\Http\Request;

class TagManager extends Controller
{
    public function index()
    {
        $list = Tag::with(['createdBy','updatedBy'])->orderBy('id', 'asc')->get();
        return view('admin.tag.index', compact('list'));
    }

    public function store(Request $request, ImageStoreHelpers $uploadImage)
    {
        $request->validate([
            'name' => 'required',
            'img' => 'nullable|mimes:jpg,png,gif',
        ]);

        $img = $request->file('img') ? $uploadImage->tagImgUpload($request->file('img'),date('Y-m-d'),'') :'';
        
        Tag::create([
            'name' => htmlentities($request->input('name')),
            'details' => htmlentities($request->input('details')),
            'img' => $img,
            'status' => $request->input('status'),
            'created_by' => Auth::user()->id,
        ]);
        Session::flash('success', "Successfully Inserted");
        return Redirect::back();
    }

    public function update(Request $request, $id, ImageStoreHelpers $uploadImage)
    {
        $request->validate([
            'name' => 'required',
            'img' => 'nullable|mimes:jpg,png,gif',
        ]);
        
        $img = $request->file('img') ? $uploadImage->tagImgUpload($request->file('img'),$request->input('created_at'),$request->input('old_img')):$request->input('old_img');
        
        Tag::where('id', $id)->update([
            'name' => htmlentities($request->input('name')),
            'details' => htmlentities($request->input('details')),
            'img' => $img,
            'status' => $request->input('status'),
            'updated_by' => Auth::user()->id,
        ]);
        Session::flash('success', "Successfully Updated");
        return Redirect::back();
    }

    public function apiFindTags($txt){
        $results[] = [];

        $sql = Tag::where('status', 1);
        
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
            $results[] = [
                "id"=> $value->id,
                "text"=> $value->name
            ];
        }
        $arr = [
            "results" => $results
        ];

        return response()->json($arr);
    }
}
