<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkBetweenNews extends Model
{
    use HasFactory;

    protected $table = 'linkbetweennews';

    protected $fillable = [
        'head_page',
        'head_img',
        'tail_page',
        'tail_img',
        'n_id',
        'p_date',
        'created_by',
        'updated_by'
    ];

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

    public function newsID(){
        return $this->belongsTo(News::class, 'n_id');
    }
}
