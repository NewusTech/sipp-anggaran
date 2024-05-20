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
        Schema::table('anggaran', function (Blueprint $table) {
            $table->double('daya_serap_kontrak')->nullable();
            $table->double('sisa_kontrak')->nullable();
            $table->double('sisa_anggaran')->nullable();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anggaran', function (Blueprint $table) {
            $table->dropColumn(['daya_serap_kontrak','sisa_kontrak','sisa_anggaran']);
        });
    }
};
