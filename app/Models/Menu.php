<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory;
    use SoftDeletes;

	protected $primaryKey = 'm_id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'm_name',
		'slug',
		'm_edition',
		'm_title',
		'm_keywords',
		'm_desc',
		'm_parent',
		'm_order',
		'm_status',
		'm_visible',
		's_news',
		'm_color',
		'm_bg',
		'created_by',
		'updated_by',
		'deleted_by',
		'deleted_at',
    ];

    public function getNews(){
        return $this->hasMany(News::class, 'n_category');
    }

	public function createdBy(){
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

	public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

    public function parentName(){
        return $this->hasOne(Menu::class, 'm_parent');
    }

    public function total_posts(){
        return $this->hasMany(News::class, 'n_category');
    }

    public function total_read(){
        return $this->hasMany(News::class, 'n_category');
    }
}
