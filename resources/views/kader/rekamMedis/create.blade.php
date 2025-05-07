@extends('layouts.kader')

@section('content')
<div class="container mx-auto p-6 max-w-screen-md lg:max-w-screen-lg">
    <h2 class="text-2xl lg:text-3xl font-bold mb-4">Tambah Rekam Medis Lansia</h2>

    @if ($errors->any())
    <div class="bg-red-500 text-white p-3 rounded mb-4">
        <strong class="font-bold">Ada kesalahan:</strong>
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('rekam-medis-lansia.store') }}" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="patient_id" value="{{ $patient->id }}">

        <!-- Nama & NIK -->
        <div>
            <label class="block text-gray-700 text-lg">Nama Lengkap:</label>
            <input type="text" value="{{ $patient->nama }}" class="w-full p-3 border rounded bg-gray-100 text-lg" readonly>
        </div>
        <div>
            <label class="block text-gray-700 text-lg">NIK:</label>
            <input type="text" value="{{ $patient->nik }}" class="w-full p-3 border rounded bg-gray-100 text-lg" readonly>
        </div>

        <!-- Tanggal Rekam -->
        <div>
            <label class="block text-gray-700 text-lg">Tanggal Rekam:</label>
            <input type="date" name="tanggal_rekam" class="w-full p-3 border rounded text-lg" required value="{{ old('tanggal_rekam') }}">
        </div>

        <!-- Riwayat Penyakit -->
        <div>
            <label class="block text-gray-700 text-lg">Riwayat Penyakit:</label>
            <textarea name="riwayat_penyakit" class="w-full p-3 border rounded text-lg">{{ old('riwayat_penyakit') }}</textarea>
        </div>

        <!-- Faktor Risiko -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <label class="flex items-center space-x-2 text-lg">
                <input type="checkbox" name="merokok" value="1" {{ old('merokok') ? 'checked' : '' }}>
                <span>Merokok</span>
            </label>
            <label class="flex items-center space-x-2 text-lg">
                <input type="checkbox" name="kurang_aktivitas_fisik" value="1" {{ old('kurang_aktivitas_fisik') ? 'checked' : '' }}>
                <span>Kurang Aktivitas Fisik</span>
            </label>
            <label class="flex items-center space-x-2 text-lg">
                <input type="checkbox" name="kurang_sayur_buah" value="1" {{ old('kurang_sayur_buah') ? 'checked' : '' }}>
                <span>Kurang Sayur & Buah</span>
            </label>
            <label class="flex items-center space-x-2 text-lg">
                <input type="checkbox" name="konsumsi_alkohol" value="1" {{ old('konsumsi_alkohol') ? 'checked' : '' }}>
                <span>Konsumsi Alkohol</span>
            </label>
        </div>

        <!-- Berat & Tinggi Badan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 text-lg">Berat Badan (kg):</label>
                <input type="number" step="0.1" id="berat_badan" name="berat_badan" class="w-full p-3 border rounded text-lg" required value="{{ old('berat_badan') }}">
            </div>
            <div>
                <label class="block text-gray-700 text-lg">Tinggi Badan (cm):</label>
                <input type="number" step="0.1" id="tinggi_badan" name="tinggi_badan" class="w-full p-3 border rounded text-lg" required value="{{ old('tinggi_badan') }}">
            </div>
        </div>

        <!-- Lingkar Perut -->
        <div>
            <label class="block text-gray-700 text-lg">Lingkar Perut (cm):</label>
            <input type="number" step="0.1" name="lingkar_perut" class="w-full p-3 border rounded text-lg" required value="{{ old('lingkar_perut') }}">
        </div>

        <!-- BMI -->
        <div>
            <label class="block text-gray-700 text-lg">BMI:</label>
            <input type="text" id="bmi" name="bmi" class="w-full p-3 border rounded bg-gray-100 text-lg" readonly value="{{ old('bmi') }}">
        </div>

        <!-- Tekanan Darah -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 text-lg">Tekanan Darah Sistolik:</label>
                <input type="number" name="tekanan_darah_sistolik" class="w-full p-3 border rounded text-lg" required value="{{ old('tekanan_darah_sistolik') }}">
            </div>
            <div>
                <label class="block text-gray-700 text-lg">Tekanan Darah Diastolik:</label>
                <input type="number" name="tekanan_darah_diastolik" class="w-full p-3 border rounded text-lg" required value="{{ old('tekanan_darah_diastolik') }}">
            </div>
        </div>

        <!-- Gula Darah, Kolesterol, Asam Urat -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-gray-700 text-lg">Gula Darah (mg/dL):</label>
                <input type="number" step="0.1" name="gula_darah" class="w-full p-3 border rounded text-lg" value="{{ old('gula_darah') }}">
            </div>
            <div>
                <label class="block text-gray-700 text-lg">Kolesterol (mg/dL):</label>
                <input type="number" step="0.1" name="kolesterol" class="w-full p-3 border rounded text-lg" value="{{ old('kolesterol') }}">
            </div>
            <div>
                <label class="block text-gray-700 text-lg">Asam Urat (mg/dL):</label>
                <input type="number" step="0.1" name="asam_urat" class="w-full p-3 border rounded text-lg" value="{{ old('asam_urat') }}">
            </div>
        </div>

        <!-- Obat & Tindak Lanjut -->
        <div>
            <label class="block text-gray-700 text-lg">Obat yang Dikonsumsi:</label>
            <input type="text" name="obat" class="w-full p-3 border rounded text-lg" value="{{ old('obat') }}">
        </div>
        <div>
            <label class="block text-gray-700 text-lg">Catatan Petugas:</label>
            <textarea name="tindak_lanjut" class="w-full p-3 border rounded text-lg">{{ old('tindak_lanjut') }}</textarea>
        </div>

        <!-- Tombol -->
        <div class="flex gap-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded text-lg">Simpan</button>
            <a href="{{ route('rekam-medis-lansia.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded text-lg">Batal</a>
        </div>
    </form>
</div>

<!-- Script untuk Menghitung BMI -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const beratBadanInput = document.getElementById("berat_badan");
        const tinggiBadanInput = document.getElementById("tinggi_badan");
        const bmiInput = document.getElementById("bmi");

        function hitungBMI() {
            let berat = parseFloat(beratBadanInput.value);
            let tinggi = parseFloat(tinggiBadanInput.value) / 100;
            if (!isNaN(berat) && !isNaN(tinggi) && tinggi > 0) {
                let bmi = (berat / (tinggi * tinggi)).toFixed(2);
                bmiInput.value = bmi;
            } else {
                bmiInput.value = "";
            }
        }
        beratBadanInput.addEventListener("input", hitungBMI);
        tinggiBadanInput.addEventListener("input", hitungBMI);
    });
</script>
@endsection