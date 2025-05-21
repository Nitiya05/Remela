@extends('layouts.pasien')

@section('title', 'Dashboard Pasien')

@section('content')
    <div class="relative px-4 sm:px-6 lg:px-8 py-6 md:py-12 bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Konten Utama -->
        <div class="relative z-10 pb-24 md:pb-32"> <!-- Padding bottom untuk menghindari tumpang tindih -->
            <h1 class="text-2xl md:text-4xl font-semibold">Halo, {{ Auth::user()->name }}</h1>
            <p class="text-base md:text-xl text-gray-600 font-normal mt-2">
                Jangan lupa untuk cek kesehatan dan jaga kesehatan ya!
            </p>
        </div>

        <!-- Wave Section -->
        <div class="absolute inset-x-0 bottom-0 z-0">
            <img src="{{ asset('images/wave.svg') }}" class="w-full" alt="Wave Background">
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-blue-100 py-6">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">


            <!-- Grafik Perkembangan Kesehatan Lansia -->
            <div class="space-y-8 max-w-6xl mx-auto">
                <!-- Header dengan ukuran font lebih besar -->
                <div class="text-center">
                    <h2 class="text-3xl md:text-4xl font-bold text-sky-700 mb-3">PERKEMBANGAN KESEHATAN ANDA</h2>
                    <p class="text-lg text-gray-700 max-w-3xl mx-auto">Pantau grafik kesehatan Anda bulan ini</p>
                </div>

                <!-- Keterangan dengan kontras tinggi -->
                <div class="bg-blue-50 p-6 rounded-xl border-2 border-blue-200">
                    <h3 class="font-bold text-xl mb-4 flex items-center text-blue-800">
                        <svg class="w-6 h-6 text-blue-700 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        PETUNJUK MEMBACA GRAFIK
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Warna Status -->
                        <div>
                            <h4 class="font-semibold text-lg mb-3 text-gray-800 underline">ARTI WARNA:</h4>
                            <div class="space-y-3">
                                <div class="flex items-center space-x-3">
                                    <span class="w-5 h-5 rounded-full bg-green-600 border-2 border-green-800"></span>
                                    <span class="text-lg text-gray-800">NORMAL (Aman)</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="w-5 h-5 rounded-full bg-yellow-500 border-2 border-yellow-700"></span>
                                    <span class="text-lg text-gray-800">WASPADA (Perhatian)</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="w-5 h-5 rounded-full bg-red-600 border-2 border-red-800"></span>
                                    <span class="text-lg text-gray-800">BAHAYA (Segera konsultasi dokter)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Simbol Trend -->
                        <div>
                            <h4 class="font-semibold text-lg mb-3 text-gray-800 underline">ARTI PANAH:</h4>
                            <div class="space-y-3">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-6 h-6 text-green-700" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M12 7a1 1 0 01.707.293l4 4a1 1 0 01-1.414 1.414L12 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4A1 1 0 0112 7z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-lg text-gray-800">MENURUN (Hasil membaik)</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <svg class="w-6 h-6 text-red-700" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M12 13a1 1 0 01-.707-.293l-4-4a1 1 0 011.414-1.414L12 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4A1 1 0 0112 13z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-lg text-gray-800">NAIK (Perlu perhatian)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Catatan khusus lansia -->
                    <div class="mt-6 bg-blue-100 p-4 rounded-lg">
                        <h4 class="font-semibold text-lg mb-2 text-blue-800">CATATAN KHUSUS LANSIA:</h4>
                        <p class="text-gray-800">Nilai normal untuk lansia mungkin berbeda dengan usia muda. Beberapa
                            parameter memiliki batas yang lebih tinggi karena perubahan fisiologis terkait usia.</p>
                    </div>
                </div>

                <!-- Grid Grafik -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Tekanan Darah -->
                    <div class="bg-white p-6 rounded-xl shadow-lg border-2 border-blue-100">
                        <div class="flex justify-between items-start mb-5">
                            <div>
                                <h3 class="font-bold text-2xl text-blue-800 mb-1">TEKANAN DARAH</h3>
                                <p class="text-lg text-gray-700">Sistolik / Diastolik (mmHg)</p>
                            </div>
                            <span class="bg-blue-200 text-blue-900 text-lg px-3 py-1 rounded-full font-bold">2 Data</span>
                        </div>
                        <div class="h-72 mb-6">
                            <canvas id="chartTekananDarah"></canvas>
                        </div>
                        <div class="space-y-3 text-lg bg-blue-50 p-4 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <span class="w-4 h-4 rounded-full bg-green-600 border-2 border-green-800"></span>
                                <span class="text-gray-800"><strong>Normal (Lansia):</strong> Dibawah 150/90</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="w-4 h-4 rounded-full bg-yellow-500 border-2 border-yellow-700"></span>
                                <span class="text-gray-800"><strong>Waspada:</strong> 150-160/90-100</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="w-4 h-4 rounded-full bg-red-600 border-2 border-red-800"></span>
                                <span class="text-gray-800"><strong>Bahaya:</strong> 160/100 atau lebih</span>
                            </div>
                        </div>
                    </div>

                    <!-- Gula Darah -->
                    <div class="bg-white p-6 rounded-xl shadow-lg border-2 border-purple-100">
                        <div class="mb-5">
                            <h3 class="font-bold text-2xl text-purple-800 mb-1">GULA DARAH</h3>
                            <p class="text-lg text-gray-700">Setelah makan (mg/dL)</p>
                        </div>
                        <div class="h-72 mb-6">
                            <canvas id="chartGulaDarah"></canvas>
                        </div>
                        <div class="space-y-3 text-lg bg-purple-50 p-4 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <span class="w-4 h-4 rounded-full bg-green-600 border-2 border-green-800"></span>
                                <span class="text-gray-800"><strong>Normal:</strong> 70-130</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="w-4 h-4 rounded-full bg-yellow-500 border-2 border-yellow-700"></span>
                                <span class="text-gray-800"><strong>Waspada:</strong> 130-180</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="w-4 h-4 rounded-full bg-red-600 border-2 border-red-800"></span>
                                <span class="text-gray-800"><strong>Bahaya:</strong> 180 atau lebih</span>
                            </div>
                        </div>
                    </div>

                    <!-- Kolesterol -->
                    <div class="bg-white p-6 rounded-xl shadow-lg border-2 border-amber-100">
                        <div class="mb-5">
                            <h3 class="font-bold text-2xl text-amber-800 mb-1">KOLESTEROL</h3>
                            <p class="text-lg text-gray-700">Total (mg/dL)</p>
                        </div>
                        <div class="h-72 mb-6">
                            <canvas id="chartKolesterol"></canvas>
                        </div>
                        <div class="space-y-3 text-lg bg-amber-50 p-4 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <span class="w-4 h-4 rounded-full bg-green-600 border-2 border-green-800"></span>
                                <span class="text-gray-800"><strong>Normal:</strong> Dibawah 200</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="w-4 h-4 rounded-full bg-yellow-500 border-2 border-yellow-700"></span>
                                <span class="text-gray-800"><strong>Waspada:</strong> 200-239</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="w-4 h-4 rounded-full bg-red-600 border-2 border-red-800"></span>
                                <span class="text-gray-800"><strong>Bahaya:</strong> 240 atau lebih</span>
                            </div>
                        </div>
                    </div>

                    <!-- IMT -->
                    <div class="bg-white p-6 rounded-xl shadow-lg border-2 border-emerald-100">
                        <div class="mb-5">
                            <h3 class="font-bold text-2xl text-emerald-800 mb-1">INDEKS MASSA TUBUH</h3>
                            <p class="text-lg text-gray-700">Berat badan ideal (kg/m²)</p>
                        </div>
                        <div class="h-72 mb-6">
                            <canvas id="chartIMT"></canvas>
                        </div>
                        <div class="space-y-3 text-lg bg-emerald-50 p-4 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <span class="w-4 h-4 rounded-full bg-blue-600 border-2 border-blue-800"></span>
                                <span class="text-gray-800"><strong>Kurus (Lansia):</strong> Dibawah 22</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="w-4 h-4 rounded-full bg-green-600 border-2 border-green-800"></span>
                                <span class="text-gray-800"><strong>Normal (Lansia):</strong> 22-27</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="w-4 h-4 rounded-full bg-yellow-500 border-2 border-yellow-700"></span>
                                <span class="text-gray-800"><strong>Gemuk:</strong> 27-30</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="w-4 h-4 rounded-full bg-red-600 border-2 border-red-800"></span>
                                <span class="text-gray-800"><strong>Obesitas:</strong> 30 atau lebih</span>
                            </div>
                        </div>
                    </div>

                    <!-- Asam Urat -->
                    <div class="bg-white p-6 rounded-xl shadow-lg border-2 border-red-100">
                        <div class="mb-5">
                            <h3 class="font-bold text-2xl text-red-800 mb-1">ASAM URAT</h3>
                            <p class="text-lg text-gray-700">Kadar asam urat (mg/dL)</p>
                        </div>
                        <div class="h-72 mb-6">
                            <canvas id="chartAsamUrat"></canvas>
                        </div>
                        <div class="space-y-3 text-lg bg-red-50 p-4 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <span class="w-4 h-4 rounded-full bg-green-600 border-2 border-green-800"></span>
                                <span class="text-gray-800"><strong>Normal Pria:</strong> Dibawah 7.0</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="w-4 h-4 rounded-full bg-green-600 border-2 border-green-800"></span>
                                <span class="text-gray-800"><strong>Normal Wanita:</strong> Dibawah 6.0</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="w-4 h-4 rounded-full bg-red-600 border-2 border-red-800"></span>
                                <span class="text-gray-800"><strong>Bahaya:</strong> Melebihi batas normal</span>
                            </div>
                        </div>
                    </div>

                    <!-- Lingkar Perut -->
                    <div class="bg-white p-6 rounded-xl shadow-lg border-2 border-indigo-100">
                        <div class="mb-5">
                            <h3 class="font-bold text-2xl text-indigo-800 mb-1">LINGKAR PERUT</h3>
                            <p class="text-lg text-gray-700">Ukuran lingkar perut (cm)</p>
                        </div>
                        <div class="h-72 mb-6">
                            <canvas id="chartLingkarPerut"></canvas>
                        </div>
                        <div class="space-y-3 text-lg bg-indigo-50 p-4 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <span class="w-4 h-4 rounded-full bg-green-600 border-2 border-green-800"></span>
                                <span class="text-gray-800"><strong>Normal Pria:</strong> Dibawah 90</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="w-4 h-4 rounded-full bg-green-600 border-2 border-green-800"></span>
                                <span class="text-gray-800"><strong>Normal Wanita:</strong> Dibawah 80</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="w-4 h-4 rounded-full bg-red-600 border-2 border-red-800"></span>
                                <span class="text-gray-800"><strong>Bahaya:</strong> Melebihi batas normal</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Kesehatan Bulan Ini / Pemeriksaan Terakhir -->
            @php
                $userGender = auth()->user()->pasien->jenis_kelamin ?? 'L'; // Default to male if not set
            @endphp
            <div class="bg-white p-6 shadow-lg rounded-lg mt-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <div class="text-center md:text-left">
                        <h2 class="text-xl md:text-2xl font-bold text-sky-900">Pemeriksaan Terakhir</h2>
                        @if ($riwayatBulanIni->isNotEmpty())
                            <p class="text-sm text-gray-500 mt-1">
                                Terakhir diperiksa: {{ $riwayatBulanIni->first()->tanggal_rekam->format('d M Y') }}
                            </p>
                        @endif
                    </div>

                    <!-- Cetak Laporan Button -->
                    <div class="mt-4 md:mt-0 text-center">
                        <a href="{{ route('pasien.cetak-pdf', ['bulan' => request('bulan'), 'tahun' => request('tahun')]) }}"
                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200">
                            <i class="fas fa-file-pdf mr-2"></i>Cetak Pdf
                        </a>
                    </div>
                </div>

                @if ($riwayatBulanIni->isEmpty())
                    <div class="text-center py-8">
                        <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">Belum ada data pemeriksaan bulan ini</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($riwayatBulanIni as $data)
                            <!-- Tekanan Darah (Standar Lansia) -->
                            <div
                                class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div
                                    class="px-4 py-3 border-b flex justify-between items-center
                        @if (is_null($data->tekanan_darah_sistolik) || is_null($data->tekanan_darah_diastolik)) bg-gray-50
                        @elseif ($data->tekanan_darah_sistolik >= 160 || $data->tekanan_darah_diastolik >= 100)
                            bg-red-50
                        @elseif ($data->tekanan_darah_sistolik >= 150 || $data->tekanan_darah_diastolik >= 90)
                            bg-yellow-50
                        @else
                            bg-green-50 @endif">
                                    <h3 class="font-semibold text-gray-800">Tekanan Darah</h3>
                                    <span
                                        class="px-2 py-1 text-xs rounded-full
                            @if (is_null($data->tekanan_darah_sistolik) || is_null($data->tekanan_darah_diastolik)) bg-gray-100 text-gray-600
                            @elseif ($data->tekanan_darah_sistolik >= 160 || $data->tekanan_darah_diastolik >= 100)
                                bg-red-100 text-red-800
                            @elseif ($data->tekanan_darah_sistolik >= 150 || $data->tekanan_darah_diastolik >= 90)
                                bg-yellow-100 text-yellow-800
                            @else
                                bg-green-100 text-green-800 @endif">
                                        @if (is_null($data->tekanan_darah_sistolik) || is_null($data->tekanan_darah_diastolik))
                                            Tidak ada data
                                        @elseif ($data->tekanan_darah_sistolik >= 160 || $data->tekanan_darah_diastolik >= 100)
                                            Hipertensi
                                        @elseif ($data->tekanan_darah_sistolik >= 150 || $data->tekanan_darah_diastolik >= 90)
                                            Pra-Hipertensi
                                        @else
                                            Normal
                                        @endif
                                    </span>
                                </div>

                                <div class="p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-500">Nilai</span>
                                        @if (is_null($data->tekanan_darah_sistolik) || is_null($data->tekanan_darah_diastolik))
                                            <span class="font-bold text-gray-500">Tidak ada data</span>
                                        @else
                                            <span
                                                class="font-bold">{{ $data->tekanan_darah_sistolik }}/{{ $data->tekanan_darah_diastolik }}
                                                mmHg</span>
                                        @endif
                                    </div>

                                    <div class="mt-3">
                                        <p class="text-sm font-medium text-gray-700 mb-1">Rekomendasi:</p>
                                        <p class="text-sm text-gray-600">
                                            @if (is_null($data->tekanan_darah_sistolik) || is_null($data->tekanan_darah_diastolik))
                                                <i class="fas fa-info-circle text-gray-500 mr-1"></i> Data tidak tersedia
                                            @elseif ($data->tekanan_darah_sistolik >= 160 || $data->tekanan_darah_diastolik >= 100)
                                                <i class="fas fa-exclamation-circle text-red-500 mr-1"></i> Segera
                                                konsultasi dokter
                                            @elseif ($data->tekanan_darah_sistolik >= 150 || $data->tekanan_darah_diastolik >= 90)
                                                <i class="fas fa-exclamation-triangle text-yellow-500 mr-1"></i> Kurangi
                                                garam & periksa rutin
                                            @else
                                                <i class="fas fa-check-circle text-green-500 mr-1"></i> Pertahankan pola
                                                hidup sehat
                                            @endif
                                        </p>
                                    </div>

                                    <div class="mt-3 text-xs text-gray-400 flex items-center">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $data->tanggal_rekam->format('d M Y') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Gula Darah Puasa (Standar Lansia) -->
                            <div
                                class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div
                                    class="px-4 py-3 border-b flex justify-between items-center 
                        @if (is_null($data->gula_darah)) bg-gray-50
                        @elseif($data->gula_darah >= 180) bg-red-50
                        @elseif($data->gula_darah >= 130) bg-yellow-50
                        @elseif($data->gula_darah >= 70) bg-green-50
                        @else bg-blue-50 @endif">
                                    <h3 class="font-semibold text-gray-800">Gula Darah Puasa</h3>
                                    <span
                                        class="px-2 py-1 text-xs rounded-full
                            @if (is_null($data->gula_darah)) bg-gray-100 text-gray-600
                            @elseif($data->gula_darah >= 180) bg-red-100 text-red-800
                            @elseif($data->gula_darah >= 130) bg-yellow-100 text-yellow-800
                            @elseif($data->gula_darah >= 70) bg-green-100 text-green-800
                            @else bg-blue-100 text-blue-800 @endif">
                                        @if (is_null($data->gula_darah))
                                            Tidak ada data
                                        @elseif($data->gula_darah >= 180)
                                            Tinggi
                                        @elseif($data->gula_darah >= 130)
                                            Waspada
                                        @elseif($data->gula_darah >= 70)
                                            Normal
                                        @else
                                            Rendah
                                        @endif
                                    </span>
                                </div>

                                <div class="p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-500">Nilai</span>
                                        <span class="font-bold">
                                            {{ is_null($data->gula_darah) ? 'Tidak ada data' : $data->gula_darah . ' mg/dL' }}
                                        </span>
                                    </div>

                                    <div class="mt-3">
                                        <p class="text-sm font-medium text-gray-700 mb-1">Rekomendasi:</p>
                                        <p class="text-sm text-gray-600">
                                            @if (is_null($data->gula_darah))
                                                <i class="fas fa-info-circle text-gray-500 mr-1"></i> Data tidak tersedia
                                            @elseif($data->gula_darah >= 180)
                                                <i class="fas fa-exclamation-circle text-red-500 mr-1"></i> Segera
                                                konsultasi dokter
                                            @elseif($data->gula_darah >= 130)
                                                <i class="fas fa-exclamation-triangle text-yellow-500 mr-1"></i> Kurangi
                                                gula & perbanyak serat
                                            @elseif($data->gula_darah >= 70)
                                                <i class="fas fa-check-circle text-green-500 mr-1"></i> Pertahankan pola
                                                makan sehat
                                            @else
                                                <i class="fas fa-exclamation-triangle text-blue-500 mr-1"></i> Konsumsi
                                                makanan manis secara seimbang
                                            @endif
                                        </p>
                                    </div>

                                    <div class="mt-3 text-xs text-gray-400 flex items-center">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $data->tanggal_rekam->format('d M Y') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Kolesterol Total (Standar Lansia) -->
                            <div
                                class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div
                                    class="px-4 py-3 border-b flex justify-between items-center
                        @if (is_null($data->kolesterol)) bg-gray-50
                        @elseif ($data->kolesterol >= 240)
                            bg-red-50
                        @elseif ($data->kolesterol >= 200)
                            bg-yellow-50
                        @else
                            bg-green-50 @endif">
                                    <h3 class="font-semibold text-gray-800">Kolesterol Total</h3>
                                    <span
                                        class="px-2 py-1 text-xs rounded-full
                            @if (is_null($data->kolesterol)) bg-gray-100 text-gray-600
                            @elseif ($data->kolesterol >= 240)
                                bg-red-100 text-red-800
                            @elseif ($data->kolesterol >= 200)
                                bg-yellow-100 text-yellow-800
                            @else
                                bg-green-100 text-green-800 @endif">
                                        @if (is_null($data->kolesterol))
                                            Tidak ada data
                                        @elseif ($data->kolesterol >= 240)
                                            Tinggi
                                        @elseif ($data->kolesterol >= 200)
                                            Batas tinggi
                                        @else
                                            Normal
                                        @endif
                                    </span>
                                </div>

                                <div class="p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-500">Nilai</span>
                                        @if (is_null($data->kolesterol))
                                            <span class="font-bold text-gray-500">Tidak ada data</span>
                                        @else
                                            <span class="font-bold">{{ $data->kolesterol }} mg/dL</span>
                                        @endif
                                    </div>

                                    <div class="mt-3">
                                        <p class="text-sm font-medium text-gray-700 mb-1">Rekomendasi:</p>
                                        <p class="text-sm text-gray-600">
                                            @if (is_null($data->kolesterol))
                                                <i class="fas fa-info-circle text-gray-500 mr-1"></i> Data tidak tersedia
                                            @elseif ($data->kolesterol >= 240)
                                                <i class="fas fa-exclamation-circle text-red-500 mr-1"></i> Segera
                                                konsultasi dokter
                                            @elseif ($data->kolesterol >= 200)
                                                <i class="fas fa-exclamation-triangle text-yellow-500 mr-1"></i> Kurangi
                                                lemak & olahraga teratur
                                            @else
                                                <i class="fas fa-check-circle text-green-500 mr-1"></i> Pertahankan pola
                                                makan sehat
                                            @endif
                                        </p>
                                    </div>

                                    <div class="mt-3 text-xs text-gray-400 flex items-center">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $data->tanggal_rekam->format('d M Y') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Asam Urat (Standar Lansia) -->
                            <div
                                class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div
                                    class="px-4 py-3 border-b flex justify-between items-center
                        @if (is_null($data->asam_urat)) bg-gray-50
                        @elseif (($userGender == 'L' && $data->asam_urat > 7.0) || ($userGender == 'P' && $data->asam_urat > 6.0))
                            bg-red-50
                        @else
                            bg-green-50 @endif">
                                    <h3 class="font-semibold text-gray-800">Asam Urat</h3>
                                    <span
                                        class="px-2 py-1 text-xs rounded-full
                            @if (is_null($data->asam_urat)) bg-gray-100 text-gray-600
                            @elseif (($userGender == 'L' && $data->asam_urat > 7.0) || ($userGender == 'P' && $data->asam_urat > 6.0))
                                bg-red-100 text-red-800
                            @else
                                bg-green-100 text-green-800 @endif">
                                        @if (is_null($data->asam_urat))
                                            Tidak ada data
                                        @elseif (($userGender == 'L' && $data->asam_urat >+ 7.0) || ($userGender == 'P' && $data->asam_urat > 6.0))
                                            Tinggi
                                        @else
                                            Normal
                                        @endif
                                    </span>
                                </div>

                                <div class="p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-500">Nilai</span>
                                        @if (is_null($data->asam_urat))
                                            <span class="font-bold text-gray-500">Tidak ada data</span>
                                        @else
                                            <span class="font-bold">{{ $data->asam_urat }} mg/dL</span>
                                        @endif
                                    </div>

                                    <div class="mt-3">
                                        <p class="text-sm font-medium text-gray-700 mb-1">Rekomendasi:</p>
                                        <p class="text-sm text-gray-600">
                                            @if (is_null($data->asam_urat))
                                                <i class="fas fa-info-circle text-gray-500 mr-1"></i> Data tidak tersedia
                                            @elseif (($userGender == 'L' && $data->asam_urat > 7.0) || ($userGender == 'P' && $data->asam_urat > 6.0))
                                                <i class="fas fa-exclamation-circle text-red-500 mr-1"></i> Hindari makanan
                                                tinggi purin
                                            @else
                                                <i class="fas fa-check-circle text-green-500 mr-1"></i> Pertahankan pola
                                                makan sehat
                                            @endif
                                        </p>
                                    </div>

                                    <div class="mt-3 text-xs text-gray-400 flex items-center">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $data->tanggal_rekam->format('d M Y') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Lingkar Perut (Standar Lansia) -->
                            <div
                                class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div
                                    class="px-4 py-3 border-b flex justify-between items-center 
                        @if (is_null($data->lingkar_perut)) bg-gray-50
                        @elseif (($userGender == 'L' && $data->lingkar_perut >= 90) || ($userGender == 'P' && $data->lingkar_perut >= 80))
                            bg-red-50
                        @else
                            bg-green-50 @endif">
                                    <h3 class="font-semibold text-gray-800">Lingkar Perut</h3>
                                    <span
                                        class="px-2 py-1 text-xs rounded-full 
                            @if (is_null($data->lingkar_perut)) bg-gray-100 text-gray-600
                            @elseif (($userGender == 'L' && $data->lingkar_perut >= 90) || ($userGender == 'P' && $data->lingkar_perut >= 80))
                                bg-red-100 text-red-800
                            @else
                                bg-green-100 text-green-800 @endif">
                                        @if (is_null($data->lingkar_perut))
                                            Tidak ada data
                                        @elseif (($userGender == 'L' && $data->lingkar_perut >= 90) || ($userGender == 'P' && $data->lingkar_perut >= 80))
                                            Berisiko
                                        @else
                                            Normal
                                        @endif
                                    </span>
                                </div>

                                <div class="p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-500">Nilai</span>
                                        <span class="font-bold">
                                            {{ is_null($data->lingkar_perut) ? 'Tidak ada data' : number_format($data->lingkar_perut, 1) . ' cm' }}
                                        </span>
                                    </div>

                                    <div class="mt-3">
                                        <p class="text-sm font-medium text-gray-700 mb-1">Rekomendasi:</p>
                                        <p class="text-sm text-gray-600">
                                            @if (is_null($data->lingkar_perut))
                                                <i class="fas fa-info-circle text-gray-500 mr-1"></i> Data tidak tersedia
                                            @elseif (($userGender == 'L' && $data->lingkar_perut >= 90) || ($userGender == 'P' && $data->lingkar_perut >= 80))
                                                <i class="fas fa-exclamation-circle text-red-500 mr-1"></i> Kurangi kalori
                                                & perbanyak aktivitas
                                            @else
                                                <i class="fas fa-check-circle text-green-500 mr-1"></i> Pertahankan pola
                                                hidup sehat
                                            @endif
                                        </p>
                                    </div>

                                    <div class="mt-3 text-xs text-gray-400 flex items-center">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $data->tanggal_rekam->format('d M Y') }}
                                    </div>
                                </div>
                            </div>

                            <!-- IMT (Standar Lansia) -->
                            <div
                                class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-200">
                                <div
                                    class="px-4 py-3 border-b flex justify-between items-center 
                        @if (is_null($data->bmi)) bg-gray-50
                        @elseif($data->bmi >= 30) bg-red-50
                        @elseif($data->bmi >= 27) bg-yellow-50
                        @elseif($data->bmi < 22) bg-blue-50
                        @else bg-green-50 @endif">
                                    <h3 class="font-semibold text-gray-800">Indeks Massa Tubuh</h3>
                                    <span
                                        class="px-2 py-1 text-xs rounded-full 
                            @if (is_null($data->bmi)) bg-gray-100 text-gray-600
                            @elseif($data->bmi >= 30) bg-red-100 text-red-800
                            @elseif($data->bmi >= 27) bg-yellow-100 text-yellow-800
                            @elseif($data->bmi < 22) bg-blue-100 text-blue-800
                            @else bg-green-100 text-green-800 @endif">
                                        @if (is_null($data->bmi))
                                            Tidak ada data
                                        @elseif($data->bmi >= 30)
                                            Obesitas
                                        @elseif($data->bmi >= 27)
                                            Gemuk
                                        @elseif($data->bmi < 22)
                                            Kurus
                                        @else
                                            Normal
                                        @endif
                                    </span>
                                </div>

                                <div class="p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-500">Nilai</span>
                                        <span class="font-bold">
                                            {{ is_null($data->bmi) ? 'Tidak ada data' : number_format($data->bmi, 1) }}
                                        </span>
                                    </div>

                                    <div class="mt-3">
                                        <p class="text-sm font-medium text-gray-700 mb-1">Rekomendasi:</p>
                                        <p class="text-sm text-gray-600">
                                            @if (is_null($data->bmi))
                                                <i class="fas fa-info-circle text-gray-500 mr-1"></i> Data tidak tersedia
                                            @elseif($data->bmi >= 30)
                                                <i class="fas fa-exclamation-circle text-red-500 mr-1"></i> Segera
                                                konsultasi dokter
                                            @elseif($data->bmi >= 27)
                                                <i class="fas fa-exclamation-triangle text-yellow-500 mr-1"></i> Kurangi
                                                kalori & olahraga teratur
                                            @elseif($data->bmi < 22)
                                                <i class="fas fa-utensils text-blue-500 mr-1"></i> Tingkatkan asupan kalori
                                                & protein
                                            @else
                                                <i class="fas fa-check-circle text-green-500 mr-1"></i> Pertahankan berat
                                                badan ideal
                                            @endif
                                        </p>
                                    </div>

                                    <div class="mt-3 text-xs text-gray-400 flex items-center">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        {{ $data->tanggal_rekam->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Riwayat Kesehatan -->
            <div class="flex flex-col lg:flex-row gap-8 mt-8">
                <!-- Header Section -->
                <div
                    class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 rounded-lg text-center bg-white shadow-md">
                    <h1 class="text-xl md:text-2xl font-bold">Riwayat Kesehatan</h1>
                    <p class="text-sm text-gray-500 mt-2">
                        @if (request()->has('bulan') || request()->has('tahun'))
                            Data kesehatan yang difilter
                        @else
                            Data kesehatan terakhir Anda
                        @endif
                    </p>
                </div>

                <!-- Content Section -->
                <div class="w-full lg:w-1/2 bg-white p-4 shadow-md rounded-lg overflow-x-auto">
                    <!-- Filter Form -->
                    <form action="{{ route('pasiens.index') }}" method="GET"
                        class="flex flex-col md:flex-row gap-2 mb-4">
                        <!-- Month Dropdown -->
                        <select name="bulan" class="p-2 border rounded-lg w-full md:w-1/4">
                            <option value="">Pilih Bulan</option>
                            @foreach (range(1, 12) as $m)
                                <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Year Dropdown -->
                        <select name="tahun" class="p-2 border rounded-lg w-full md:w-1/4">
                            <option value="">Pilih Tahun</option>
                            @foreach (range(date('Y') - 5, date('Y')) as $y)
                                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Filter Button -->
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                            Filter
                        </button>

                        <!-- Reset Button -->
                        @if (request()->has('bulan') || request()->has('tahun'))
                            <a href="{{ route('pasiens.index') }}"
                                class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition flex items-center justify-center">
                                Reset
                            </a>
                        @endif
                    </form>

                    <!-- PDF Export Button -->
                    @if ($riwayat->isNotEmpty())
                        <a href="{{ route('pasien.cetak-pdf', ['bulan' => request('bulan'), 'tahun' => request('tahun')]) }}"
                            target="_blank" class="bg-green-500 text-white px-4 py-2 rounded-md inline-block mb-4">
                            Cetak PDF
                        </a>
                    @endif

                    <!-- Health Records Table -->
                    @if ($riwayat->isEmpty())
                        <div class="text-center py-8 bg-gray-50 rounded-lg">
                            <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">
                                @if (request()->has('bulan') || request()->has('tahun'))
                                    Tidak ada data kesehatan pada periode yang dipilih
                                @else
                                    Belum ada data kesehatan yang tercatat
                                @endif
                            </p>
                        </div>
                    @else
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-blue-200">
                                    <th class="border p-2 text-sm md:text-base whitespace-nowrap">Tanggal</th>
                                    <th class="border p-2 text-sm md:text-base whitespace-nowrap">Data</th>
                                    <th class="border p-2 text-sm md:text-base whitespace-nowrap">Angka</th>
                                    <th class="border p-2 text-sm md:text-base whitespace-nowrap">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $userGender = auth()->user()->pasien->jenis_kelamin ?? 'L';
                                    $firstRow = true;
                                @endphp

                                @foreach ($riwayat as $item)
                                    <tr>
                                        @if ($firstRow)
                                            <td class="border p-2 text-sm md:text-base whitespace-nowrap"
                                                rowspan="{{ $riwayat->count() > 1 ? 15 : 14 }}">
                                                {{ \Carbon\Carbon::parse($item->tanggal_rekam)->format('d M Y') }}
                                            </td>
                                            @php $firstRow = false; @endphp
                                        @endif

                                        <!-- Blood Pressure -->
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Tekanan Darah</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ $item->tekanan_darah_sistolik }}/{{ $item->tekanan_darah_diastolik }} mmHg
                                        </td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            @if ($item->tekanan_darah_sistolik >= 160 || $item->tekanan_darah_diastolik >= 100)
                                                <span class="text-red-600">Hipertensi</span>
                                            @elseif($item->tekanan_darah_sistolik >= 150 || $item->tekanan_darah_diastolik >= 90)
                                                <span class="text-yellow-600">Pra-Hipertensi</span>
                                            @else
                                                <span class="text-green-600">Normal</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Blood Sugar -->
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Gula Darah</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ $item->gula_darah }} mg/dL
                                        </td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            @if ($item->gula_darah >= 180)
                                                <span class="text-red-600">Tinggi</span>
                                            @elseif($item->gula_darah >= 130)
                                                <span class="text-yellow-600">Waspada</span>
                                            @else
                                                <span class="text-green-600">Normal</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Cholesterol -->
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Kolesterol</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ $item->kolesterol }} mg/dL
                                        </td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            @if ($item->kolesterol >= 240)
                                                <span class="text-red-600">Tinggi</span>
                                            @elseif($item->kolesterol >= 200)
                                                <span class="text-yellow-600">Batas Tinggi</span>
                                            @else
                                                <span class="text-green-600">Normal</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Weight -->
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Berat Badan</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ $item->berat_badan }} kg
                                        </td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            -
                                        </td>
                                    </tr>

                                    <!-- Height -->
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Tinggi Badan</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ $item->tinggi_badan }} cm
                                        </td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            -
                                        </td>
                                    </tr>

                                    <!-- Waist Circumference -->
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Lingkar Perut</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ $item->lingkar_perut }} cm
                                        </td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            @if (($userGender == 'L' && $item->lingkar_perut >= 90) || ($userGender == 'P' && $item->lingkar_perut >= 80))
                                                <span class="text-red-600">Berisiko</span>
                                            @else
                                                <span class="text-green-600">Normal</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- BMI -->
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">BMI</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ number_format($item->bmi, 1) }}
                                        </td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            @if ($item->bmi >= 30)
                                                <span class="text-red-600">Obesitas</span>
                                            @elseif($item->bmi >= 27)
                                                <span class="text-yellow-600">Gemuk</span>
                                            @elseif($item->bmi < 22)
                                                <span class="text-blue-600">Kurus</span>
                                            @else
                                                <span class="text-green-600">Normal</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Uric Acid -->
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Asam Urat</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ $item->asam_urat }} mg/dL
                                        </td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            @if (($userGender == 'L' && $item->asam_urat > 7.0) || ($userGender == 'P' && $item->asam_urat > 6.0))
                                                <span class="text-red-600">Tinggi</span>
                                            @else
                                                <span class="text-green-600">Normal</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Smoking Status -->
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Merokok</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ $item->merokok ? 'Ya' : 'Tidak' }}
                                        </td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            @if ($item->merokok)
                                                <span class="text-red-600">Berisiko</span>
                                            @else
                                                <span class="text-green-600">Aman</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Physical Activity -->
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Kurang Aktivitas
                                            Fisik</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ $item->kurang_aktivitas_fisik ? 'Ya' : 'Tidak' }}
                                        </td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            @if ($item->kurang_aktivitas_fisik)
                                                <span class="text-red-600">Berisiko</span>
                                            @else
                                                <span class="text-green-600">Aman</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Fruit/Vegetable Intake -->
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Kurang Sayur dan Buah
                                        </td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ $item->kurang_sayur_buah ? 'Ya' : 'Tidak' }}
                                        </td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            @if ($item->kurang_sayur_buah)
                                                <span class="text-red-600">Berisiko</span>
                                            @else
                                                <span class="text-green-600">Aman</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Alcohol Consumption -->
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Konsumsi Alkohol</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ $item->konsumsi_alkohol ? 'Ya' : 'Tidak' }}
                                        </td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            @if ($item->konsumsi_alkohol)
                                                <span class="text-red-600">Berisiko</span>
                                            @else
                                                <span class="text-green-600">Aman</span>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Medications -->
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Obat</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap" colspan="2">
                                            {{ $item->obat ?? '-' }}
                                        </td>
                                    </tr>

                                    <!-- Staff Notes -->
                                    @if ($riwayat->count() == 1)
                                        <!-- Only show notes for single record display -->
                                        <tr>
                                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">Catatan Petugas
                                            </td>
                                            <td class="border p-2 text-sm md:text-base whitespace-nowrap" colspan="2">
                                                {{ $item->catatan_petugas ?? '-' }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>

                        {{--  <!-- Pagination -->
            @if ($riwayat->hasPages())
                <div class="mt-4">
                    {{ $riwayat->links() }}
                </div>
            @endif  --}}
                    @endif
                </div>
            </div>

            <!-- Jadwal Pelayanan -->
            <div class="flex flex-col lg:flex-row gap-8 mt-8">
                <div
                    class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 rounded-lg text-center bg-white shadow-md">
                    <h2 class="text-xl md:text-2xl font-bold">Jadwal Pelayanan Selanjutnya</h2>
                </div>
                <div class="w-full lg:w-1/2 bg-white p-4 shadow-md rounded-lg overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-400">
                        <thead>
                            <tr class="bg-blue-300">
                                <th class="border p-2 text-sm md:text-base whitespace-nowrap">Kegiatan</th>
                                <th class="border p-2 text-sm md:text-base whitespace-nowrap">Tanggal</th>
                                <th class="border p-2 text-sm md:text-base whitespace-nowrap">Jam</th>
                                <th class="border p-2 text-sm md:text-base whitespace-nowrap">Tempat</th>
                                <th class="border p-2 text-sm md:text-base whitespace-nowrap">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwal as $item)
                                @php
                                    // Tentukan status berdasarkan tanggal
                                    $status = $item->tanggal < now() ? 'selesai' : 'belum_selesai';
                                @endphp
                                <tr>
                                    <td class="border border-gray-400 p-2">{{ $item->nama_kegiatan ?? '-' }}</td>
                                    <td class="border border-gray-400 p-2">
                                        {{ $item->tanggal ? $item->tanggal->format('d M Y') : '-' }}</td>
                                    <td class="border border-gray-400 p-2">{{ $item->waktu ?? '-' }}</td>
                                    <td class="border border-gray-400 p-2">{{ $item->lokasi ?? '-' }}</td>
                                    <td class="border border-gray-400 p-2">
                                        @if ($status == 'selesai')
                                            <span
                                                class="bg-green-500 text-white px-2 py-1 rounded-full text-sm">Selesai</span>
                                        @else
                                            <span
                                                class="bg-yellow-500 text-white px-2 py-1 rounded-full text-sm whitespace-nowrap">Mendatang</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Dokumentasi Section -->
            <div class="bg-white p-6 shadow-lg rounded-xl mt-8">
                <div class="text-center mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold text-sky-800 mb-2">Galeri Kegiatan</h2>
                    <div class="w-20 h-1 bg-blue-500 mx-auto"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($dokumentasi as $doc)
                        <div
                            class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <!-- Thumbnail -->
                            <div class="relative">
                                @if ($doc->fotos->count() > 0)
                                    <img src="{{ asset('storage/' . $doc->fotos->first()->path) }}"
                                        alt="{{ $doc->nama_kegiatan }}" class="w-full h-48 object-cover cursor-pointer"
                                        onclick="openModal('modal-{{ $doc->id }}')">
                                @else
                                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif

                                <!-- Tanggal Kegiatan -->
                                <div
                                    class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                    <span class="text-white text-sm font-medium">
                                        {{ $doc->created_at->format('d M Y') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Konten -->
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $doc->nama_kegiatan }}</h3>
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $doc->deskripsi }}</p>

                                <!-- Tombol Lihat Detail -->
                                <button onclick="openModal('modal-{{ $doc->id }}')"
                                    class="mt-3 text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                                    Lihat Detail
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Modal untuk setiap dokumen -->
                        <div id="modal-{{ $doc->id }}"
                            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 hidden">
                            <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                                <!-- Header Modal -->
                                <div class="sticky top-0 bg-white p-4 border-b flex justify-between items-center">
                                    <h3 class="text-xl font-bold text-gray-800">{{ $doc->nama_kegiatan }}</h3>
                                    <button onclick="closeModal('modal-{{ $doc->id }}')"
                                        class="text-gray-500 hover:text-gray-700">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Body Modal -->
                                <div class="p-6">
                                    @if ($doc->fotos->count() > 0)
                                        <div class="mb-6">
                                            <img src="{{ asset('storage/' . $doc->fotos->first()->path) }}"
                                                alt="{{ $doc->nama_kegiatan }}"
                                                class="w-full h-auto max-h-[60vh] object-contain rounded-lg mx-auto">
                                        </div>
                                    @endif

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <p class="text-sm text-gray-500">Tanggal Kegiatan</p>
                                            <p class="font-medium">{{ $doc->created_at->format('d F Y') }}</p>
                                        </div>
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <p class="text-sm text-gray-500">Lokasi</p>
                                            <p class="font-medium">{{ $doc->lokasi ?? 'Tidak dicantumkan' }}</p>
                                        </div>
                                    </div>

                                    <div class="prose max-w-none">
                                        <h4 class="text-lg font-semibold mb-2">Deskripsi Kegiatan</h4>
                                        <p class="text-gray-700 whitespace-pre-line">{{ $doc->deskripsi }}</p>

                                        @if ($doc->fotos->count() > 1)
                                            <div class="mt-6">
                                                <h4 class="text-lg font-semibold mb-3">Galeri Foto</h4>
                                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                                    @foreach ($doc->fotos as $foto)
                                                        <div class="aspect-square overflow-hidden rounded-lg">
                                                            <img src="{{ asset('storage/' . $foto->path) }}"
                                                                alt="Foto dokumentasi {{ $doc->nama_kegiatan }}"
                                                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 cursor-pointer"
                                                                onclick="window.open('{{ asset('storage/' . $foto->path) }}', '_blank')">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Footer Modal -->
                                <div class="sticky bottom-0 bg-white p-4 border-t flex justify-end">
                                    <button onclick="closeModal('modal-{{ $doc->id }}')"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($dokumentasi->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">Belum ada dokumentasi</h3>
                        <p class="mt-1 text-gray-500">Tidak ada kegiatan yang terdokumentasi saat ini.</p>
                    </div>
                @endif
            </div>

            <script>
                // Fungsi untuk membuka modal
                function openModal(modalId) {
                    document.getElementById(modalId).classList.remove('hidden');
                    document.body.style.overflow = 'hidden'; // Mencegah scroll di background
                }

                // Fungsi untuk menutup modal
                function closeModal(modalId) {
                    document.getElementById(modalId).classList.add('hidden');
                    document.body.style.overflow = 'auto'; // Mengembalikan scroll
                }

                // Tutup modal ketika klik di luar konten modal
                window.onclick = function(event) {
                    if (event.target.classList.contains('bg-black/80')) {
                        event.target.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }
                }
            </script>

        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.0.2"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data dari controller
            const labels = @json($labels);
            const tekananDarahSistolik = @json($tekananDarahSistolik);
            const tekananDarahDiastolik = @json($tekananDarahDiastolik);
            const gulaDarah = @json($gulaDarah);
            const kolesterol = @json($kolesterol);
            const asamUrat = @json($asamUrat);
            const imt = @json($imt);
            const lingkarPerut = @json($lingkarPerut);
            const userGender = @json(auth()->user()->pasien->jenis_kelamin ?? 'L'); // Default to male if not set

            // Set global chart defaults
            Chart.defaults.font.family = "'Inter', sans-serif";
            Chart.defaults.color = '#6b7280';
            Chart.defaults.borderColor = '#e5e7eb';

            // Fungsi untuk menentukan warna berdasarkan nilai (khusus lansia)
            function getTekananDarahColor(sistolik, diastolik) {
                if (sistolik >= 160 || diastolik >= 100) return 'rgb(239, 68, 68)'; // merah
                if (sistolik >= 150 || diastolik >= 90) return 'rgb(234, 179, 8)'; // kuning
                return 'rgb(34, 197, 94)'; // hijau
            }

            function getGulaDarahColor(value) {
                if (value >= 180) return 'rgb(239, 68, 68)';
                if (value >= 130) return 'rgb(234, 179, 8)';
                return 'rgb(34, 197, 94)';
            }

            function getKolesterolColor(value) {
                if (value >= 240) return 'rgb(239, 68, 68)';
                if (value >= 200) return 'rgb(234, 179, 8)';
                return 'rgb(34, 197, 94)';
            }

            function getAsamUratColor(value) {
                const threshold = userGender === 'L' ? 7.0 : 6.0;
                return value > threshold ? 'rgb(239, 68, 68)' : 'rgb(34, 197, 94)';
            }

            function getIMTColor(value) {
                if (value >= 30) return 'rgb(239, 68, 68)';
                if (value >= 27) return 'rgb(234, 179, 8)';
                if (value < 22) return 'rgb(59, 130, 246)'; // biru untuk kurus
                return 'rgb(34, 197, 94)';
            }

            function getLingkarPerutColor(value) {
                const threshold = userGender === 'L' ? 90 : 80;
                return value >= threshold ? 'rgb(239, 68, 68)' : 'rgb(34, 197, 94)';
            }

            // Fungsi untuk menentukan arrow direction (improvement/decline)
            function getArrowDirection(currentValue, previousValue, lowerIsBetter = false) {
                if (previousValue === null || currentValue === null) return null;
                if (currentValue > previousValue) {
                    return lowerIsBetter ? 'down' : 'up';
                } else if (currentValue < previousValue) {
                    return lowerIsBetter ? 'up' : 'down';
                }
                return null;
            }

            // Fungsi untuk membuat point style dengan arrow
            function getPointStyle(value, index, dataArray, lowerIsBetter = false) {
                if (index === 0) return 'circle';
                const direction = getArrowDirection(value, dataArray[index - 1], lowerIsBetter);
                if (direction === 'up') return 'triangle';
                if (direction === 'down') return 'triangle';
                return 'circle';
            }

            // Fungsi untuk membuat point rotation dengan arrow
            function getPointRotation(value, index, dataArray, lowerIsBetter = false) {
                if (index === 0) return 0;
                const direction = getArrowDirection(value, dataArray[index - 1], lowerIsBetter);
                if (direction === 'up') return 0;
                if (direction === 'down') return 180;
                return 0;
            }

            // Fungsi untuk membuat point color berdasarkan arrow direction
            function getPointColor(value, index, dataArray, lowerIsBetter = false) {
                if (index === 0) return 'rgb(34, 197, 94)';
                const direction = getArrowDirection(value, dataArray[index - 1], lowerIsBetter);
                if (direction === 'up') return lowerIsBetter ? 'rgb(239, 68, 68)' : 'rgb(34, 197, 94)';
                if (direction === 'down') return lowerIsBetter ? 'rgb(34, 197, 94)' : 'rgb(239, 68, 68)';
                return 'rgb(34, 197, 94)';
            }

            // Fungsi untuk membuat annotation
            function getThresholdAnnotations(thresholds, unit) {
                return thresholds.map(threshold => ({
                    type: 'line',
                    yMin: threshold.value,
                    yMax: threshold.value,
                    borderColor: threshold.color,
                    borderWidth: 2,
                    borderDash: [6, 6],
                    label: {
                        content: threshold.label + ` (${threshold.value}${unit})`,
                        enabled: true,
                        position: 'right',
                        backgroundColor: threshold.color,
                        color: 'white',
                        font: {
                            weight: 'bold',
                            size: 10
                        },
                        padding: {
                            top: 4,
                            bottom: 4,
                            left: 8,
                            right: 8
                        },
                        borderRadius: 4
                    }
                }));
            }

            // Fungsi untuk opsi chart yang reusable
            function getChartOptions(unit, thresholds = []) {
                return {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    size: 12,
                                    weight: '600'
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            titleColor: '#f9fafb',
                            bodyColor: '#f9fafb',
                            bodySpacing: 8,
                            padding: 12,
                            usePointStyle: true,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += context.parsed.y + ' ' + unit;
                                    }

                                    // Add trend information
                                    if (context.dataIndex > 0) {
                                        const current = context.parsed.y;
                                        const previous = context.dataset.data[context.dataIndex - 1];
                                        const diff = current - previous;
                                        const diffAbs = Math.abs(diff);

                                        if (diff !== 0) {
                                            const direction = diff > 0 ? '↑' : '↓';
                                            const isImprovement = (context.dataset.label === 'IMT') ?
                                                (diff > 0) : (diff < 0);

                                            label += ` (${direction} ${diffAbs.toFixed(1)}${unit})`;

                                            if (isImprovement) {
                                                label += ' ✅';
                                            } else {
                                                label += ' ⚠️';
                                            }
                                        }
                                    }

                                    return label;
                                }
                            }
                        },
                        annotation: {
                            annotations: getThresholdAnnotations(thresholds, unit)
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    weight: '600'
                                }
                            }
                        },
                        y: {
                            beginAtZero: false,
                            title: {
                                display: true,
                                text: unit,
                                font: {
                                    weight: '600',
                                    size: 12
                                },
                                padding: {
                                    top: 0,
                                    bottom: 10
                                }
                            },
                            grid: {
                                color: '#e5e7eb',
                                drawBorder: false
                            }
                        }
                    },
                    elements: {
                        line: {
                            borderWidth: 3
                        },
                        point: {
                            hoverRadius: 8,
                            hoverBorderWidth: 2
                        }
                    },
                    layout: {
                        padding: {
                            top: 20,
                            right: 20,
                            bottom: 10,
                            left: 10
                        }
                    }
                };
            }

            // Grafik Tekanan Darah (khusus lansia)
            new Chart(document.getElementById('chartTekananDarah'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Sistolik',
                            data: tekananDarahSistolik,
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: tekananDarahSistolik.map((v, i) =>
                                getTekananDarahColor(v, tekananDarahDiastolik[i])
                            ),
                            tension: 0.2,
                            fill: false,
                            pointStyle: tekananDarahSistolik.map((v, i) =>
                                getPointStyle(v, i, tekananDarahSistolik, true)
                            ),
                            pointRotation: tekananDarahSistolik.map((v, i) =>
                                getPointRotation(v, i, tekananDarahSistolik, true)
                            ),
                            pointBackgroundColor: tekananDarahSistolik.map((v, i) =>
                                getPointColor(v, i, tekananDarahSistolik, true)
                            ),
                            pointRadius: 6,
                            pointHoverRadius: 8
                        },
                        {
                            label: 'Diastolik',
                            data: tekananDarahDiastolik,
                            borderColor: 'rgb(168, 85, 247)',
                            backgroundColor: tekananDarahDiastolik.map((v, i) =>
                                getTekananDarahColor(tekananDarahSistolik[i], v)
                            ),
                            tension: 0.2,
                            fill: false,
                            pointStyle: tekananDarahDiastolik.map((v, i) =>
                                getPointStyle(v, i, tekananDarahDiastolik, true)
                            ),
                            pointRotation: tekananDarahDiastolik.map((v, i) =>
                                getPointRotation(v, i, tekananDarahDiastolik, true)
                            ),
                            pointBackgroundColor: tekananDarahDiastolik.map((v, i) =>
                                getPointColor(v, i, tekananDarahDiastolik, true)
                            ),
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }
                    ]
                },
                options: getChartOptions('mmHg', [{
                        value: 160,
                        color: 'rgb(239, 68, 68)',
                        label: 'Hipertensi (Lansia)'
                    },
                    {
                        value: 150,
                        color: 'rgb(234, 179, 8)',
                        label: 'Pra-Hipertensi (Lansia)'
                    },
                    {
                        value: 100,
                        color: 'rgb(239, 68, 68)',
                        label: 'Hipertensi (Lansia)'
                    },
                    {
                        value: 90,
                        color: 'rgb(234, 179, 8)',
                        label: 'Pra-Hipertensi (Lansia)'
                    }
                ])
            });

            // Grafik Gula Darah (khusus lansia)
            new Chart(document.getElementById('chartGulaDarah'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Gula Darah',
                        data: gulaDarah,
                        borderColor: gulaDarah.map(v => getGulaDarahColor(v)),
                        backgroundColor: gulaDarah.map(v => getGulaDarahColor(v)),
                        tension: 0.2,
                        fill: false,
                        pointStyle: gulaDarah.map((v, i) =>
                            getPointStyle(v, i, gulaDarah, true)
                        ),
                        pointRotation: gulaDarah.map((v, i) =>
                            getPointRotation(v, i, gulaDarah, true)
                        ),
                        pointBackgroundColor: gulaDarah.map((v, i) =>
                            getPointColor(v, i, gulaDarah, true)
                        ),
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: getChartOptions('mg/dL', [{
                        value: 180,
                        color: 'rgb(239, 68, 68)',
                        label: 'Bahaya'
                    },
                    {
                        value: 130,
                        color: 'rgb(234, 179, 8)',
                        label: 'Waspada'
                    }
                ])
            });

            // Grafik Kolesterol
            new Chart(document.getElementById('chartKolesterol'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Kolesterol',
                        data: kolesterol,
                        borderColor: kolesterol.map(v => getKolesterolColor(v)),
                        backgroundColor: kolesterol.map(v => getKolesterolColor(v)),
                        tension: 0.2,
                        fill: false,
                        pointStyle: kolesterol.map((v, i) =>
                            getPointStyle(v, i, kolesterol, true)
                        ),
                        pointRotation: kolesterol.map((v, i) =>
                            getPointRotation(v, i, kolesterol, true)
                        ),
                        pointBackgroundColor: kolesterol.map((v, i) =>
                            getPointColor(v, i, kolesterol, true)
                        ),
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: getChartOptions('mg/dL', [{
                        value: 240,
                        color: 'rgb(239, 68, 68)',
                        label: 'Tinggi'
                    },
                    {
                        value: 200,
                        color: 'rgb(234, 179, 8)',
                        label: 'Batas Tinggi'
                    }
                ])
            });

            // Grafik Asam Urat
            new Chart(document.getElementById('chartAsamUrat'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Asam Urat',
                        data: asamUrat,
                        borderColor: asamUrat.map(v => getAsamUratColor(v)),
                        backgroundColor: asamUrat.map(v => getAsamUratColor(v)),
                        tension: 0.2,
                        fill: false,
                        pointStyle: asamUrat.map((v, i) =>
                            getPointStyle(v, i, asamUrat, true)
                        ),
                        pointRotation: asamUrat.map((v, i) =>
                            getPointRotation(v, i, asamUrat, true)
                        ),
                        pointBackgroundColor: asamUrat.map((v, i) =>
                            getPointColor(v, i, asamUrat, true)
                        ),
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: getChartOptions('mg/dL', [{
                    value: userGender === 'L' ? 7.0 : 6.0,
                    color: 'rgb(239, 68, 68)',
                    label: 'Batas Normal'
                }])
            });

            // Grafik IMT (khusus lansia)
            new Chart(document.getElementById('chartIMT'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Indeks Massa Tubuh',
                        data: imt,
                        borderColor: imt.map(v => getIMTColor(v)),
                        backgroundColor: imt.map(v => getIMTColor(v)),
                        tension: 0.2,
                        fill: false,
                        pointStyle: imt.map((v, i) =>
                            getPointStyle(v, i, imt, false)
                        ),
                        pointRotation: imt.map((v, i) =>
                            getPointRotation(v, i, imt, false)
                        ),
                        pointBackgroundColor: imt.map((v, i) =>
                            getPointColor(v, i, imt, false)
                        ),
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: getChartOptions('kg/m²', [{
                        value: 30,
                        color: 'rgb(239, 68, 68)',
                        label: 'Obesitas'
                    },
                    {
                        value: 27,
                        color: 'rgb(234, 179, 8)',
                        label: 'Gemuk (Lansia)'
                    },
                    {
                        value: 22,
                        color: 'rgb(59, 130, 246)',
                        label: 'Normal (Lansia)'
                    }
                ])
            });

            // Grafik Lingkar Perut
            new Chart(document.getElementById('chartLingkarPerut'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Lingkar Perut',
                        data: lingkarPerut,
                        borderColor: lingkarPerut.map(v => getLingkarPerutColor(v)),
                        backgroundColor: lingkarPerut.map(v => getLingkarPerutColor(v)),
                        tension: 0.2,
                        fill: false,
                        pointStyle: lingkarPerut.map((v, i) =>
                            getPointStyle(v, i, lingkarPerut, true)
                        ),
                        pointRotation: lingkarPerut.map((v, i) =>
                            getPointRotation(v, i, lingkarPerut, true)
                        ),
                        pointBackgroundColor: lingkarPerut.map((v, i) =>
                            getPointColor(v, i, lingkarPerut, true)
                        ),
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: getChartOptions('cm', [{
                    value: userGender === 'L' ? 90 : 80,
                    color: 'rgb(239, 68, 68)',
                    label: 'Batas Normal'
                }])
            });
        });
    </script>
@endsection
