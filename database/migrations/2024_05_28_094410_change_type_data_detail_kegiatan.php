<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('detail_kegiatan', function (Blueprint $table) {
            $table->string('no_detail_kegiatan')->change();
        });
    }

    public function down()
    {
        Schema::table('detail_kegiatan', function (Blueprint $table) {
            $table->unsignedInteger('no_detail_kegiatan')->change();
        });
    }
};
