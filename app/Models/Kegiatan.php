<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kegiatan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'kegiatan';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'no_rek',
        'alokasi',
        'tahun',
        'program',
        'no_rek_program',
        'bidang_id',
        'sumber_dana',
        'jenis_paket',
        'is_arship'
    ];

    protected $with = ['bidang'];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }
    public function program()
    {
        return $this->belongsTo(Program::class);
    }


    public function detail()
    {
        return $this->hasMany(DetailKegiatan::class, 'kegiatan_id', 'id');
    }

    public function subKegiatan()
    {
        return $this->hasMany(SubKegiatan::class, 'kegiatan_id', 'id');
    }

    // scope untuk filter detail kegiatan
    public function scopeFilter($query, $request)
    {
        if (request()->has('tahun')) {
            if (!empty($request->tahun)) {
                $query->whereYear('kegiatan.created_at', $request->tahun);
            }
        }
    }
}
