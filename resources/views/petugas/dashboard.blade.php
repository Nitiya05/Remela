@extends('layouts.petugas')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header Dashboard -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Dashboard Petugas</h2>
            <p class="text-gray-600">Ringkasan data dan statistik terkini</p>
        </div>
        <div class="mt-4 md:mt-0">
            <div class="text-sm text-gray-500">Terakhir diperbarui: {{ now()->format('d M Y H:i') }}</div>
        </div>
    </div>

    <!-- Grid untuk Statistik Utama -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Kartu Jumlah Kader -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-400 p-6 rounded-xl shadow-lg transform transition-all duration-300 hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-white mb-1">Total Kader</h3>
                    <p class="text-3xl font-bold text-white">{{ $jumlahKader }}</p>
                    <p class="text-sm text-blue-100 mt-1">+2 dari bulan lalu</p>
                </div>
                <div class="bg-white/20 p-3 rounded-full">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Kartu Jumlah Pasien -->
        <div class="bg-gradient-to-r from-green-500 to-green-400 p-6 rounded-xl shadow-lg transform transition-all duration-300 hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-white mb-1">Total Pasien</h3>
                    <p class="text-3xl font-bold text-white">{{ $jumlahPasien }}</p>
                    <p class="text-sm text-green-100 mt-1">{{ $jumlahPasienBaru }} baru bulan ini</p>
                </div>
                <div class="bg-white/20 p-3 rounded-full">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Kartu Jumlah Rekam Medis -->
        <div class="bg-gradient-to-r from-purple-500 to-purple-400 p-6 rounded-xl shadow-lg transform transition-all duration-300 hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-white mb-1">Total Rekam Medis</h3>
                    <p class="text-3xl font-bold text-white">{{ $jumlahRekamMedis }}</p>
                    <p class="text-sm text-purple-100 mt-1">{{ $jumlahKunjunganBulanIni }} bulan ini</p>
                </div>
                <div class="bg-white/20 p-3 rounded-full">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Kartu Jenis Kelamin -->
        <div class="bg-gradient-to-r from-pink-500 to-pink-400 p-6 rounded-xl shadow-lg transform transition-all duration-300 hover:scale-[1.02]">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-white mb-1">Distribusi Gender</h3>
                    <div class="flex space-x-4 mt-2">
                        <div class="text-center">
                            <p class="text-xl font-bold text-white">{{ $jenisKelaminData['data'][0] }}</p>
                            <p class="text-xs text-pink-100">Laki-laki</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xl font-bold text-white">{{ $jenisKelaminData['data'][1] }}</p>
                            <p class="text-xs text-pink-100">Perempuan</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white/20 p-3 rounded-full">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid untuk Chart dan Aktivitas -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Chart Kunjungan 6 Bulan Terakhir -->
        <div class="bg-white p-6 rounded-xl shadow-lg lg:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Kunjungan 6 Bulan Terakhir</h3>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 text-sm bg-blue-100 text-blue-600 rounded-full">Bulanan</button>
                </div>
            </div>
            <canvas id="kunjunganChart" height="250"></canvas>
        </div>

        <!-- Aktivitas Terkini -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Aktivitas Terkini</h3>
            <div class="space-y-4">
                @foreach($recentActivities as $activity)
                <div class="flex items-start">
                    <div class="p-2 bg-{{ $activity['color'] }}-100 text-{{ $activity['color'] }}-600 rounded-full mr-3">
                        @if($activity['icon'] == 'user-add')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        @elseif($activity['icon'] == 'document-text')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        @elseif($activity['icon'] == 'refresh')
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        @endif
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">{{ $activity['message'] }}</p>
                        @if(isset($activity['count']))
                        <p class="text-sm text-gray-600">{{ $activity['count'] }} data</p>
                        @endif
                        <p class="text-xs text-gray-500">{{ $activity['time']->diffForHumans() }}</p>
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
    </div>

    <!-- Grid untuk Chart Demografi -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Chart Golongan Darah -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Golongan Darah Pasien</h3>
            <canvas id="golonganDarahChart" height="250"></canvas>
        </div>

        <!-- Chart Kelompok Usia -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Kelompok Usia Pasien</h3>
            <canvas id="kelompokUsiaChart" height="250"></canvas>
        </div>
    </div>

    <!-- Grid untuk Chart Lainnya -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Chart Status Kawin -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Status Kawin Pasien</h3>
            <canvas id="statusKawinChart" height="250"></canvas>
        </div>

        <!-- Chart Pendidikan Terakhir -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Pendidikan Terakhir</h3>
            <canvas id="pendidikanTerakhirChart" height="250"></canvas>
        </div>

        <!-- Chart Pekerjaan -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Pekerjaan Pasien</h3>
            <canvas id="pekerjaanChart" height="250"></canvas>
        </div>
    </div>
</div>

<!-- Script untuk Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Warna untuk chart
        const chartColors = [
            '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6',
            '#EC4899', '#14B8A6', '#F97316', '#64748B', '#06B6D4'
        ];

        // Chart Kunjungan 6 Bulan Terakhir
        const kunjunganCtx = document.getElementById('kunjunganChart').getContext('2d');
        new Chart(kunjunganCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($kunjunganPerBulan->toArray())) !!},
                datasets: [{
                    label: 'Jumlah Kunjungan',
                    data: {!! json_encode(array_values($kunjunganPerBulan->toArray())) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderColor: '#3B82F6',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#3B82F6',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Chart Golongan Darah
        new Chart(document.getElementById('golonganDarahChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($golonganDarah->pluck('golongan_darah')) !!},
                datasets: [{
                    data: {!! json_encode($golonganDarah->pluck('total')) !!},
                    backgroundColor: chartColors,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                cutout: '70%'
            }
        });

        // Chart Kelompok Usia
        new Chart(document.getElementById('kelompokUsiaChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($kelompokUsia->pluck('kelompok_usia')) !!},
                datasets: [{
                    label: 'Jumlah Pasien',
                    data: {!! json_encode($kelompokUsia->pluck('total')) !!},
                    backgroundColor: chartColors,
                    borderWidth: 0,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Chart Status Kawin
        new Chart(document.getElementById('statusKawinChart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($statusKawin->pluck('status_kawin')) !!},
                datasets: [{
                    data: {!! json_encode($statusKawin->pluck('total')) !!},
                    backgroundColor: chartColors,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Chart Pendidikan Terakhir
        new Chart(document.getElementById('pendidikanTerakhirChart'), {
            type: 'polarArea',
            data: {
                labels: {!! json_encode($pendidikanTerakhir->pluck('pendidikan_terakhir')) !!},
                datasets: [{
                    data: {!! json_encode($pendidikanTerakhir->pluck('total')) !!},
                    backgroundColor: chartColors,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Chart Pekerjaan
        new Chart(document.getElementById('pekerjaanChart'), {
            type: 'radar',
            data: {
                labels: {!! json_encode($pekerjaan->pluck('pekerjaan')) !!},
                datasets: [{
                    label: 'Jumlah Pasien',
                    data: {!! json_encode($pekerjaan->pluck('total')) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: '#3B82F6',
                    borderWidth: 2,
                    pointBackgroundColor: '#3B82F6',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    r: {
                        angleLines: {
                            display: true
                        },
                        suggestedMin: 0
                    }
                }
            }
        });
    });
</script>
@endsection