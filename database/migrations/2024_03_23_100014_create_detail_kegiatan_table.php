<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('no_kontrak');
            $table->string('jenis_pengadaan');
            $table->string('nilai_kontrak');
            $table->string('pagu');
            $table->date('awal_kontrak');
            $table->date('akhir_kontrak');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('status')->nullable();
            $table->string('target')->nullable();
            $table->string('real')->nullable();
            $table->string('dev')->nullable();
            $table->string('progress')->nullable();
            $table->string('alamat')->nullable();
            $table->bigInteger('kegiatan_id')->nullable();
            $table->string('daya_serap_kontrak')->nullable();
            $table->string('sisa_kontrak')->nullable();
            $table->string('sisa_anggaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_kegiatan');
    }
};