<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileDokumentasi extends Model
{
    use HasFactory;

    protected $table = 'file_dokumentasi';

    protected $fillable = [
        'dokumentasi_id',
        'file_name',
        'type',
        'path',
    ];
}
