<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Session;
use Redirect;
use App\Models\Ads;
use App\Models\User;
use App\Models\Gallery;
use App\Helpers\clearCacheHelpers;
use App\Models\GalleryCategory;
use App\Helpers\ImageStoreHelpers;
use App\Http\Requests\GalleryRequest;

class GalleryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$photo = Gallery::with(['catName','createdBy','updatedBy'])->where('type','photo')->orderBy('id', 'desc')->paginate(300);
		$video = Gallery::with(['catName','createdBy','updatedBy'])->where('type','video')->orderBy('id', 'desc')->paginate(300);
		return view('admin.gallery.index', compact('photo','video'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$watermark_ads = Ads::activeAd()->where('ads_positions_slug','watermark-ad')->orderBy('id','desc')->get();
		return view('admin.gallery.create',compact('watermark_ads'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(GalleryRequest $request, ImageStoreHelpers $uploadImage, clearCacheHelpers $clearCacheHelpers)
	{
		$images = [];
		$i=0;
		if($request->file('images')){
			foreach ($request->file('images') as $image) {
				$arr = [];
				$arr['image'] = $uploadImage->galleryImageUpload($image,date('Y-m-d'));
				$arr['text'] = trim($request->input('cap')[$i]) ? strip_tags($request->input('cap')[$i]):'';
				$images[] = $arr;
				$i++;
			}
		}

		$cover_photo = $uploadImage->galleryImageUpload($request->file('cover_photo'),date("Y-m-d"), '',$request->input('watermark'));

		$sql = Gallery::create([
			'name' => strip_tags($request->input('name')),
			'caption' => strip_tags($request->input('caption')),
			'cover_photo' => $cover_photo,
			'type' => $request->input('type'),
			'category' => $request->input('category'),
			'images' => serialize($images),
			'embed_code' => htmlentities($request->input('embed_code')),
			'title_info' => $request->input('title_info'),
			'keywords' => $request->input('keywords'),
			'description' => strip_tags($request->input('description')),
			'start_at' => $request->input('start_at'),
			'special_video' => $request->input('special_video')?$request->input('special_video'):0,
			'slide_video' => $request->input('slide_video')?$request->input('slide_video'):0,
			'status' => $request->input('status'),
			'watermark' => $request->input('watermark'),
            'created_by' => Auth::user()->id,
		]);

		$sql->g_order = $sql->id;
		$sql->save();

		$clearCacheHelpers->galleryStore($request);

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
		$gallery = Gallery::find($id);
		$watermark_ads = Ads::where('id',$gallery->watermark)->first();

		return view('admin.gallery.edit', compact('gallery', 'watermark_ads'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(GalleryRequest $request, $id, ImageStoreHelpers $uploadImage, clearCacheHelpers $clearCacheHelpers)
	{
		$old_img = $request->input('old_img');
		$old_cap = $request->input('old_cap');
		$del_img = $request->input('del')?$request->input('del'):[];
		$images = [];

		if ($old_img) {
			$n=0;
			foreach ($old_img as $value) {
				if (in_array($value, $del_img)) {
					$uploadImage->galleryImageDelete($value,$request->input('created_at'));
				}else{
					$new = [];
					$new['image'] = $value;
					$new['text'] = $old_cap[$n];
					$images[] = $new;
				}
				$n++;
			}
		}

		if($request->file('images')){
			$i=0;
			foreach ($request->file('images') as $image) {
				$arr = [];
				$arr['image'] = $uploadImage->galleryImageUpload($image,$request->get('created_at'));
				$arr['text'] = trim($request->input('cap')[$i]) ? strip_tags($request->input('cap')[$i]):'';
				$images[] = $arr;
				$i++;
			}
		}

		if($request->file('cover_photo')){
			$cover_photo = $uploadImage->galleryImageUpload($request->file('cover_photo'), $request->get('created_at'), $request->input('old_cover_photo'), $request->input('watermark'));
			$uploadImage->galleryImageDelete($request->input('old_cover_photo'),$request->input('created_at'));
		}else{
			$cover_photo = $request->input('old_cover_photo');
		}

		Gallery::where('id', $id)->update([
			'name' => strip_tags($request->input('name')),
			'caption' => strip_tags($request->input('caption')),
			'cover_photo' => $cover_photo,
			'type' => $request->input('type'),
			'category' => $request->input('category'),
			'images' => serialize($images),
			'embed_code' => htmlentities($request->input('embed_code')),
			'title_info' => $request->input('title_info'),
			'keywords' => $request->input('keywords'),
			'description' => strip_tags($request->input('description')),
			'special_video' => $request->input('special_video')?$request->input('special_video'):0,
			'slide_video' => $request->input('slide_video')?$request->input('slide_video'):0,
			'status' => $request->input('status'),
			'watermark' => $request->input('watermark'),
            'updated_by' => Auth::user()->id,
		]);

		$clearCacheHelpers->galleryUpdate($request);

        Session::flash('success', "Successfully Inserted");
        return Redirect::back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id, GalleryRequest $request, ImageStoreHelpers $uploadImage, clearCacheHelpers $clearCacheHelpers)
	{
		$row = Gallery::find($id);

		$uploadImage->galleryImageDelete($row->cover_photo,$row->created_at);

		if($row->images){
			foreach (unserialize($row->images) as $value) {
				$uploadImage->galleryImageDelete($value['image'],$row->created_at);
			}
		}
		
		$row->delete();

		$clearCacheHelpers->galleryDestroy();
		
        Session::flash('success', "Successfully destroy");
        return Redirect::back();
	}

	/**
	 * Custom.
	 *
	 */

	public function category()
	{
		$catlist = GalleryCategory::with(['createdBy','updatedBy'])->get();
		return view('admin.gallery.category', compact('catlist'));
	}

	public function categorystore(Request $request)
	{
		if (Auth::user()->role == 'subscriber') {
			Session::flash('unauthorized', "403 | This action is unauthorized.");
			return Redirect::back();
		}

		GalleryCategory::create([
			'name' => strip_tags($request->input('name')),
			'type' => strip_tags($request->input('type')),
			'g_status' => strip_tags($request->input('g_status')),
			'created_by' => Auth::user()->id,
		]);

		Session::flash('success', "Successfully Inserted");
		return Redirect::back();
		
	}

	public function categoryEdit($id)
	{
		$catlist = GalleryCategory::get();
		$cat = GalleryCategory::find($id);
		return view('admin.gallery.categoryedit', compact('catlist','cat'));
		
	}

	public function categoryupdate(Request $request)
	{
		if (Auth::user()->role == 'subscriber') {
			Session::flash('unauthorized', "403 | This action is unauthorized.");
			return Redirect::back();
		}

		GalleryCategory::where('id', $request->input('row-id'))->update([
			'name' => strip_tags($request->input('name')),
			'type' => strip_tags($request->input('type')),
			'g_status' => $request->input('g_status'),
			'updated_by' => Auth::user()->id,
		]);

		Session::flash('success', "Successfully Updated");
		return Redirect::back();
	}

	public function categorydestroy(Request $request)
	{
		if (Auth::user()->role == 'subscriber') {
			Session::flash('unauthorized', "403 | This action is unauthorized.");
			return Redirect::back();
		}
		
		GalleryCategory::destroy($request->input('id'));
		Session::flash('success', "Successfully Destroyed");
		return Redirect::back();
	}

	public function apiFindGalleryCat($type)
	{
		$sql = GalleryCategory::where('type',$type)->where('g_status',1)->get();
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

	public function sort($type){
		$sql = Gallery::with(['catName','createdBy','updatedBy'])->where('type',$type)->where('status','1')->orderBy('g_order', 'desc')->take(20)->get();

		return view('admin.gallery.sort', compact('sql','type'));
	}

	public function sortupdate(Request $request, clearCacheHelpers $clearCacheHelpers)
	{
		if (Auth::user()->role == 'subscriber') {
			Session::flash('unauthorized', "403 | This action is unauthorized.");
			return Redirect::back();
		}

		$order_name = $request->get('order_name');
		$g_order = $request->get('g_order');
		$id = $request->get('id');

		foreach ($id as $key => $value) {
			Gallery::where('id', $id[$key])->update([
				'g_order' => $g_order[$key]
			]);
		}
		
		Session::flash('success', "Successfully Updated");
		return Redirect::back();
	}
}
