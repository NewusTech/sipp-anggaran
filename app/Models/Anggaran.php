<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anggaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'anggaran';

    protected $fillable = [
        'detail_kegiatan_id',
        'daya_serap',
        'sisa',
        'tanggal',
        'keterangan',
        'daya_serap_kontrak',
        'sisa_kontrak',
        'sisa_anggaran',
        'progress'
    ];

    protected $dates = ['tanggal'];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    // scope untuk filter anggaran
    public function scopeFilter($query, $request)
    {
        if (request()->has('bulan')) {
            if (!empty($request->bulan)) {
                $query->whereMonth('anggaran.tanggal', $this->convertMonth($request->bulan));
            }
        }
        if (request()->has('tahun')) {
            if (!empty($request->tahun)) {
							$query->whereYear('anggaran.tanggal', $request->tahun);
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
				default :
					return '';
			}
		}
}
