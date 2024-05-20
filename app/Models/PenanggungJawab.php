<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenanggungJawab extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'penanggung_jawab';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pptk_name',
        'pptk_nip',
        'pptk_email',
        'pptk_telpon',
        'pptk_bidang_id',
        'ppk_name',
        'ppk_nip',
        'ppk_email',
        'ppk_telpon',
        'ppk_bidang_id',
        'kegiatan_id',
    ];

    protected $with = ['bidang_pptk', 'bidang_ppk'];

    public function bidang_pptk()
    {
        return $this->belongsTo(Bidang::class,'pptk_bidang_id','id');
    }

    public function bidang_ppk()
    {
        return $this->belongsTo(Bidang::class,'ppk_bidang_id','id');
    }
}
