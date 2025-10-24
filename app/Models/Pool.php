<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
    use HasFactory;

    protected $fillable = [
    	'text',
        'vote_1',
        'vote_2',
        'vote_3',
        'option_1',
        'option_2',
        'option_3',
    	'start_date',
    	'p_status',
    	'created_by',
    	'updated_by'
    ];

    public function scopeActive($query){
        return $query->where('p_status',1)->where('start_date', '<=', date('Y-m-d H:i:s'));
    }

	public function createdBy(){
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

	public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }
}
