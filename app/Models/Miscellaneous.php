<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Miscellaneous extends Model
{
    use HasFactory;


/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'miscellaneous';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'type',
		'arr_data',
		'status',
    ];

}
