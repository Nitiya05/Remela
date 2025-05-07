<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKadersTable extends Migration
{
    public function up()
    {
        Schema::create('kaders', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama wajib
            $table->string('email')->unique(); // Email wajib
            $table->string('no_hp')->nullable(); // Nomor HP opsional
            $table->string('password'); // Password wajib
            $table->string('nik')->nullable(); // NIK opsional
            $table->unsignedBigInteger('user_id'); // Relasi ke user
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Relasi ke tabel users
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kaders');
    }
}
