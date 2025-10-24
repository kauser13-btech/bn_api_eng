<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsArchive extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
    	'n_id',
		'n_solder',
		'n_head',
		'n_subhead',
		'news_tags',
		'n_author',
		'n_writer',
		'n_details',
		'n_category',
		'main_image',
		'watermark',
		'n_caption',
		'category_lead',
		'home_lead',
		'highlight_items',
		'instant_articles',
		'ticker_news',
		'home_category',
		'is_latest',
		'sticky',
		'cat_selected',
		'home_slide',
		'title_info',
		'meta_keyword',
		'meta_description',
		'embedded_code',
		'main_video',
		'most_read',
		'n_status',
		'n_order',
		'special_order',
		'home_cat_order',
		'home_slide_order',
		'edition',
		'start_at',
		'end_at',
		'edit_at',
		'created_by',
		'updated_by',
		'updated_at',
		'created_at',
		'deleted_by',
		'deleted_at',
		'restore_by',
		'edited_by',
		'edited_at'
	];

	public function editedBy(){
        return $this->belongsTo(User::class, 'edited_by')->withDefault();
    }

    public function catName(){
        return $this->belongsTo(Menu::class, 'n_category');
    }

	public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

}
