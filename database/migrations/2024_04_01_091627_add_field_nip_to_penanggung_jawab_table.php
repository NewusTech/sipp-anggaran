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
            $table->string('pptk_nip')->nullable();
            $table->string('ppk_nip')->nullable();
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
            $table->dropColumn(['pptk_nip','ppk_nip']);
        });
    }
};
