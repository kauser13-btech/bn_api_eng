<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emagazine extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'emagazines';

    /* status *
        * 0 Inactive
        * 1 Draft
        * 3 Publish
    */

    protected $fillable = [
        'cat',
        'page_id',
        'image',
        'p_date',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
        'restore_by'
    ];

    public function scopeIsActive($query)
    {
        return $query->where('status', 3);
        // return $query->where('status',3)->where('start_at', '<=', date('Y-m-d H:i:s'));
    }

    public function catName(){
        return $this->belongsTo(EmagazineCat::class, 'cat')->withDefault();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by')->withDefault();
    }

    public function restoreBy()
    {
        return $this->belongsTo(User::class, 'restore_by')->withDefault();
    }
}
