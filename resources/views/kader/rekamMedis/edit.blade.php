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

    <form action="{{ route('rekam-medis-lansia.update', $record->id) }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')

        <input type="hidden" name="pasien_id" value="{{ $record->patient_id }}">

        <!-- Patient Info Section -->
        <div class="bg-blue-50 p-4 rounded-lg">
            <h3 class="text-xl font-semibold text-blue-800 mb-4">Informasi Pasien</h3>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1 text-lg">Nama Lengkap:</label>
                    <p class="p-3 border border-gray-300 rounded bg-white text-lg font-medium">{{ $record->pasien->nama }}</p>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1 text-lg">NIK:</label>
                    <p class="p-3 border border-gray-300 rounded bg-white text-lg font-medium">{{ $record->pasien->nik }}</p>
                </div>
            </div>
        </div>

        <!-- Medical Record Section -->
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
                        'konsumsi_alkohol' => 'Konsumsi Alkohol'
                    ] as $name => $label)
                        <label class="flex items-center space-x-3 text-lg">
                            <input type="checkbox" name="{{ $name }}" value="1" 
                                   class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500"
                                   {{ $record->$name ? 'checked' : '' }}>
                            <span class="font-medium">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2 text-lg">Berat Badan (kg):</label>
                    <input type="number" id="berat_badan" name="berat_badan" 
                           class="w-full p-3 border border-gray-300 rounded text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           value="{{ old('berat_badan', $record->berat_badan) }}" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2 text-lg">Tinggi Badan (cm):</label>
                    <input type="number" id="tinggi_badan" name="tinggi_badan" 
                           class="w-full p-3 border border-gray-300 rounded text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           value="{{ old('tinggi_badan', $record->tinggi_badan) }}" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2 text-lg">Indeks Massa Tubuh (BMI):</label>
                    <input type="text" id="bmi" name="bmi" 
                           class="w-full p-3 border border-gray-300 rounded bg-gray-100 text-lg font-medium" 
                           value="{{ $record->bmi }}" readonly>
                </div>
            </div>

            <!-- Added Blood Pressure Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2 text-lg">Tekanan Darah Sistolik (mmHg):</label>
                    <input type="number" name="sistolik" 
                           class="w-full p-3 border border-gray-300 rounded text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           value="{{ old('sistolik', $record->sistolik) }}"
                           min="50" max="250">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2 text-lg">Tekanan Darah Diastolik (mmHg):</label>
                    <input type="number" name="diastolik" 
                           class="w-full p-3 border border-gray-300 rounded text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                           value="{{ old('diastolik', $record->diastolik) }}"
                           min="30" max="150">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach ([
                    'gula_darah' => 'Gula Darah (mg/dL)',
                    'kolesterol' => 'Kolesterol (mg/dL)',
                    'asam_urat' => 'Asam Urat (mg/dL)'
                ] as $name => $label)
                    <div>
                        <label class="block text-gray-700 font-medium mb-2 text-lg">{{ $label }}:</label>
                        <input type="number" name="{{ $name }}" 
                               class="w-full p-3 border border-gray-300 rounded text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                               value="{{ old($name, $record->$name) }}">
                    </div>
                @endforeach
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2 text-lg">Obat yang Dikonsumsi:</label>
                <input type="text" name="obat" 
                       class="w-full p-3 border border-gray-300 rounded text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                       value="{{ old('obat', $record->obat) }}">
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2 text-lg">Tindak Lanjut/Rekomendasi:</label>
                <textarea name="tindak_lanjut" rows="3"
                          class="w-full p-3 border border-gray-300 rounded text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('tindak_lanjut', $record->tindak_lanjut) }}</textarea>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 pt-4">
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-lg transition duration-200 flex-1">
                Simpan Perubahan
            </button>
            <a href="{{ route('rekam-medis-lansia.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg text-lg text-center transition duration-200 flex-1">
                Kembali
            </a>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Larger font size and better contrast for elderly
        document.querySelectorAll('input, textarea, select').forEach(el => {
            el.style.fontSize = '1.125rem'; // 18px
        });

        // BMI Calculation
        const beratBadanInput = document.getElementById("berat_badan");
        const tinggiBadanInput = document.getElementById("tinggi_badan");
        const bmiInput = document.getElementById("bmi");

        function hitungBMI() {
            const berat = parseFloat(beratBadanInput.value);
            const tinggi = parseFloat(tinggiBadanInput.value) / 100; // Convert cm to m
            
            if (!isNaN(berat) && !isNaN(tinggi) && tinggi > 0) {
                const bmi = (berat / (tinggi * tinggi)).toFixed(1);
                bmiInput.value = bmi;
                
                // Color coding based on BMI value
                if (bmi < 18.5) {
                    bmiInput.classList.add('bg-blue-100');
                    bmiInput.classList.remove('bg-green-100', 'bg-yellow-100', 'bg-red-100');
                } else if (bmi >= 18.5 && bmi <= 24.9) {
                    bmiInput.classList.add('bg-green-100');
                    bmiInput.classList.remove('bg-blue-100', 'bg-yellow-100', 'bg-red-100');
                } else if (bmi >= 25 && bmi <= 29.9) {
                    bmiInput.classList.add('bg-yellow-100');
                    bmiInput.classList.remove('bg-blue-100', 'bg-green-100', 'bg-red-100');
                } else {
                    bmiInput.classList.add('bg-red-100');
                    bmiInput.classList.remove('bg-blue-100', 'bg-green-100', 'bg-yellow-100');
                }
            } else {
                bmiInput.value = "";
                bmiInput.classList.remove('bg-blue-100', 'bg-green-100', 'bg-yellow-100', 'bg-red-100');
            }
        }

        beratBadanInput.addEventListener("input", hitungBMI);
        tinggiBadanInput.addEventListener("input", hitungBMI);
        
        // Initial calculation
        hitungBMI();
    });
</script>
@endsection