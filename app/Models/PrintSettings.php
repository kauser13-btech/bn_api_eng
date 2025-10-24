<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintSettings extends Model
{
    use HasFactory;

    protected $table = 'printsettings';

    /*
        * E-Paper-New-Date -> get print and epaper news date
        * Publish-Print-New-Date -> publish print news
        * Publish-E-Paper-New-Date -> publish e-paper
        * Magazine-New-Date -> get magazine and e-magazine news date
        * Publish-Magazine-New-Date -> publish magazine news
        * Publish-E-Magazine-New-Date -> publish e magazine
    */

    protected $fillable = [
        'type',
        'pdate',
        'created_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }
}
