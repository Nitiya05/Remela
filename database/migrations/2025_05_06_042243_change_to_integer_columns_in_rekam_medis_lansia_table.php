<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('rekam_medis_lansia', function (Blueprint $table) {
            // Ubah kolom decimal menjadi integer
            $table->unsignedSmallInteger('tekanan_darah_sistolik')->change();
            $table->unsignedSmallInteger('tekanan_darah_diastolik')->change();
            $table->unsignedSmallInteger('gula_darah')->nullable()->change();
            $table->unsignedSmallInteger('kolesterol')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('rekam_medis_lansia', function (Blueprint $table) {
            // Kembalikan ke tipe data semula jika rollback
            $table->decimal('tekanan_darah_sistolik', 5, 2)->change();
            $table->decimal('tekanan_darah_diastolik', 5, 2)->change();
            $table->decimal('gula_darah', 5, 2)->nullable()->change();
            $table->decimal('kolesterol', 5, 2)->nullable()->change();
        });
    }
};