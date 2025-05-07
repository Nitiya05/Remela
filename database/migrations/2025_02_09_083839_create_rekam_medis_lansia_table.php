<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('rekam_medis_lansia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('pasiens')->onDelete('cascade');
            $table->date('tanggal_rekam');
            $table->text('riwayat_penyakit')->nullable();
            $table->boolean('merokok')->default(false);
            $table->boolean('kurang_aktivitas_fisik')->default(false);
            $table->boolean('kurang_sayur_buah')->default(false);
            $table->boolean('konsumsi_alkohol')->default(false);
            $table->decimal('berat_badan', 5, 1); // Tetap decimal karena bisa 65.5 kg
            $table->decimal('tinggi_badan', 5, 1); // Tetap decimal karena bisa 165.5 cm
            $table->decimal('lingkar_perut', 5, 1); // Tetap decimal karena bisa 90.5 cm
            $table->decimal('bmi', 5, 1); // Tetap decimal karena bisa 25.7
            $table->unsignedSmallInteger('tekanan_darah_sistolik'); // Contoh: 120
            $table->unsignedSmallInteger('tekanan_darah_diastolik'); // Contoh: 80
            $table->unsignedSmallInteger('gula_darah')->nullable(); // Contoh: 126
            $table->unsignedSmallInteger('kolesterol')->nullable(); // Contoh: 200
            $table->decimal('asam_urat', 5, 1)->nullable(); // Contoh: 5.5
            $table->string('obat')->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rekam_medis_lansia');
    }
};