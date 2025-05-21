@extends('layouts.kader')

@section('content')
    <div class="container mx-auto p-4 max-w-screen-lg">
        <h2 class="text-2xl font-bold mb-6 text-blue-800">Edit Rekam Medis Lansia</h2>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <p class="font-bold">Perhatian!</p>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('rekam-medis-lansia.update', $record->id) }}" method="POST"
            class="space-y-6 bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <input type="hidden" name="patient_id" value="{{ $record->patient_id }}">

            <!-- Informasi Pasien -->
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="text-xl font-semibold text-blue-800 mb-4">Informasi Pasien</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-1 text-lg">Nama Lengkap:</label>
                        <p class="p-3 border border-gray-300 rounded bg-white text-lg font-medium">
                            {{ $record->pasien->nama }}</p>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-1 text-lg">NIK:</label>
                        <p class="p-3 border border-gray-300 rounded bg-white text-lg font-medium">
                            {{ $record->pasien->nik }}</p>
                    </div>
                </div>
            </div>

            <!-- Data Rekam Medis -->
            <div class="space-y-6">
                <h3 class="text-xl font-semibold text-blue-800 mb-4">Data Rekam Medis</h3>

                <div>
                    <label class="block text-gray-700 font-medium mb-2 text-lg">Tanggal Pemeriksaan:</label>
                    <input type="date" name="tanggal_rekam"
                        class="w-full p-3 border border-gray-300 rounded text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('tanggal_rekam', $record->tanggal_rekam) }}" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2 text-lg">Riwayat Penyakit:</label>
                    <textarea name="riwayat_penyakit" rows="3"
                        class="w-full p-3 border border-gray-300 rounded text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('riwayat_penyakit', $record->riwayat_penyakit) }}</textarea>
                </div>

                <div class="bg-yellow-50 p-4 rounded-lg">
                    <h4 class="font-medium text-lg mb-3">Faktor Risiko:</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ([
            'merokok' => 'Merokok',
            'kurang_aktivitas_fisik' => 'Kurang Aktivitas Fisik',
            'kurang_sayur_buah' => 'Kurang Sayur & Buah',
            'konsumsi_alkohol' => 'Konsumsi Alkohol',
        ] as $name => $label)
                            <label class="flex items-center space-x-3 text-lg">
                                <input type="checkbox" name="{{ $name }}" value="1"
                                    class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500"
                                    {{ old($name, $record->$name) ? 'checked' : '' }}>
                                <span class="font-medium">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2 text-lg">Berat Badan (kg):</label>
                        <input type="number" step="0.1" id="berat_badan" name="berat_badan"
                            class="w-full p-3 border border-gray-300 rounded text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('berat_badan', $record->berat_badan) }}" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2 text-lg">Tinggi Badan (cm):</label>
                        <input type="number" step="0.1" id="tinggi_badan" name="tinggi_badan"
                            class="w-full p-3 border border-gray-300 rounded text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('tinggi_badan', $record->tinggi_badan) }}" required>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2 text-lg">Lingkar Perut (cm):</label>
                        <input type="number" step="0.1" name="lingkar_perut"
                            class="w-full p-3 border border-gray-300 rounded text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('lingkar_perut', $record->lingkar_perut) }}" required>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2 text-lg">Indeks Massa Tubuh:</label>
                    <input type="text" id="bmi" name="bmi"
                        class="w-full p-3 border border-gray-300 rounded bg-gray-100 text-lg" readonly
                        value="{{ old('bmi', $record->bmi) }}">
                </div>

                <!-- Tekanan Darah dengan tampilan sistolik/diastolik dalam satu baris -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2 text-lg">Tekanan Darah (Sistolik /
                        Diastolik):</label>
                    <div class="flex space-x-2">
                        <input type="number" name="tekanan_darah_sistolik"
                            class="w-1/2 p-3 border border-gray-300 rounded text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Sistolik" required
                            value="{{ old('tekanan_darah_sistolik', $record->tekanan_darah_sistolik) }}">
                        <span class="inline-flex items-center px-2 text-lg font-semibold">/</span>
                        <input type="number" name="tekanan_darah_diastolik"
                            class="w-1/2 p-3 border border-gray-300 rounded text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Diastolik" required
                            value="{{ old('tekanan_darah_diastolik', $record->tekanan_darah_diastolik) }}">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2 text-lg">Gula Darah (mg/dL):</label>
                        <input type="number" step="0.1" name="gula_darah"
                            class="w-full p-3 border border-gray-300 rounded text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('gula_darah', $record->gula_darah) }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2 text-lg">Kolesterol (mg/dL):</label>
                        <input type="number" step="0.1" name="kolesterol"
                            class="w-full p-3 border border-gray-300 rounded text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('kolesterol', $record->kolesterol) }}">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2 text-lg">Asam Urat (mg/dL):</label>
                        <input type="number" step="0.1" name="asam_urat"
                            class="w-full p-3 border border-gray-300 rounded text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            value="{{ old('asam_urat', $record->asam_urat) }}">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2 text-lg">Obat yang Dikonsumsi:</label>
                    <input type="text" name="obat"
                        class="w-full p-3 border border-gray-300 rounded text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('obat', $record->obat) }}">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2 text-lg">Catatan Petugas:</label>
                    <textarea name="catatan" rows="3"
                        class="w-full p-3 border border-gray-300 rounded text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('catatan', $record->catatan) }}</textarea>
                </div>
            </div>

            <div class="pt-4 flex space-x-4">
                <button type="submit"
                    class="bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 px-6 rounded-lg text-lg transition duration-200">
                    Simpan Perubahan
                </button>

                <a href="{{ route('rekam-medis-lansia.index') }}"
                    class="inline-block bg-gray-400 hover:bg-gray-500 text-white font-semibold py-3 px-6 rounded-lg text-lg transition duration-200">
                    Batal
                </a>
            </div>

        </form>
    </div>

    <script>
        // Fungsi hitung BMI otomatis saat berat atau tinggi badan diubah
        function hitungBMI() {
            const berat = parseFloat(document.getElementById('berat_badan').value);
            const tinggiCm = parseFloat(document.getElementById('tinggi_badan').value);
            if (!isNaN(berat) && !isNaN(tinggiCm) && tinggiCm > 0) {
                const tinggiM = tinggiCm / 100;
                const bmi = berat / (tinggiM * tinggiM);
                document.getElementById('bmi').value = bmi.toFixed(2);
            } else {
                document.getElementById('bmi').value = '';
            }
        }

        document.getElementById('berat_badan').addEventListener('input', hitungBMI);
        document.getElementById('tinggi_badan').addEventListener('input', hitungBMI);

        // Inisialisasi hitung BMI saat halaman load
        document.addEventListener('DOMContentLoaded', () => {
            hitungBMI();
        });
    </script>
@endsection
