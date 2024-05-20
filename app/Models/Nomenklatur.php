<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nomenklatur extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'nomenklatur';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pptk',
        'ppk'
    ];
}
