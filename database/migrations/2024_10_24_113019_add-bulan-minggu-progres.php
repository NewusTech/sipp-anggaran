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
        Schema::table('progres_kegiatan', function (Blueprint $table) {
            $table->string('bulan')->after('tanggal')->nullable();
            $table->string('minggu')->after('bulan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('progres_kegiatan', function (Blueprint $table) {
            $table->dropColumn('bulan');
            $table->dropColumn('minggu');
        });
    }
};
