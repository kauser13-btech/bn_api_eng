<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

use App\Models\ArchiveNewsTable;


class News extends Model
{
    use HasFactory;
    use SoftDeletes;

	protected $primaryKey = 'n_id';

	// public $timestamps = false;

    protected $fillable = [
		'n_solder',
		'n_head',
		'n_subhead',
		'news_tags',
		'n_author',
		'n_writer',
		'n_reporter',
		'n_details',
		'n_category',
		'main_image',
		'watermark',
		'n_caption',
		// start position iteam
		'category_lead',
		'home_lead',
		'highlight_items',
		'focus_items',
		'pin_news',
		'ticker_news',
		'home_category',
		'is_latest',
		'sticky',
		'cat_selected',
		'home_slide',
		'multimedia_slide',
		// end position iteam
		'title_info',
		'meta_keyword',
		'meta_description',
		'embedded_code',
		'main_video',
		'most_read',
		'divisions',
		'districts',
		'upazilas',
		'n_status',
		// start order
		'n_order',
		'home_cat_order',
		'leadnews_order',
		'highlight_order',
		'focus_order',
		'pin_order',
		'special_order',
		'home_slide_order',
		'multimedia_slide_order',
		// end order
		'edition',
		'n_date',
		'start_at',
		'end_at',
		'edit_at',
		'created_by',
		'updated_by',
		'onediting',
		'is_live',
		'is_active_live',
		'is_linked',
		'parent_id',
		'deleted_by',
		'deleted_at',
		'restore_by'
	];



	public function scopeFindNewsTable($query, $nid){
		$getTable = ArchiveNewsTable::where('first_id', '<=', $nid)->where('last_id', '>=', $nid)->first();
		$table = isset($getTable->table)?$getTable->table:'news';
		if (Schema::hasTable($table)) {
			$query->from($table);
			$this->setTable($table);
		}
	}

	public function scopeNewsTable($query, $year){
		if($year!='' && $year!=date("Y") && $year!=date("Y",strtotime("-1 year"))){
			if (Schema::hasTable('news_'.$year)) {
				$query->from('news_'.$year);
				$this->setTable('news_'.$year);
			}
		}
		
	}

	// News created_at insert NewsArchive table
	protected function serializeDate(DateTimeInterface $date)
	{
		return $date->format('Y-m-d H:i:s');
	}

	public function scopeIsActive($query){
        return $query->where('n_status',3)->where('is_linked',1)->where('start_at', '<=', date('Y-m-d H:i:s'));
    }

	public function deletedBy(){
        return $this->belongsTo(User::class, 'deleted_by')->withDefault();
    }

	public function createdBy(){
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

	public function editingBy(){
        return $this->belongsTo(User::class, 'onediting')->withDefault();
    }

	public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

    public function catName(){
        return $this->belongsTo(Menu::class, 'n_category')->withDefault();
    }

    public function getWriters(){
        return $this->belongsTo(Writers::class, 'n_writer');
    }

    public function getReporter(){
        return $this->belongsTo(Writers::class, 'n_reporter');
    }

    public function newsTag(){
        return $this->belongsTo(Tag::class, 'news_tags');
    }

}
