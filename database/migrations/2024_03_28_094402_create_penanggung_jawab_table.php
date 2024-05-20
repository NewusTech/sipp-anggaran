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
        Schema::create('penanggung_jawab', function (Blueprint $table) {
            $table->id();
            $table->string('pptk_name')->nullable();
            $table->string('pptk_email')->nullable();
            $table->string('pptk_telpon')->nullable();
            $table->string('pptk_bidang_id')->nullable();
            $table->string('ppk_name')->nullable();
            $table->string('ppk_email')->nullable();
            $table->string('ppk_telpon')->nullable();
            $table->string('ppk_bidang_id')->nullable();
            $table->string('kegiatan_id')->nullable();
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
        Schema::dropIfExists('penanggung_jawab');
    }
};