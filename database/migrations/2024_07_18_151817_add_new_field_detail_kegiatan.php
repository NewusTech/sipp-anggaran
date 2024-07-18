<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('detail_kegiatan', function (Blueprint $table) {
            $table->integer('sumber_dana_id')->after('realisasi')->nullable();
            $table->string('metode_pemilihan')->after('sumber_dana_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('detail_kegiatan', function (Blueprint $table) {
            $table->dropColumn('sumber_dana_id');
            $table->dropColumn('metode_pemilihan');
        });
    }
};
