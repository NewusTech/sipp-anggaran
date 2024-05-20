<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dokumentasi extends Model
{
    use HasFactory;

    protected $table = 'dokumentasi';

    protected $fillable = [
        'detail_kegiatan_id',
        'name',
        'keterangan',
    ];

    public function files(): HasMany
    {
        return $this->hasMany(FileDokumentasi::class, 'dokumentasi_id', 'id');
    }
}
