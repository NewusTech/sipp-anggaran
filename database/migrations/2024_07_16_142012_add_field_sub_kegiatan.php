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
        Schema::table('sub_kegiatan', function (Blueprint $table) {
            $table->string('kode_sub_kegiatan')->after('id')->nullable();
            $table->string('title')->after('kode_sub_kegiatan')->nullable();
            $table->dropColumn('sumber_dana_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_kegiatan', function (Blueprint $table) {
            $table->dropColumn('kode_sub_kegiatan');
            $table->dropColumn('title');
            $table->integer('sumber_dana_id')->after('detail_kegiatan_id')->nullable();
        });
    }
};
