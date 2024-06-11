<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('progres_kegiatan', function (Blueprint $table) {
            $table->dropColumn('keuangan');
            $table->renameColumn('fisik', 'jenis_progres');
        });
    }

    public function down()
    {
        Schema::table('progres_kegiatan', function (Blueprint $table) {
            $table->integer('keuangan');
            $table->renameColumn('jenis_progres', 'fisik');
        });
    }
};
