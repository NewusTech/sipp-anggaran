<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'title',
        'kode_sub_kegiatan',
        'dpa_id',
        'kegiatan_id',
        'detail_kegiatan_id',
        'sumber_dana_id',
        'total_pagu'
    ];

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id', 'id');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(DetailKegiatan::class, 'sub_kegiatan_id', 'id');
    }
}

