<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailKegiatan extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'detail_kegiatan';

    protected $fillable = [
        'title',
        'no_detail_kegiatan',
        'no_kontrak',
        'no_spmk',
        'jenis_pengadaan',
        'nilai_kontrak',
        'pagu',
        'awal_kontrak',
        'akhir_kontrak',
        'latitude',
        'longitude',
        'status',
        'target',
        'real',
        'dev',
        'progress',
        'alamat',
        'kegiatan_id',
        'sumber_dana_id',
        'metode_pemilihan',
        'sub_kegiatan_id',
        'penyedia_jasa',
        'penyedia_jasa_id',
        'realisasi',
        'verifikasi_admin',
        'komentar_admin',
        'verifikasi_pengawas',
        'komentar_pengawas',
        'penanggung_jawab_id'
    ];

    protected $casts = [
        'awal_kontrak' => 'datetime',
        'akhir_kontrak' => 'datetime',
    ];

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id', 'id');
    }

    public function subKegiatan(): BelongsTo
    {
        return $this->belongsTo(SubKegiatan::class, 'sub_kegiatan_id', 'id');
    }

    public function penanggungJawab() : BelongsTo {
        return $this->belongsTo(PenanggungJawab::class, 'penanggung_jawab_id', 'id');
    }

    public function penyedia(): BelongsTo
    {
        return $this->belongsTo(PenyediaJasa::class, 'penyedia_jasa_id', 'id');
    }

    public function progres(): HasMany
    {
        return $this->hasMany(ProgresKegiatan::class, 'detail_kegiatan_id', 'id');
    }

    // scope untuk filter detail kegiatan
    public function scopeFilter($query, $request)
    {
        if (request()->has('search')) {
            if (!empty($request->search)) {
                $query->where('title', 'like', '%' . $request->search . '%');
            }
        }
        if (request()->has('jenis_paket')) {
            if (!empty($request->jenis_paket)) {
                $query->whereHas('kegiatan', function ($kegiatan) use ($request) {
                    $kegiatan->where('jenis_paket', $request->jenis_paket);
                });
            }
        }
        if (request()->has('bulan')) {
            if (!empty($request->bulan)) {
                $query->whereMonth('detail_kegiatan.created_at', $this->convertMonth($request->bulan));
            }
        }
        if (request()->has('tahun')) {
            if (!empty($request->tahun)) {
                $query->whereYear('detail_kegiatan.created_at', $request->tahun);
            }
        }
    }
    public function convertMonth($month)
    {
        switch ($month) {
            case 'januari':
                return '01';
                break;
            case 'februari':
                return '02';
                break;
            case 'maret':
                return '03';
                break;
            case 'april':
                return '04';
                break;
            case 'mei':
                return '05';
                break;
            case 'juni':
                return '06';
                break;
            case 'juli':
                return '07';
                break;
            case 'agustus':
                return '08';
                break;
            case 'september':
                return '09';
                break;
            case 'oktober':
                return '10';
                break;
            case 'november':
                return '11';
            case 'desember':
                return '12';
            default:
                return '';
        }
    }
}
