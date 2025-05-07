<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEmailNullableInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Membuat kolom email menjadi nullable lagi
            $table->string('email')->nullable()->change();
        });
    }

    // public function down()
    // {
    //     Schema::table('users', function (Blueprint $table) {
    //         // Membalikkan perubahan, menjadikan email tidak nullable
    //         $table->string('email')->nullable(false)->change();
    //     });
    // }
}
