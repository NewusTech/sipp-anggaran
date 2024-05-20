<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenyediaJasa extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'penyedia_jasa';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'telepon',
        'join_date'
    ];
}
