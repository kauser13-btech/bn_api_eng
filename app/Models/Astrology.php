<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Astrology extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'text',
        'start_date',
        'p_order',
        'p_status',
        'created_by',
        'updated_by'
    ];

    public function scopeIsActive($query){
        return $query->where('p_status',1);
    }

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function updatedBy(){
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }
}
