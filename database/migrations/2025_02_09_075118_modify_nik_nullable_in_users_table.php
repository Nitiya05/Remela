<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus unique constraint jika sudah ada
            $table->dropUnique(['nik']);

            // Ubah kolom nik menjadi nullable dan tetap unique
            $table->string('nik', 16)->nullable()->unique()->change();
        });
    }

    // public function down()
    // {
    //     Schema::table('users', function (Blueprint $table) {
    //         // Kembalikan ke kondisi awal (tidak nullable, tetap unique)
    //         $table->string('nik', 16)->unique()->change();
    //     });
    // }
};
