@extends('layouts.kader')

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
                <p class="font-semibold">{{ $pasien->nama }}</p>
            </div>
            <div>
                <p class="text-gray-600">NIK:</p>
                <p class="font-semibold">{{ $pasien->nik }}</p>
            </div>
            <div>
                <p class="text-gray-600">Tanggal Lahir:</p>
                <p class="font-semibold">{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d M Y') }}</p>
            </div>
            <div>
                <p class="text-gray-600">Jenis Kelamin:</p>
                <p class="font-semibold">{{ $pasien->jenis_kelamin }}</p>
            </div>
            <div>
                <p class="text-gray-600">Alamat:</p>
                <p class="font-semibold">{{ $pasien->alamat }}</p>
            </div>
            <div>
                <p class="text-gray-600">No. Telepon:</p>
                <p class="font-semibold">{{ $pasien->no_telepon }}</p>
            </div>
            <div>
                <p class="text-gray-600">Umur:</p>
                <p class="font-semibold">{{ $pasien->umur }}</p>
            </div>
            <div>
                <p class="text-gray-600">Pendidikan Terakhir:</p>
                <p class="font-semibold">{{ $pasien->pendidikan_terakhir }}</p>
            </div>
            <div>
                <p class="text-gray-600">Pekerjaan:</p>
                <p class="font-semibold">{{ $pasien->pekerjaan }}</p>
            </div>
            <div>
                <p class="text-gray-600">Status Kawin:</p>
                <p class="font-semibold">{{ $pasien->status_kawin }}</p>
            </div>
            <div>
                <p class="text-gray-600">Golongan Darah:</p>
                <p class="font-semibold">{{ $pasien->golongan_darah }}</p>
            </div>
            <div>
                <p class="text-gray-600">Email:</p>
                <p class="font-semibold">{{ $pasien->email }}</p>
            </div>
        </div>

        {{-- Layout Dua Kolom --}}
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Kolom Kiri: Tabel Riwayat Kesehatan -->
            <div class="w-full lg:w-1/2 bg-white p-6 shadow-md rounded-lg overflow-x-auto">
                <h3 class="text-xl font-semibold mb-4">Riwayat Kesehatan</h3>

                <!-- Form Filter dan Tombol Cetak PDF -->
                <div class="flex flex-col md:flex-row gap-4 mb-6">
                    <form action="{{ route('rekam-medis-lansia.show', $pasien->id) }}" method="GET" class="flex flex-col md:flex-row gap-2 flex-grow">
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
                            @foreach (range(date('Y') - 5, date('Y')) as $y)
                                <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>
                
                        <!-- Tombol Filter -->
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                            Filter
                        </button>
                    </form>
                
                    <!-- Tombol Cetak PDF dengan parameter filter -->
                    <a href="#" id="cetakPDF" 
                       class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition flex items-center justify-center">
                        Cetak PDF
                    </a>
                </div>
                
                

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
                                {{ $record->tekanan_darah_sistolik }}/{{ $record->tekanan_darah_diastolik }} mmHg
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">Gula Darah</td>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                {{ $record->gula_darah }} mg/dL
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">Kolesterol</td>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                {{ $record->kolesterol }} mg/dL
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">Berat Badan</td>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                {{ $record->berat_badan }} kg
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">Tinggi Badan</td>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                {{ $record->tinggi_badan }} cm
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">Lingkar Perut</td>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                {{ $record->lingkar_perut }} cm
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">BMI</td>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                {{ $record->bmi }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">Asam Urat</td>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                {{ $record->asam_urat }} mg/dL
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">Merokok</td>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                {{ $record->merokok ? 'Ya' : 'Tidak' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">Kurang Aktivitas Fisik</td>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                {{ $record->kurang_aktivitas_fisik ? 'Ya' : 'Tidak' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">Kurang Sayur dan Buah</td>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                {{ $record->kurang_sayur_buah ? 'Ya' : 'Tidak' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">Konsumsi Alkohol</td>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                {{ $record->konsumsi_alkohol ? 'Ya' : 'Tidak' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">Obat</td>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                {{ $record->obat }}
                            </td>
                        </tr>
                        <tr>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">Catatan Petugas</td>
                            <td class="border p-2 text-sm md:text-base whitespace-nowrap">
                                {{ $record->catatan_petugas }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Kolom Kanan: Grafik -->
            <div class="w-full lg:w-1/2">
                <div class="grid grid-cols-1 gap-6">
                    <!-- Grafik Tekanan Darah -->
                    <div class="bg-white p-6 shadow-md rounded-lg">
                        <h3 class="text-xl font-semibold mb-4">Tekanan Darah</h3>
                        <canvas id="chartTekananDarah" class="w-full h-96"></canvas>
                    </div>

                    <!-- Grafik Gula Darah -->
                    <div class="bg-white p-6 shadow-md rounded-lg">
                        <h3 class="text-xl font-semibold mb-4">Gula Darah</h3>
                        <canvas id="chartGulaDarah" class="w-full h-96"></canvas>
                    </div>

                    <!-- Grafik Kolesterol -->
                    <div class="bg-white p-6 shadow-md rounded-lg">
                        <h3 class="text-xl font-semibold mb-4">Kolesterol</h3>
                        <canvas id="chartKolesterol" class="w-full h-96"></canvas>
                    </div>

                    <!-- Grafik Asam Urat -->
                    <div class="bg-white p-6 shadow-md rounded-lg">
                        <h3 class="text-xl font-semibold mb-4">Asam Urat</h3>
                        <canvas id="chartAsamUrat" class="w-full h-96"></canvas>
                    </div>

                    <!-- Grafik IMT -->
                    <div class="bg-white p-6 shadow-md rounded-lg">
                        <h3 class="text-xl font-semibold mb-4">Indeks Massa Tubuh</h3>
                        <canvas id="chartIMT" class="w-full h-96"></canvas>
                    </div>

                    <!-- Grafik Lingkar Perut -->
                    <div class="bg-white p-6 shadow-md rounded-lg">
                        <h3 class="text-xl font-semibold mb-4">Lingkar Perut</h3>
                        <canvas id="chartLingkarPerut" class="w-full h-96"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-6">
            <a href="{{ route('rekam-medis-lansia.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                Kembali
            </a>
        </div>
    @else
        {{-- Tampilkan pesan jika pasien tidak ditemukan --}}
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <p class="text-red-500 font-semibold">Data pasien tidak ditemukan.</p>
            <a href="{{ route('rekam-medis-lansia.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition mt-4 inline-block">
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
                            fill: false,
                        },
                        {
                            label: 'Tekanan Darah Diastolik',
                            data: tekananDarahDiastolik,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            fill: false,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'mmHg'
                            }
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
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'mg/dL'
                            }
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
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'mg/dL'
                            }
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
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'mg/dL'
                            }
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
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'kg/m²'
                            }
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
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'cm'
                            }
                        }
                    }
                }
            });
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cetakPDF = document.getElementById('cetakPDF');
        const filterBulan = document.getElementById('filterBulan');
        const filterTahun = document.getElementById('filterTahun');
        
        cetakPDF.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Ambil nilai filter
            const bulan = filterBulan.value;
            const tahun = filterTahun.value;
            
            // Bangun URL dengan parameter
            let url = "{{ route('rekam-medis.printpdf') }}";
            
            // Tambahkan parameter jika ada
            if (bulan || tahun) {
                url += '?';
                
                if (bulan) url += `bulan=${bulan}&`;
                if (tahun) url += `tahun=${tahun}`;
            }
            
            // Buka tab baru untuk cetak PDF
            window.open(url, '_blank');
        });
    });
    </script>
@endsection