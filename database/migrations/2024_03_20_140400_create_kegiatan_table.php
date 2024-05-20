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
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('no_rek');
            $table->string('tahun');
            $table->string('program');
            $table->string('no_rek_program')->nullable();
            $table->bigInteger('bidang_id')->nullable();
            $table->string('sumber_dana')->nullable();
            $table->string('jenis_paket');
            $table->boolean('is_arship')->nullable()->default(false);
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
        Schema::dropIfExists('kegiatan');
    }
};