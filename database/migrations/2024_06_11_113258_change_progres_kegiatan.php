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
            $table->date('bulan')->nullable()->change();
            $table->integer('nilai')->after('fisik')->nullable();
        });

        Schema::table('progres_kegiatan', function (Blueprint $table) {
            $table->renameColumn('bulan', 'tanggal');
            $table->string('jenis_progres')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('progres_kegiatan', function (Blueprint $table) {
            $table->integer('keuangan');
            $table->renameColumn('jenis_progres', 'fisik');
            $table->string('bulan')->nullable()->change();
            $table->dropColumn('nilai');
            $table->integer('fisik')->nullable()->change();
        });

        Schema::table('progres_kegiatan', function (Blueprint $table) {
            $table->renameColumn('tanggal', 'bulan');
        });
    }
};
