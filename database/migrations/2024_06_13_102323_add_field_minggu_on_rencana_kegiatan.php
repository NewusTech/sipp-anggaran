<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rencana_kegiatan', function (Blueprint $table) {
            $table->string('minggu')->after('bulan')->nullable();
        });
    }

    public function down()
    {
        Schema::table('rencana_kegiatan', function (Blueprint $table) {
            $table->dropColumn('minggu');
        });
    }
};
