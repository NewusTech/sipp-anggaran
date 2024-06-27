<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rencana_kegiatan', function (Blueprint $table) {
            $table->dropForeign(['detail_kegiatan_id']);
            $table->foreign('detail_kegiatan_id')
                ->references('id')->on('detail_kegiatan')
                ->onDelete('no action')
                ->onUpdate('no action');
        });

        Schema::table('progres_kegiatan', function (Blueprint $table) {
            $table->dropForeign(['detail_kegiatan_id']);
            $table->foreign('detail_kegiatan_id')
                ->references('id')->on('detail_kegiatan')
                ->onDelete('no action')
                ->onUpdate('no action');
        });
    }

    public function down()
    {
        Schema::table('rencana_kegiatan', function (Blueprint $table) {
            $table->dropForeign(['detail_kegiatan_id']);
            $table->foreign('detail_kegiatan_id')
                ->references('id')->on('detail_kegiatan');
        });

        Schema::table('progres_kegiatan', function (Blueprint $table) {
            $table->dropForeign(['detail_kegiatan_id']);
            $table->foreign('detail_kegiatan_id')
                ->references('id')->on('detail_kegiatan');
        });
    }
};
