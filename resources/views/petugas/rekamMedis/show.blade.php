@extends('layouts.petugas')

@section('content')
    <div class="container mx-auto p-6 bg-gray-100 rounded-lg">
        {{-- Judul --}}
        <h2 class="text-2xl font-bold text-center mb-6 text-blue-600 break-words">
            Detail Rekam Medis Pasien: {{ $pasien ? $pasien->nama : 'Pasien tidak ditemukan' }}
        </h2>

        {{-- Cek apakah data pasien tersedia --}}
        @if ($pasien)
            {{-- Data Diri Pasien --}}
            <div class="bg-white p-6 rounded-lg shadow-md mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <h3 class="text-xl font-semibold mb-4 col-span-full">Data Diri Pasien</h3>
                <div>
                    <p class="text-gray-600">Nama:</p>
                    <p class="font-semibold">{{ $pasien->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">NIK:</p>
                    <p class="font-semibold">{{ $pasien->nik ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Tanggal Lahir:</p>
                    <p class="font-semibold">
                        {{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d M Y') : '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-600">Jenis Kelamin:</p>
                    <p class="font-semibold">{{ $pasien->jenis_kelamin ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Alamat:</p>
                    <p class="font-semibold">{{ $pasien->alamat ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">No. Telepon:</p>
                    <p class="font-semibold">{{ $pasien->no_telepon ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Umur:</p>
                    <p class="font-semibold">{{ $pasien->umur ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Pendidikan Terakhir:</p>
                    <p class="font-semibold">{{ $pasien->pendidikan_terakhir ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Pekerjaan:</p>
                    <p class="font-semibold">{{ $pasien->pekerjaan ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Status Kawin:</p>
                    <p class="font-semibold">{{ $pasien->status_kawin ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Golongan Darah:</p>
                    <p class="font-semibold">{{ $pasien->golongan_darah ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Email:</p>
                    <p class="font-semibold">{{ $pasien->email ?? '-' }}</p>
                </div>
            </div>

            {{-- Layout Dua Kolom --}}
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Kolom Kiri: Tabel Riwayat Kesehatan -->
                <div class="w-full lg:w-1/2 bg-white p-6 shadow-md rounded-lg overflow-x-auto">
                    <h3 class="text-xl font-semibold mb-4">Riwayat Kesehatan</h3>

                    <!-- Form Filter dan Tombol Cetak PDF -->
                    <div class="flex flex-col md:flex-row gap-4 mb-6">
                        <form action="{{ route('petugas.rekamMedis.show', $pasien->id) }}" method="GET"
                            class="flex flex-col md:flex-row gap-2 flex-grow">
                            <!-- Dropdown Bulan -->
                            <select name="bulan" id="filterBulan" class="p-2 border rounded-lg w-full md:w-1/3">
                                <option value="">Pilih Bulan</option>
                                @foreach (range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Dropdown Tahun -->
                            <select name="tahun" id="filterTahun" class="p-2 border rounded-lg w-full md:w-1/3">
                                <option value="">Pilih Tahun</option>
                                @foreach (range(date('Y') - 2, date('Y')) as $y)
                                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Tombol Filter -->
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                                Filter
                            </button>
                        </form>

                        <!-- Tombol Cetak PDF -->
                        @if (!$records->isEmpty())
                            <a href="#" id="cetakPDF"
                                class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition flex items-center justify-center">
                                Cetak PDF
                            </a>
                        @endif
                    </div>

                    @if ($records->isEmpty())
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 rounded">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 pt-0.5">
                                    <svg class="h-5 w-5 text-yellow-500" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Data belum tersedia</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>Belum ada data rekam medis untuk pasien ini.</p>
                                        @if (auth()->user()->role == 'petugas')
                                            <p class="mt-1">Anda dapat meminta kader untuk menambahkan data rekam
                                                medis</a> terlebih dahulu.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Tabel Riwayat Kesehatan -->
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr class="bg-blue-200">
                                    <th class="border p-2 text-sm md:text-base whitespace-nowrap">Tanggal</th>
                                    <th class="border p-2 text-sm md:text-base whitespace-nowrap">Data</th>
                                    <th class="border p-2 text-sm md:text-base whitespace-nowrap">Angka</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap" rowspan="14">
                                            {{ \Carbon\Carbon::parse($record->tanggal_rekam)->format('d M Y') }}
                                        </td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Tekanan Darah</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ !empty($record->tekanan_darah_sistolik) && !empty($record->tekanan_darah_diastolik) ? $record->tekanan_darah_sistolik . '/' . $record->tekanan_darah_diastolik . ' mmHg' : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Gula Darah</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ !empty($record->gula_darah) ? $record->gula_darah . ' mg/dL' : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Kolesterol</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ !empty($record->kolesterol) ? $record->kolesterol . ' mg/dL' : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Berat Badan</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ !empty($record->berat_badan) ? $record->berat_badan . ' kg' : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Tinggi Badan</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ !empty($record->tinggi_badan) ? $record->tinggi_badan . ' cm' : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Lingkar Perut</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ !empty($record->lingkar_perut) ? $record->lingkar_perut . ' cm' : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">IMT</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ !empty($record->bmi) ? $record->bmi : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Asam Urat</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ !empty($record->asam_urat) ? $record->asam_urat . ' mg/dL' : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Merokok</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ isset($record->merokok) ? ($record->merokok ? 'Ya' : 'Tidak') : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Kurang Aktivitas Fisik
                                        </td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ isset($record->kurang_aktivitas_fisik) ? ($record->kurang_aktivitas_fisik ? 'Ya' : 'Tidak') : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Kurang Sayur dan Buah
                                        </td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ isset($record->kurang_sayur_buah) ? ($record->kurang_sayur_buah ? 'Ya' : 'Tidak') : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Konsumsi Alkohol</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ isset($record->konsumsi_alkohol) ? ($record->konsumsi_alkohol ? 'Ya' : 'Tidak') : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Obat</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ !empty($record->obat) ? $record->obat : '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">Catatan Petugas</td>
                                        <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                            {{ !empty($record->catatan_petugas) ? $record->catatan_petugas : '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <!-- Kolom Kanan: Grafik -->
                <div class="w-full lg:w-1/2">
                    @if (!empty($labels) && count($labels) > 0)
                        <!-- Grid untuk grafik -->
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Baris pertama: 2 grafik -->

                            <!-- Grafik Tekanan Darah -->
                            <div class="bg-white p-4 shadow-md rounded-lg">
                                <h3 class="text-lg font-semibold mb-3">Tekanan Darah</h3>
                                <div class="chart-container" style="position: relative; height:250px;">
                                    <canvas id="chartTekananDarah"></canvas>
                                </div>
                            </div>

                            <!-- Grafik Gula Darah -->
                            <div class="bg-white p-4 shadow-md rounded-lg">
                                <h3 class="text-lg font-semibold mb-3">Gula Darah</h3>
                                <div class="chart-container" style="position: relative; height:250px;">
                                    <canvas id="chartGulaDarah"></canvas>
                                </div>
                            </div>

                            <!-- Grafik Kolesterol -->
                            <div class="bg-white p-4 shadow-md rounded-lg">
                                <h3 class="text-lg font-semibold mb-3">Kolesterol</h3>
                                <div class="chart-container" style="position: relative; height:250px;">
                                    <canvas id="chartKolesterol"></canvas>
                                </div>
                            </div>

                            <!-- Grafik Asam Urat -->
                            <div class="bg-white p-4 shadow-md rounded-lg">
                                <h3 class="text-lg font-semibold mb-3">Asam Urat</h3>
                                <div class="chart-container" style="position: relative; height:250px;">
                                    <canvas id="chartAsamUrat"></canvas>
                                </div>
                            </div>

                            <!-- Grafik IMT -->
                            <div class="bg-white p-4 shadow-md rounded-lg">
                                <h3 class="text-lg font-semibold mb-3">Indeks Massa Tubuh</h3>
                                <div class="chart-container" style="position: relative; height:250px;">
                                    <canvas id="chartIMT"></canvas>
                                </div>
                            </div>

                            <!-- Grafik Lingkar Perut -->
                            <div class="bg-white p-4 shadow-md rounded-lg">
                                <h3 class="text-lg font-semibold mb-3">Lingkar Perut</h3>
                                <div class="chart-container" style="position: relative; height:250px;">
                                    <canvas id="chartLingkarPerut"></canvas>
                                </div>
                            </div>

                        </div>
                    @else
                        <div class="bg-white p-6 shadow-md rounded-lg">
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 pt-0.5">
                                        <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">Data grafik belum tersedia</h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <p>Data grafik akan muncul setelah ada rekam medis yang tersedia.</p>
                                            @if (auth()->user()->role == 'petugas')
                                                <p class="mt-1">Anda dapat meminta kader untuk menambahkan data rekam
                                                    medis</a> terlebih dahulu.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Tombol Kembali --}}
            <div class="mt-6">
                <a href="{{ route('petugas.daftarPasien') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                    Kembali
                </a>
            </div>
        @else
            {{-- Tampilkan pesan jika pasien tidak ditemukan --}}
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <p class="text-red-500 font-semibold">Data pasien tidak ditemukan.</p>
                <a href="{{ route('rekam-medis-lansia.index') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition mt-4 inline-block">
                    Kembali ke Daftar Pasien
                </a>
            </div>
        @endif
    </div>

    {{-- JavaScript untuk Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data dari controller
            const labels = @json($labels ?? []);

            // Hanya buat grafik jika ada data
            if (labels && labels.length > 0) {
                const tekananDarahSistolik = @json($tekananDarahSistolik ?? []);
                const tekananDarahDiastolik = @json($tekananDarahDiastolik ?? []);
                const gulaDarah = @json($gulaDarah ?? []);
                const kolesterol = @json($kolesterol ?? []);
                const asamUrat = @json($asamUrat ?? []);
                const imt = @json($imt ?? []);
                const lingkarPerut = @json($lingkarPerut ?? []);

                // Grafik Tekanan Darah
                if (document.getElementById('chartTekananDarah')) {
                    new Chart(document.getElementById('chartTekananDarah'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: 'Tekanan Darah Sistolik',
                                    data: tekananDarahSistolik,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderWidth: 2,
                                    tension: 0.1,
                                    fill: false,
                                },
                                {
                                    label: 'Tekanan Darah Diastolik',
                                    data: tekananDarahDiastolik,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderWidth: 2,
                                    tension: 0.1,
                                    fill: false,
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: false,
                                    title: {
                                        display: true,
                                        text: 'mmHg'
                                    },
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.05)',
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    mode: 'index',
                                    intersect: false,
                                },
                                legend: {
                                    position: 'top',
                                }
                            }
                        }
                    });
                }

                // Grafik Gula Darah
                if (document.getElementById('chartGulaDarah')) {
                    new Chart(document.getElementById('chartGulaDarah'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Gula Darah',
                                data: gulaDarah,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderWidth: 2,
                                tension: 0.1,
                                fill: false,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: false,
                                    title: {
                                        display: true,
                                        text: 'mg/dL'
                                    },
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.05)',
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    mode: 'index',
                                    intersect: false,
                                },
                                legend: {
                                    position: 'top',
                                }
                            }
                        }
                    });
                }

                // Grafik Kolesterol
                if (document.getElementById('chartKolesterol')) {
                    new Chart(document.getElementById('chartKolesterol'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Kolesterol',
                                data: kolesterol,
                                borderColor: 'rgba(153, 102, 255, 1)',
                                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                borderWidth: 2,
                                tension: 0.1,
                                fill: false,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: false,
                                    title: {
                                        display: true,
                                        text: 'mg/dL'
                                    },
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.05)',
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    mode: 'index',
                                    intersect: false,
                                },
                                legend: {
                                    position: 'top',
                                }
                            }
                        }
                    });
                }

                // Grafik Asam Urat
                if (document.getElementById('chartAsamUrat')) {
                    new Chart(document.getElementById('chartAsamUrat'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Asam Urat',
                                data: asamUrat,
                                borderColor: 'rgba(255, 206, 86, 1)',
                                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                                borderWidth: 2,
                                tension: 0.1,
                                fill: false,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: false,
                                    title: {
                                        display: true,
                                        text: 'mg/dL'
                                    },
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.05)',
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    mode: 'index',
                                    intersect: false,
                                },
                                legend: {
                                    position: 'top',
                                }
                            }
                        }
                    });
                }

                // Grafik IMT
                if (document.getElementById('chartIMT')) {
                    new Chart(document.getElementById('chartIMT'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'IMT',
                                data: imt,
                                borderColor: 'rgba(255, 159, 64, 1)',
                                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                                borderWidth: 2,
                                tension: 0.1,
                                fill: false,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: false,
                                    title: {
                                        display: true,
                                        text: 'kg/m²'
                                    },
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.05)',
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    mode: 'index',
                                    intersect: false,
                                },
                                legend: {
                                    position: 'top',
                                }
                            }
                        }
                    });
                }

                // Grafik Lingkar Perut
                if (document.getElementById('chartLingkarPerut')) {
                    new Chart(document.getElementById('chartLingkarPerut'), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Lingkar Perut',
                                data: lingkarPerut,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderWidth: 2,
                                tension: 0.1,
                                fill: false,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: false,
                                    title: {
                                        display: true,
                                        text: 'cm'
                                    },
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.05)',
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    mode: 'index',
                                    intersect: false,
                                },
                                legend: {
                                    position: 'top',
                                }
                            }
                        }
                    });
                }
            }

            // Handle PDF button click
            const cetakPDF = document.getElementById('cetakPDF');
            if (cetakPDF) {
                cetakPDF.addEventListener('click', function(e) {
                    e.preventDefault();

                    const bulan = document.getElementById('filterBulan').value;
                    const tahun = document.getElementById('filterTahun').value;
                    let url = "{{ route('petugas.cetakPdf', ['id' => $pasien->id ?? 0]) }}";

                    if (bulan || tahun) {
                        url += '?';
                        if (bulan) url += `bulan=${bulan}&`;
                        if (tahun) url += `tahun=${tahun}`;
                    }

                    window.open(url, '_blank');
                });
            }
        });
    </script>
@endsection
