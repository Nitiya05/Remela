<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('rekam_medis_lansia', function (Blueprint $table) {
            $table->renameColumn('tindak_lanjut', 'catatan_petugas');
        });
    }

    public function down()
    {
        Schema::table('rekam_medis_lansia', function (Blueprint $table) {
            $table->renameColumn('catatan_petugas', 'tindak_lanjut');
        });
    }
};
