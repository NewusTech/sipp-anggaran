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
        Schema::table('rencana_kegiatan', function (Blueprint $table) {
            $table->float('fisik')->change();
            $table->float('keuangan')->change();
        });

        Schema::table('progres_kegiatan', function (Blueprint $table) {
            $table->float('nilai')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rencana_kegiatan', function (Blueprint $table) {
            $table->integer('fisik')->change();
            $table->integer('keuangan')->change();
        });

        Schema::table('progres_kegiatan', function (Blueprint $table) {
            $table->integer('nilai')->change();
        });
    }
};
