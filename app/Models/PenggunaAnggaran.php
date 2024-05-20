<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenggunaAnggaran extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'pengguna_anggaran';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'nip',
        'jabatan',
        'dpa_id'
    ];
}