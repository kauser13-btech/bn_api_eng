<?php

namespace App\Helpers;

use App\Models\Ads;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class ImageStoreHelpers
{

	public static function showImage($folder, $imgdate, $image, $size = '')
	{
		if ($image == '' || $image == null) {
			// return url('default-img.jpg');
			return 'https://bn-cdn.banglanews24.com/files/2/default-img.jpg';
		} elseif (strpos($image, 'laravel-filemanager') !== false) {
			return asset(Storage::url('public/old' . $image));
		} elseif (strpos($image, 'public/images') !== false) {
			return asset(Storage::url('public/old/' . $image));
		} elseif ($image == 'folderURL') {
			$size = $size != '' ? '/' . $size . '/' : '';
			return asset(Storage::url('public/' . $folder . '/' . date("Y/m/d", strtotime($imgdate)) . $size));
		} elseif ($imgdate == 'folder') {
			return asset(Storage::url('public/' . $folder . '/' . $image));
		} else {
			// $folder = date("Y/m/d",strtotime($imgdate));
			$size = $size != '' ? $size . '/' : '';
			return asset(Storage::url('public/' . $folder . '/' . date("Y/m/d", strtotime($imgdate)) . '/' . $size . $image));
		}
	}

	public function newsImageUpload($file, $imgdate, $watermark)
	{
		$folder = 'public/news_images/' . date("Y/m/d", strtotime($imgdate));
		$file_name = time() . '-' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

		$small = Image::make($file->getRealPath())->resize(132, 88, function ($c) {
			$c->aspectRatio();
			$c->upsize();
		});
		Storage::put("{$folder}/mob/{$file_name}", $small->stream()->__toString());

		$thumbnail = Image::make($file->getRealPath())->resize(375, 250, function ($c) {
			$c->aspectRatio();
			$c->upsize();
		});
		Storage::put("{$folder}/thumbnail/{$file_name}", $thumbnail->stream()->__toString());

		// $large = Image::make($file->getRealPath())->resize(856, 570, function ($c) { $c->aspectRatio(); $c->upsize();});

		if ($file->getClientOriginalExtension() == 'gif') {
			Storage::putFileAs($folder, $file, $file_name);
		} else {
			$large = Image::make($file->getRealPath());
			Storage::put("{$folder}/{$file_name}", $large->stream()->__toString());
		}

		// start watermark ad
		$watermark_ogg = Image::make($file->getRealPath())->fit(600, 315);
		if ($watermark != '') {
			$watermark_sql = Ads::where('id', $watermark)->first();
			$watermark_img = asset(Storage::url('public/ads_images/' . date("Y/m/d", strtotime($watermark_sql->created_at)) . '/' . $watermark_sql->ad_img));
			$watermark_ogg->insert($watermark_img, 'bottom');
		}
		Storage::put("{$folder}/og/{$file_name}", $watermark_ogg->stream()->__toString());
		// end watermark ad

		return $file_name;
	}

	public function newsImageEdit($file, $imgdate, $old_img, $watermark)
	{
		if ($file == '' && $old_img == '') {
			return '';
		}
		$folder = 'public/news_images/' . date("Y/m/d", strtotime($imgdate));
		$file_name = $old_img;

		if ($file) {
			$file_name = time() . '-' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

			$small = Image::make($file->getRealPath())->resize(132, 88, function ($c) {
				$c->aspectRatio();
				$c->upsize();
			});
			Storage::delete("{$folder}/mob/{$old_img}");
			Storage::put("{$folder}/mob/{$file_name}", $small->stream()->__toString());

			$thumbnail = Image::make($file->getRealPath())->resize(375, 250, function ($c) {
				$c->aspectRatio();
				$c->upsize();
			});
			Storage::delete("{$folder}/thumbnail/{$old_img}");
			Storage::put("{$folder}/thumbnail/{$file_name}", $thumbnail->stream()->__toString());

			// $large = Image::make($file->getRealPath())->resize(856, 570, function ($c) { $c->aspectRatio(); $c->upsize();});
			Storage::delete("{$folder}/{$old_img}");

			if ($file->getClientOriginalExtension() == 'gif') {
				Storage::putFileAs($folder, $file, $file_name);
			} else {
				$large = Image::make($file->getRealPath());
				Storage::put("{$folder}/{$file_name}", $large->stream()->__toString());
			}

			// start watermark ad
			$watermark_ogg = Image::make($file->getRealPath())->fit(600, 315);
			if ($watermark) {
				$watermark_sql = Ads::where('id', $watermark)->first();
				$watermark_img = asset(Storage::url('public/ads_images/' . date("Y/m/d", strtotime($watermark_sql->created_at)) . '/' . $watermark_sql->ad_img));
				$watermark_ogg->insert($watermark_img, 'bottom');
			}
			Storage::delete("{$folder}/og/{$old_img}");
			Storage::put("{$folder}/og/{$file_name}", $watermark_ogg->stream()->__toString());
			// end watermark ad
		} elseif ($watermark != '') {
			$watermark_sql = Ads::where('id', $watermark)->first();
			$watermark_img = asset(Storage::url('public/ads_images/' . date("Y/m/d", strtotime($watermark_sql->created_at)) . '/' . $watermark_sql->ad_img));
			$watermark_ogg = Image::make(asset(Storage::url("{$folder}/{$file_name}")))->fit(600, 315);
			$watermark_ogg->insert($watermark_img, 'bottom');
			Storage::put("{$folder}/og/{$file_name}", $watermark_ogg->stream()->__toString());
		} elseif ($watermark == '') {
			$ogg = Image::make(asset(Storage::url("{$folder}/{$file_name}")))->fit(600, 315);
			Storage::put("{$folder}/og/{$file_name}", $ogg->stream()->__toString());
		}

		return $file_name;
	}

	public function adImageUpload($file, $imgdate)
	{
		$folder = 'public/ads_images/' . date("Y/m/d", strtotime($imgdate));
		$file_name = time() . '-' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

		$thumb = Image::make($file->getRealPath())->resize(150, 150, function ($c) {
			$c->aspectRatio();
			$c->upsize();
		});
		Storage::put("{$folder}/thumb/{$file_name}", $thumb->stream()->__toString());

		if ($file->getClientOriginalExtension() == 'gif') {
			Storage::putFileAs($folder, $file, $file_name);
		} else {
			$large = Image::make($file->getRealPath());
			Storage::put("{$folder}/{$file_name}", $large->stream()->__toString());
		}

		return $file_name;
	}

	public function adImageEdit($file, $imgdate, $oldimage)
	{
		$folder = 'public/ads_images/' . date("Y/m/d", strtotime($imgdate));
		$file_name = time() . '-' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

		if ($oldimage != '') {
			Storage::delete("{$folder}/thumb/{$oldimage}");
			Storage::delete("{$folder}/{$oldimage}");
		}

		$thumb = Image::make($file->getRealPath())->resize(150, 150, function ($c) {
			$c->aspectRatio();
			$c->upsize();
		});
		Storage::put("{$folder}/thumb/{$file_name}", $thumb->stream()->__toString());


		if ($file->getClientOriginalExtension() == 'gif') {
			Storage::putFileAs($folder, $file, $file_name);
		} else {
			$large = Image::make($file->getRealPath());
			Storage::put("{$folder}/{$file_name}", $large->stream()->__toString());
		}

		return $file_name;
	}

	public function adImageDelete($file, $imgdate)
	{
		$folder = 'public/ads_images/' . date("Y/m/d", strtotime($imgdate));
		if ($file != '') {
			Storage::delete("{$folder}/thumb/{$file}");
			Storage::delete("{$folder}/{$file}");
		}
	}

	public function galleryImageUpload($file, $imgdate, $old_cover_photo = '', $watermark = '')
	{
		$folder = 'public/gallery/' . date("Y/m/d", strtotime($imgdate));
		$file_name = time() . '-' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

		$thumb = Image::make($file->getRealPath())->resize(306, 204, function ($c) {
			$c->aspectRatio();
			$c->upsize();
		});
		Storage::put("{$folder}/thumb/{$file_name}", $thumb->stream()->__toString());

		$medium = Image::make($file->getRealPath())->resize(636, 424, function ($c) {
			$c->aspectRatio();
			$c->upsize();
		});
		Storage::put("{$folder}/medium/{$file_name}", $medium->stream()->__toString());

		$large = Image::make($file->getRealPath());
		Storage::put("{$folder}/{$file_name}", $large->stream()->__toString());

		$watermark_ogg = Image::make($file->getRealPath())->fit(600, 315);
		if ($watermark != '') {
			$watermark_sql = Ads::where('id', $watermark)->first();
			$watermark_img = asset(Storage::url('public/ads_images/' . date("Y/m/d", strtotime($watermark_sql->created_at)) . '/' . $watermark_sql->ad_img));
			$watermark_ogg->insert($watermark_img, 'bottom');

			if ($old_cover_photo != '') {
				Storage::delete("{$folder}/og/{$old_cover_photo}");
			}
		}
		Storage::put("{$folder}/og/{$file_name}", $watermark_ogg->stream()->__toString());

		return $file_name;
	}

	public function galleryImageDelete($file, $imgdate, $watermark = '')
	{
		$folder = 'public/gallery/' . date("Y/m/d", strtotime($imgdate));
		Storage::delete("{$folder}/thumb/{$file}");
		Storage::delete("{$folder}/og/{$file}");
		Storage::delete("{$folder}/{$file}");
	}

	public function screenImageUpload($file)
	{
		$folder = 'public/screen/' . date("Y/m/d");
		$file_name = time() . '-' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

		$thumb = Image::make($file->getRealPath())->resize(150, 150, function ($c) {
			$c->aspectRatio();
			$c->upsize();
		});
		Storage::put("{$folder}/thumb/{$file_name}", $thumb->stream()->__toString());

		$large = Image::make($file->getRealPath());
		Storage::put("{$folder}/{$file_name}", $large->stream()->__toString());

		return $file_name;
	}

	public function screenImageDelete($file, $imgdate)
	{
		$folder = 'public/screen/' . date("Y/m/d", strtotime($imgdate));
		Storage::delete("{$folder}/thumb/{$file}");
		Storage::delete("{$folder}/{$file}");
	}

	public function profileImageUpload($file, $pdate, $oldfile)
	{
		$folder = 'public/profile/' . date("Y/m/d", strtotime($pdate));
		$file_name = time() . '-' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

		Storage::delete("{$folder}/{$oldfile}");

		$thumb = Image::make($file->getRealPath())->resize(250, 187, function ($c) {
			$c->aspectRatio();
			$c->upsize();
		});
		Storage::put("{$folder}/{$file_name}", $thumb->stream()->__toString());

		return $file_name;
	}

	public function tagImgUpload($file, $pdate, $oldfile)
	{
		$folder = 'public/tag/' . date("Y/m/d", strtotime($pdate));
		$file_name = time() . '-' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

		Storage::delete("{$folder}/{$oldfile}");

		$thumb = Image::make($file->getRealPath())->resize(427, 240, function ($c) {
			$c->aspectRatio();
			$c->upsize();
		});
		Storage::put("{$folder}/{$file_name}", $thumb->stream()->__toString());

		return $file_name;
	}

	public function specialSigmentImgUpload($file, $oldfile)
	{
		$folder = 'public/special_sigment';
		$file_name = time() . '-' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

		Storage::delete("{$folder}/{$oldfile}");

		$thumb = Image::make($file->getRealPath());
		Storage::put("{$folder}/{$file_name}", $thumb->stream()->__toString());

		return $file_name;
	}

	public function paperImageUpload($file, $imgdate)
	{
		$folder = 'public/paper/' . date("Y/m/d", strtotime($imgdate));
		$file_name = time() . '-' . $file->getClientOriginalName();

		$thumb = Image::make($file->getRealPath())->resize(650, 984);
		Storage::put("{$folder}/thumb/{$file_name}", $thumb->stream()->__toString());

		$large = Image::make($file->getRealPath());
		Storage::put("{$folder}/{$file_name}", $large->stream()->__toString());

		return $file_name;
	}

	public function paperCropUpload($originImg, $imgdate, $page, $widgets)
	{
		$folder = 'public/paper/' . date("Y/m/d", strtotime($imgdate)) . '/page-' . $page;

		$widgets_json = json_decode($widgets, true);
		foreach ($widgets_json as $value) {
			$img = Image::make(file_get_contents(asset(Storage::url('public/paper/' . date("Y/m/d", strtotime($imgdate)) . '/' . $originImg))));
			$tag_name = 'page-' . $page . '-tag-' . $value['id'] . '.jpg';

			$width = round($value['width']) * 3;
			$height = round($value['height']) * 3;
			$left = round($value['left']) * 3;
			$top = round($value['top']) * 3;

			$img->crop($width, $height, $left, $top);

			$watermarkLogo = Image::make('watermark-logo.png')->opacity(16)->resize(($width * 0.8), null, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});
			$img->insert($watermarkLogo, 'center');

			Storage::put("{$folder}/{$tag_name}", $img->stream()->__toString());
		}
	}

	public function emagazineUpload($file, $pdate)
	{
		$folder = 'public/emagazine/' . date("Y/m/d", strtotime($pdate));
		$file_name = time() . '-' . md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();

		$thumb = Image::make($file->getRealPath())->resize(375, 250, function ($c) {
			$c->aspectRatio();
			$c->upsize();
		});
		Storage::put("{$folder}/thumb/{$file_name}", $thumb->stream()->__toString());

		$large = Image::make($file->getRealPath());
		Storage::put("{$folder}/{$file_name}", $large->stream()->__toString());

		return $file_name;
	}

	public function emagazineDelete($file, $pdate)
	{
		$folder = 'public/emagazine/' . date("Y/m/d", strtotime($pdate));
		Storage::delete("{$folder}/thumb/{$file}");
		Storage::delete("{$folder}/{$file}");
	}
}
