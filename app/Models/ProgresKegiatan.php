<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgresKegiatan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'progres_kegiatan';
    protected $fillable = ['detail_kegiatan_id', 'tanggal', 'jenis_progres', 'nilai'];

    public function detailKegiatan(): BelongsTo
    {
        return $this->belongsTo(DetailKegiatan::class, 'penyedia_jasa_id', 'id');
    }
}
