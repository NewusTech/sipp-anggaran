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
        Schema::create('pengambilan', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('detail_kegiatan_id');
            $table->decimal('belanja_operasi', 15, 2)->nullable()->default(0);
            $table->decimal('belanja_modal', 15, 2)->nullable()->default(0);
            $table->decimal('belanja_tak_terduga', 15, 2)->nullable()->default(0);
            $table->decimal('belanja_transfer', 15, 2)->nullable()->default(0);
            $table->string('keterangan')->nullable();
            $table->string('bulan')->nullable();
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
        Schema::dropIfExists('pengambilan');
    }
};
