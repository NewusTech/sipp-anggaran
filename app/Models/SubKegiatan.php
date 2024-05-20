<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubKegiatan extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'sub_kegiatan';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dpa_id',
        'kegiatan_id',
        'detail_kegiatan_id',
        'sumber_dana_id',
        'total_pagu'
    ];
}

