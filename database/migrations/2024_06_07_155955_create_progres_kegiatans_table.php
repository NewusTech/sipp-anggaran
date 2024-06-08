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
        Schema::create('progres_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_kegiatan_id')->nullable();
            $table->string('bulan');
            $table->integer('keuangan');
            $table->integer('fisik');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('detail_kegiatan_id')->references('id')->on('detail_kegiatan');
        });

        Schema::create('rencana_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detail_kegiatan_id')->nullable();
            $table->string('bulan');
            $table->integer('keuangan');
            $table->integer('fisik');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('detail_kegiatan_id')->references('id')->on('detail_kegiatan');
        });
    }

    public function down()
    {
        Schema::dropIfExists('progres_kegiatan');
        Schema::dropIfExists('rencana_kegiatan');
    }
};
