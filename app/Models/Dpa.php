<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dpa extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'dpa';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
			'no_dpa',
			'tahun',
			'alokasi',
			'urusan_id',
			'bidang_id',
			'program_id',
			'kegiatan_id',
			'organisasi_id',
			'unit_id',
			'realisasi'
    ];

		// scope untuk filter detail kegiatan
    public function scopeFilter($query, $request)
    {
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
				default :
					return '';
			}
		}
}
