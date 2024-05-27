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
        Schema::table('detail_kegiatan', function (Blueprint $table) {
            $table->unsignedInteger('no_detail_kegiatan')->after('id');
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
            $table->dropColumn('no_detail_kegiatan');
        });
    }
};
