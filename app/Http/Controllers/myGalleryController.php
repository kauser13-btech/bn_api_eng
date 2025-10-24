<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Models\Gallery;
use App\Helpers\generalHelper;
use Illuminate\Support\Facades\URL;
use App\Helpers\ImageStoreHelpers;
use App\Models\GalleryCategory;
use Carbon\Carbon;

class myGalleryController extends Controller
{

    public function photo_gallery()
    {
        // ->where('category',1)
        $currentPage = 'photoGallery-' . request()->get('page', 1);
        $photo_gallery = Cache::remember($currentPage, 500, function () {
            $sql = Gallery::isActive()->select('id', 'name', 'caption', 'cover_photo', 'images', 'type', 'category', 'embed_code', 'start_at', 'status', 'created_at')->where('type', 'photo')->orderBy('id', 'desc')->paginate(20)->setPath(URL::current());

            $sql->getCollection()->transform(function ($row, $key) {
                $row->cover_photo = ImageStoreHelpers::showImage('gallery', $row->created_at, $row->cover_photo, 'medium');
                $row->images = json_encode(unserialize($row->images));
                $row->imagesUrl = ImageStoreHelpers::showImage('gallery', $row->created_at, 'folderURL', '');
                return $row;
            });
            return $sql;
        });

        return response()->json($photo_gallery);
    }

    public function photo_viewer($id)
    {
        $gallery = Cache::remember('gallery-' . $id, 502, function () use ($id) {
            $sql = Gallery::where('status', 1)->where('start_at', '<=', date('Y-m-d H:i:s'))->find($id);
            $ifOg = ($sql->watermark != '') ? 'og' : '';
            $sql->openGraphImg = ImageStoreHelpers::showImage('gallery', $sql->created_at, $sql->cover_photo, $ifOg);
            $sql->images = json_encode(unserialize($sql->images));
            $sql->imagesUrl = ImageStoreHelpers::showImage('gallery', $sql->created_at, 'folderURL', '');
            $sql->date_at = generalHelper::bn_date(date("l, d F, Y H:i", strtotime($sql->start_at)));
            return $sql;
        });

        if (!isset($gallery)) {
            // return response()->view('errors.mobile-404',compact('breakingNews','ticker'),404);
            return [];
        }

        $parentId = $gallery->id;
        $more_photo = Cache::remember('more_photo-' . $id, 500, function () use ($parentId) {
            $sql = Gallery::isActive()->select('id', 'name', 'caption', 'cover_photo', 'type', 'category', 'embed_code', 'start_at', 'status', 'created_at')->where('id', '!=', $parentId)->where('category', 1)->orderBy('id', 'desc')->limit(8)->get();

            $sql->transform(function ($row, $key) {
                $row->cover_photo = ImageStoreHelpers::showImage('gallery', $row->created_at, $row->cover_photo, 'medium');
                return $row;
            });
            return $sql;
        });

        return response()->json(
            [
                'gallery' => $gallery,
                'more_photo' => $more_photo,
            ],
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }



    public function video_gallery()
    {
        $gallery_cat = Cache::remember('home-gallery_cat', 500, function () {
            $sql = GalleryCategory::with(['posts' => function ($query) {
                $query->latest()->take(4);
            }])->where('g_status', 1)->where('type', 'video')->orderBy('id', 'asc')->get();

            $sql->transform(function ($row) {
                $row->posts->transform(function ($post) {
                    $post->cover_photo = ImageStoreHelpers::showImage('gallery', $post->created_at, $post->cover_photo, 'medium');
                    return $post;
                });
                return $row;
            });
            return $sql;
        });

        $most_view = Cache::remember('most_view', 500, function () {
            $sql = Gallery::where('status', 1)->where('type', 'video')->where('created_at', '>=', Carbon::now()->subDays(2))->orderBy('most_view', 'desc')->limit(10)->get();

            $sql->transform(function ($row, $key) {
                $row->cover_photo = ImageStoreHelpers::showImage('gallery', $row->created_at, $row->cover_photo, 'medium');
                return $row;
            });

            return $sql;
        });

        return response()->json([
            'gallery_cat' => $gallery_cat,
            'most_view' => $most_view
        ]);
    }

    public function gallery_cat($catId)
    {
        $currentPage = 'videoGalleryCat-' . $catId . '-' . request()->get('page', 1);
        $photo_gallery = Cache::remember($currentPage, 500, function () use ($catId) {
            $sql = Gallery::isActive()->select('id', 'name', 'caption', 'cover_photo', 'type', 'category', 'embed_code', 'start_at', 'status', 'created_at')->where('category', $catId)->orderBy('id', 'desc')->paginate(30)->setPath(URL::current());

            $sql->getCollection()->transform(function ($row, $key) {
                $row->cover_photo = ImageStoreHelpers::showImage('gallery', $row->created_at, $row->cover_photo, 'medium');
                return $row;
            });
            return $sql;
        });

        return response()->json($photo_gallery);
    }

    public function video_viewer($id)
    {
        $video = Cache::remember('video_viewer-' . $id, 502, function () use ($id) {
            $sql = Gallery::where('status', 1)->where('start_at', '<=', date('Y-m-d H:i:s'))->find($id);
            $ifOg = ($sql->watermark != '') ? 'og' : '';
            $sql->openGraphImg = ImageStoreHelpers::showImage('gallery', $sql->created_at, $sql->cover_photo, $ifOg);
            $sql->embed_code = html_entity_decode($sql->embed_code);
            $sql->images = json_encode(unserialize($sql->images));
            $sql->cover_photo = ImageStoreHelpers::showImage('gallery', $sql->created_at, $sql->cover_photo, 'medium');
            $sql->date_at = generalHelper::bn_date(date("l, d F, Y H:i", strtotime($sql->start_at)));
            return $sql;
        });

        if (!isset($video)) {
            // return response()->view('errors.mobile-404',compact('breakingNews','ticker'),404);
            return [];
        }

        $parentId = $video->id;
        $more_video = Cache::remember('more_video-' . $id, 500, function () use ($parentId) {
            $sql = Gallery::isActive()->select('id', 'name', 'caption', 'cover_photo', 'type', 'category', 'embed_code', 'start_at', 'status', 'created_at')->where('id', '!=', $parentId)->where('category', 2)->orderBy('id', 'desc')->limit(8)->get();

            $sql->transform(function ($row, $key) {
                $row->cover_photo = ImageStoreHelpers::showImage('gallery', $row->created_at, $row->cover_photo, 'medium');
                return $row;
            });
            return $sql;
        });

        return response()->json([
            'video' => $video,
            'more_video' => $more_video,
        ]);
    }

    public function most_view(Request $request)
    {
        $id = $request->input('id');
        try {
            Gallery::where('id', $id)->increment('most_view', 1);
            return $id;
        } catch (\Exception $e) {
        }
    }
}
