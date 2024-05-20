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
        Schema::create('pengguna_anggaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('dpa_id');
            $table->string('name')->nullable();
            $table->string('nip', 100)->nullable();
            $table->string('jabatan')->nullable();
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
        Schema::dropIfExists('pengguna_anggaran');
    }
};
