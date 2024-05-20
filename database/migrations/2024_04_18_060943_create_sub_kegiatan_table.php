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
        Schema::create('sub_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('dpa_id');
            $table->unsignedInteger('kegiatan_id');
            $table->unsignedInteger('detail_kegiatan_id');
            $table->unsignedInteger('sumber_dana_id');
            $table->string('lokasi')->nullable();
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
        Schema::dropIfExists('sub_kegiatan');
    }
};
