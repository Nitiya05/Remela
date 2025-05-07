<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Cek dulu apakah kolom sudah ada
        if (Schema::hasColumn('pasiens', 'user_id')) {
            // Jika sudah ada, lakukan modify kolom
            Schema::table('pasiens', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->change();
            });
        } else {
            // Jika belum ada, tambahkan kolom baru
            Schema::table('pasiens', function (Blueprint $table) {
                $table->foreignId('user_id')->constrained()->after('id');
            });
        }
    }

    public function down()
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
