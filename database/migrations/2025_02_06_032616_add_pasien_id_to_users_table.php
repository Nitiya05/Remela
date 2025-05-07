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
        // Menambahkan kolom pasien_id ke tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('pasien_id')->nullable(); // Bisa null, karena user bisa terdaftar tanpa pasien
            $table->foreign('pasien_id')->references('id')->on('pasiens')->onDelete('cascade');
        });
    }

    public function down()
    {
        // Menghapus kolom pasien_id
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['pasien_id']);
            $table->dropColumn('pasien_id');
        });
    }

};
