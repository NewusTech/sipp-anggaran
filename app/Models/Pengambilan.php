<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengambilan extends Model
{
    use HasFactory, SoftDeletes;

		protected $table = 'pengambilan';
		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
		protected $fillable = [
			'dpa_id',
			'detail_kegiatan_id',
			'belanja_operasi',
			'belanja_modal',
			'belanja_tak_terduga',
			'belanja_transfer',
			'keterangan',
			'bulan'
		];

		// scope untuk filter pengambilan
    public function scopeFilter($query, $request)
    {
        if (request()->has('bulan')) {
            if (!empty($request->bulan)) {
                $query->whereMonth('pengambilan.bulan', $request->bulan);
            }
        }
        if (request()->has('tahun')) {
            if (!empty($request->tahun)) {
							$query->whereYear('pengambilan.created_at', $request->tahun);
            }
        }

    }
}