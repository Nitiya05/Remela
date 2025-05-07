@extends('layouts.kader')

@section('content')

<!-- Tombol Menu untuk Mobile -->
<button onclick="toggleSidebar()" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 md:hidden">☰ Menu</button>

<!-- Header Dashboard -->
<header class="bg-white shadow p-5 rounded-lg mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ $kader->nama ?? 'Kader' }}!</h2>
</header>

<!-- Kontainer Chart -->
<section class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6 pb-16">
    <!-- Jumlah Semua Pasien -->
    <div class="bg-white p-6 rounded-lg shadow" data-intro="Ini adalah jumlah total pasien." data-step="9">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Jumlah Semua Pasien</h3>
        <div class="chart-container">
            <canvas id="jumlahPasienChart"></canvas>
        </div>
    </div>

    <!-- Jumlah Lansia -->
    <div class="bg-white p-6 rounded-lg shadow" data-intro="Bagian ini menunjukkan jumlah lansia berusia 60+." data-step="10">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Jumlah Lansia (60+)</h3>
        <div class="chart-container">
            <canvas id="jumlahLansiaChart"></canvas>
        </div>
    </div>

    <!-- Distribusi Umur Lansia -->
    <div class="bg-white p-6 rounded-lg shadow" data-intro="Distribusi umur lansia berdasarkan kelompok usia." data-step="11">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Distribusi Umur Lansia</h3>
        <div class="chart-container">
            <canvas id="umurChart"></canvas>
        </div>
    </div>

    <!-- Jenis Kelamin Lansia -->
    <div class="bg-white p-6 rounded-lg shadow" data-intro="Perbandingan jumlah lansia berdasarkan jenis kelamin." data-step="12">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Jenis Kelamin Lansia</h3>
        <div class="chart-container">
            <canvas id="genderChart"></canvas>
        </div>
    </div>
</section>

<!-- Tambahkan Script Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let jumlahPasienChart, jumlahLansiaChart, umurChart, genderChart;

    function renderCharts() {
        const jumlahPasienCtx = document.getElementById('jumlahPasienChart').getContext('2d');
        const jumlahLansiaCtx = document.getElementById('jumlahLansiaChart').getContext('2d');
        const umurChartCtx = document.getElementById('umurChart').getContext('2d');
        const genderChartCtx = document.getElementById('genderChart').getContext('2d');

        // Hapus chart lama sebelum render ulang
        if (jumlahPasienChart) jumlahPasienChart.destroy();
        if (jumlahLansiaChart) jumlahLansiaChart.destroy();
        if (umurChart) umurChart.destroy();
        if (genderChart) genderChart.destroy();

        // Chart Jumlah Semua Pasien
        jumlahPasienChart = new Chart(jumlahPasienCtx, {
            type: 'bar',
            data: {
                labels: ['Total Pasien'],
                datasets: [{
                    label: 'Jumlah Pasien',
                    data: [{{ $jumlahPasien }}],
                    backgroundColor: ['#4caf50']
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // Chart Jumlah Lansia (Hanya yang Usia 60+)
        jumlahLansiaChart = new Chart(jumlahLansiaCtx, {
            type: 'bar',
            data: {
                labels: ['Lansia (60+)'],
                datasets: [{
                    label: 'Jumlah Lansia',
                    data: [{{ $jumlahLansia }}],
                    backgroundColor: ['#ff6384']
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // Chart Distribusi Umur Lansia
        umurChart = new Chart(umurChartCtx, {
            type: 'bar',
            data: {
                labels: ['50-59', '60-64', '65-69', '70-74', '75-79', '80+'],
                datasets: [{
                    label: 'Jumlah Lansia',
                    data: [
                        {{ $umurDistribusi->usia_50_59 }},
                        {{ $umurDistribusi->usia_60_64 }},
                        {{ $umurDistribusi->usia_65_69 }},
                        {{ $umurDistribusi->usia_70_74 }},
                        {{ $umurDistribusi->usia_75_79 }},
                        {{ $umurDistribusi->usia_80_plus }}
                    ],
                    backgroundColor: '#36a2eb'
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // Chart Jenis Kelamin Lansia
        genderChart = new Chart(genderChartCtx, {
            type: 'pie',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    label: 'Jumlah',
                    data: [
                        {{ $genderDistribusi->laki }},
                        {{ $genderDistribusi->perempuan }}
                    ],
                    backgroundColor: ['#ffcd56', '#ff6384']
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    }

    document.addEventListener('DOMContentLoaded', renderCharts);
</script>

<!-- Tambahkan Intro.js untuk Panduan Interaktif -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.1.0/introjs.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.1.0/intro.min.js"></script>
<script>
    function startTour() {
        introJs().setOptions({
            showStepNumbers: false,
            showBullets: true,
            exitOnOverlayClick: false,
            nextLabel: 'Lanjut',
            prevLabel: 'Kembali',
            doneLabel: 'Selesai'
        }).start();
    }
</script>

<style>
    .chart-container {
        position: relative;
        height: 250px; /* Atur tinggi chart */
        width: 100%;
    }

    canvas {
        max-height: 100% !important;
        width: 100% !important;
    }
</style>

@endsection