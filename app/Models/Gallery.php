<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    
    protected $fillable = [
    	'name',
	    'caption',
	    'cover_photo',
	    'type',
	    'category',
	    'images',
	    'embed_code',
	    'title_info',
	    'keywords',
	    'description',
	    'start_at',
	    'edit_at',
	    'g_order',
	    'special_video',
	    'slide_video',
		'watermark',
	    'status',
		'most_view',
	    'created_by',
	    'updated_by',
	];

	public function scopeIsActive($query){
        return $query->where('status',1)->where('start_at', '<=', date('Y-m-d H:i:s'));
    }

	public function catName(){
        return $this->belongsTo(GalleryCategory::class, 'category')->withDefault();
    }

	public function createdBy(){
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

	public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }
}
