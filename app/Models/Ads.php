<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    use HasFactory;

    protected $fillable = [
		'adtype',
		'name',
		'device',
		'page',
		'ads_positions_slug',
		'menus_id',
		'n_id',
		'ad_condition',
		'ad_order',
		'status',
		'start_date',
		'end_date',
		'ad_img',
		'landing_url',
		'ad_code',
		'head_code',
		'footer_code',
		'time_schedule',
		'created_by',
		'updated_by',
    ];

    public function scopeActiveAd($query){
        return $query->where('status',1)->where('start_date', '<=', date('Y-m-d H:i:s'))->where(function($query){
        	$query->where('end_date','>=', date('Y-m-d H:i:s'))->orWhereNull('end_date');
        });
    }

	public function createdBy(){
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

	public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

	public function adsPosition(){
        return $this->belongsTo(AdsPosition::class, 'ads_positions_slug','slug');
    }
}
