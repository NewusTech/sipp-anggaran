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
        Schema::create('dpa', function (Blueprint $table) {
            $table->id();
            $table->string('no_dpa');
            $table->string('tahun');
            $table->string('alokasi');
            $table->unsignedInteger('urusan_id');
            $table->unsignedInteger('bidang_id');
            $table->unsignedInteger('program_id');
            $table->unsignedInteger('kegiatan_id');
            $table->unsignedInteger('organisasi_id');
            $table->unsignedInteger('unit_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dpa');
    }
};
