<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bidang extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'bidang';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'kode'
    ];

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'bidang_id');
    }
}
