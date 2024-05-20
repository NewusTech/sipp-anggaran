<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pagu extends Model
{
    use HasFactory, SoftDeletes;

		protected $table = 'pagu';
		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
		protected $fillable = [
			'dpa_id',
			'kegiatan_id',
			'detail_kegiatan_id',
            'sub_kegiatan_id',
			'belanja_operasi',
			'belanja_modal',
			'belanja_tak_terduga',
			'belanja_transfer',
			'keterangan',
			'tanggal'
		];
}
