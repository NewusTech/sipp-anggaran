<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RencanaKegiatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rencana_kegiatan';
    protected $guarded = ['id'];

    public function getBulan()
    {
        $bulan = Carbon::parse($this->bulan)->format('F');
        $bulanIndonesia = Carbon::parse($bulan)->locale('id')->isoFormat('MMMM');
        return $bulanIndonesia;
    }

    public function detail_kegiatan(): BelongsTo
    {
        return $this->belongsTo(DetailKegiatan::class, 'detail_kegiatan_id', 'id');
    }
}
