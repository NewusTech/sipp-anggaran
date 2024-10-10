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
        // Schema::table('penanggung_jawab', function (Blueprint $table) {
        //     $table->dropForeign(['detail_kegiatan_id']);
        // });

        Schema::table('detail_kegiatan', function (Blueprint $table) {
            $table->foreignId('penanggung_jawab_id')->nullable()->constrained('penanggung_jawab')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_kegiatan', function (Blueprint $table) {
            $table->dropForeign(['penanggung_jawab_id']);
            $table->dropColumn('penanggung_jawab_id');
        });

        // Schema::table('penanggung_jawab', function (Blueprint $table) {
        //     $table->foreignId('detail_kegiatan_id')->nullable()->constrained('detail_kegiatan')->onDelete('no action')->onUpdate('no action');
        // });
    }
};
