<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RencanaKegiatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rencana_kegiatan';
    protected $guarded = ['id'];
}
