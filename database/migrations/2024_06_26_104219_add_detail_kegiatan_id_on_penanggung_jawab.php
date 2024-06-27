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
        Schema::table('penanggung_jawab', function (Blueprint $table) {
            $table->foreignId('detail_kegiatan_id')->nullable()->constrained('detail_kegiatan')->onDelete('no action')->onUpdate('no action');
        });

        schema::table('rencana_kegiatan', function (Blueprint $table) {
            $table->foreignId('detail_kegiatan_id')->nullable()->constrained('detail_kegiatan')->onDelete('no action')->onUpdate('no action');
        });

        Schema::table('progres_kegiatan', function (Blueprint $table) {
            $table->foreignId('detail_kegiatan_id')->nullable()->constrained('detail_kegiatan')->onDelete('no action')->onUpdate('no action');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penanggung_jawab', function (Blueprint $table) {
            $table->dropForeign(['detail_kegiatan_id']);
            $table->dropColumn('detail_kegiatan_id');
        });

        schema::table('rencana_kegiatan', function (Blueprint $table) {
            $table->dropForeign(['detail_kegiatan_id']);
            $table->dropColumn('detail_kegiatan_id');
        });

        schema::table('progres_kegiatan', function (Blueprint $table) {
            $table->dropForeign(['detail_kegiatan_id']);
            $table->dropColumn('detail_kegiatan_id');
        });
    }
};
