<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('detail_kegiatan', function (Blueprint $table) {
            $table->string('verifikasi_admin')->default('false');
            $table->text('komentar_admin')->nullable();
            $table->string('verifikasi_pengawas')->default('false');
            $table->text('komentar_pengawas')->nullable();
        });
    }


    public function down()
    {
        Schema::table('detail_kegiatan', function (Blueprint $table) {
            $table->dropColumn(['verifikasi_admin', 'komentar_admin', 'verifikasi_pengawas', 'komentar_pengawas']);
        });
    }
};
