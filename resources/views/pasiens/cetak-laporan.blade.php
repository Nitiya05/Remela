<!DOCTYPE html>
<html>

<head>
    <title>Rekam Medis Lansia</title>
    <style>
        @page {
            margin: 1.5cm;
            size: A4;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 14px;
            line-height: 1.5;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #004d40;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            color: #004d40;
            margin: 5px 0;
        }

        .patient-info {
            display: flex;
            width: 100%;
            margin-bottom: 20px;
            gap: 20px;
            /* Jarak antara kolom */
        }

        .left-column,
        .right-column {
            flex: 1;
            /* Membagi ruang sama rata */
            border: 1px solid #ddd;
            /* Garis pembatas */
            padding: 10px;
            box-sizing: border-box;
        }

        .medical-history {
            width: 100%;
            border-collapse: collapse;
        }

        .medical-history tr td:first-child {
            font-weight: bold;
            width: 40%;
            /* Lebar kolom pertama */
            vertical-align: top;
        }

        .medical-history td {
            padding: 6px;
            border-bottom: 1px solid #eee;
        }

        .section-title {
            background-color: #e0f2f1;
            color: #004d40;
            padding: 6px 10px;
            font-weight: bold;
            margin: 15px 0 10px;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .status-card {
            display: inline-block;
            padding: 6px 12px;
            margin: 3px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 11px;
        }

        .status-normal {
            background-color: #4caf50;
            color: white;
        }

        .status-warning {
            background-color: #ffeb3b;
            color: #000;
        }

        .status-danger {
            background-color: #f44336;
            color: white;
        }

        .status-info {
            background-color: #2196f3;
            color: white;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 11px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .no-data {
            text-align: center;
            padding: 15px;
            font-style: italic;
            color: #666;
            border: 1px dashed #ccc;
            margin: 10px 0;
        }

        .medical-history tr td:first-child {
            font-weight: bold;
            width: 30%;
        }

        .classification {
            font-size: 10px;
            font-style: italic;
            margin-left: 5px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>REKAM MEDIS LANSIA</h1>
        <p>Posyandu Lansia Kopelma Darussalam</p>
    </div>

    <!-- Patient Information -->
    <div class="section-title">DATA PASIEN</div>
    <div class="patient-info">
        <!-- Kolom Kiri -->
        <div class="left-column">
            <table class="medical-history">
                <tr>
                    <td>Nama Lengkap</td>
                    <td>{{ $pasien->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>{{ $pasien->nik ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td>
                        @if (isset($pasien->tanggal_lahir))
                            {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d F Y') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Umur</td>
                    <td>{{ $pasien->umur ?? '-' }} tahun</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>{{ $pasien->jenis_kelamin ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Kolom Kanan -->
        <div class="right-column">
            <table class="medical-history">
                <tr>
                    <td>Alamat</td>
                    <td>{{ $pasien->alamat ?? '-' }}</td>
                </tr>
                <tr>
                    <td>No. HP</td>
                    <td>{{ $pasien->no_hp ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Pendidikan Terakhir</td>
                    <td>{{ $pasien->pendidikan_terakhir ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td>{{ $pasien->pekerjaan ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Golongan Darah</td>
                    <td>{{ $pasien->golongan_darah ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Current Health Status -->
    <div class="section-title">STATUS KESEHATAN TERKINI</div>
    <div style="margin-bottom: 30px; font-size: 16px; font-family: 'Arial', sans-serif;">
        @php
            $latestRecord = $pasien->rekamMedisLansia->last();
            $isLansia = $pasien->umur >= 60; // Kriteria lansia ≥60 tahun
        @endphp

        @if ($latestRecord)
            <table style="width: 100%; border-collapse: collapse; background-color: white;">
                <thead>
                    <tr style="background-color: #e0f7fa;">
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #00897b;">Parameter</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #00897b;">Hasil</th>
                        <th style="padding: 12px; text-align: left; border-bottom: 2px solid #00897b;">Evaluasi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- TEKANAN DARAH -->
                    <tr>
                        <td style="padding: 12px; font-weight: bold; color: #00695c;">
                            Tekanan Darah
                            <div style="font-size: 14px; color: #666; font-weight: normal;">(Pengukuran terkini)</div>
                        </td>
                        <td style="padding: 12px;">
                            {{ $latestRecord->tekanan_darah_sistolik }}/{{ $latestRecord->tekanan_darah_diastolik }}
                            mmHg
                        </td>
                        <td style="padding: 12px;">
                            @php
                                // Kriteria khusus lansia
                                if ($isLansia) {
                                    if (
                                        $latestRecord->tekanan_darah_sistolik < 130 &&
                                        $latestRecord->tekanan_darah_diastolik < 85
                                    ) {
                                        $status = 'status-normal';
                                        $keterangan = 'Normal';
                                    } elseif (
                                        ($latestRecord->tekanan_darah_sistolik >= 130 &&
                                            $latestRecord->tekanan_darah_sistolik <= 139) ||
                                        ($latestRecord->tekanan_darah_diastolik >= 85 &&
                                            $latestRecord->tekanan_darah_diastolik <= 89)
                                    ) {
                                        $status = 'status-warning';
                                        $keterangan = 'Perlu Pemantauan';
                                    } else {
                                        $status = 'status-danger';
                                        $keterangan = 'Konsultasi Dokter';
                                    }
                                    $normalRange = 'Normal lansia: <130/85 mmHg';
                                } else {
                                    // Kriteria dewasa muda
                                    if (
                                        $latestRecord->tekanan_darah_sistolik < 120 &&
                                        $latestRecord->tekanan_darah_diastolik < 80
                                    ) {
                                        $status = 'status-normal';
                                        $keterangan = 'Normal';
                                    } elseif (
                                        ($latestRecord->tekanan_darah_sistolik >= 120 &&
                                            $latestRecord->tekanan_darah_sistolik <= 129) ||
                                        ($latestRecord->tekanan_darah_diastolik >= 80 &&
                                            $latestRecord->tekanan_darah_diastolik <= 84)
                                    ) {
                                        $status = 'status-warning';
                                        $keterangan = 'Perhatian';
                                    } else {
                                        $status = 'status-danger';
                                        $keterangan = 'Konsultasi Dokter';
                                    }
                                    $normalRange = 'Normal: <120/80 mmHg';
                                }
                            @endphp
                            <span class="status-card {{ $status }}" style="font-size: 15px;">
                                {{ $keterangan }}
                            </span>
                            <div style="font-size: 14px; color: #666; margin-top: 5px;">
                                {{ $normalRange }}
                            </div>
                        </td>
                    </tr>

                    <!-- IMT -->
                    <tr style="background-color: #f5f5f5;">
                        <td style="padding: 12px; font-weight: bold; color: #00695c;">
                            Indeks Massa Tubuh
                            <div style="font-size: 14px; color: #666; font-weight: normal;">(Berat dan Tinggi Badan)
                            </div>
                        </td>
                        <td style="padding: 12px;">
                            @php
                                $tinggi_m = $latestRecord->tinggi_badan / 100;
                                $imt = number_format($latestRecord->berat_badan / ($tinggi_m * $tinggi_m), 1);
                                echo $imt . ' kg/m²';
                            @endphp
                        </td>
                        <td style="padding: 12px;">
                            @php
                                // Kriteria khusus lansia
                                if ($isLansia) {
                                    if ($imt < 22) {
                                        $status = 'status-warning';
                                        $keterangan = 'Kurang Berat';
                                    } elseif ($imt >= 22 && $imt <= 27) {
                                        $status = 'status-normal';
                                        $keterangan = 'Ideal';
                                    } else {
                                        $status = 'status-danger';
                                        $keterangan = 'Berlebih';
                                    }
                                    $normalRange = 'Normal lansia: 22-27 kg/m²';
                                } else {
                                    // Kriteria dewasa muda
                                    if ($imt < 18.5) {
                                        $status = 'status-warning';
                                        $keterangan = 'Kurang Berat';
                                    } elseif ($imt >= 18.5 && $imt <= 24.9) {
                                        $status = 'status-normal';
                                        $keterangan = 'Ideal';
                                    } else {
                                        $status = 'status-danger';
                                        $keterangan = 'Berlebih';
                                    }
                                    $normalRange = 'Normal: 18.5-24.9 kg/m²';
                                }
                            @endphp
                            <span class="status-card {{ $status }}" style="font-size: 15px;">
                                {{ $keterangan }}
                            </span>
                            <div style="font-size: 14px; color: #666; margin-top: 5px;">
                                {{ $normalRange }}
                            </div>
                        </td>
                    </tr>

                    <!-- GULA DARAH -->
                    <tr>
                        <td style="padding: 12px; font-weight: bold; color: #00695c;">
                            Gula Darah Puasa
                            <div style="font-size: 14px; color: #666; font-weight: normal;">(8 jam puasa)</div>
                        </td>
                        <td style="padding: 12px;">
                            {{ $latestRecord->gula_darah }} mg/dL
                        </td>
                        <td style="padding: 12px;">
                            @php
                                // Kriteria sama untuk semua usia
                                if ($latestRecord->gula_darah < 100) {
                                    $status = 'status-normal';
                                    $keterangan = 'Normal';
                                } elseif ($latestRecord->gula_darah >= 100 && $latestRecord->gula_darah <= 125) {
                                    $status = 'status-warning';
                                    $keterangan = 'Pra-Diabetes';
                                } else {
                                    $status = 'status-danger';
                                    $keterangan = 'Diabetes';
                                }
                                $normalRange = 'Normal: <100 mg/dL';
                            @endphp
                            <span class="status-card {{ $status }}" style="font-size: 15px;">
                                {{ $keterangan }}
                            </span>
                            <div style="font-size: 14px; color: #666; margin-top: 5px;">
                                {{ $normalRange }}
                            </div>
                        </td>
                    </tr>

                    <!-- KOLESTEROL -->
                    <tr style="background-color: #f5f5f5;">
                        <td style="padding: 12px; font-weight: bold; color: #00695c;">
                            Kolesterol Total
                        </td>
                        <td style="padding: 12px;">
                            {{ $latestRecord->kolesterol }} mg/dL
                        </td>
                        <td style="padding: 12px;">
                            @php
                                // Kriteria khusus lansia (lebih longgar)
                                if ($isLansia) {
                                    if ($latestRecord->kolesterol < 200) {
                                        $status = 'status-normal';
                                        $keterangan = 'Normal';
                                    } elseif ($latestRecord->kolesterol >= 200 && $latestRecord->kolesterol <= 239) {
                                        $status = 'status-warning';
                                        $keterangan = 'Batas Tinggi';
                                    } else {
                                        $status = 'status-danger';
                                        $keterangan = 'Tinggi';
                                    }
                                    $normalRange = 'Normal lansia: <200 mg/dL';
                                } else {
                                    // Kriteria dewasa muda
                                    if ($latestRecord->kolesterol < 200) {
                                        $status = 'status-normal';
                                        $keterangan = 'Normal';
                                    } elseif ($latestRecord->kolesterol >= 200 && $latestRecord->kolesterol <= 239) {
                                        $status = 'status-warning';
                                        $keterangan = 'Batas Tinggi';
                                    } else {
                                        $status = 'status-danger';
                                        $keterangan = 'Tinggi';
                                    }
                                    $normalRange = 'Normal: <200 mg/dL';
                                }
                            @endphp
                            <span class="status-card {{ $status }}" style="font-size: 15px;">
                                {{ $keterangan }}
                            </span>
                            <div style="font-size: 14px; color: #666; margin-top: 5px;">
                                {{ $normalRange }}
                            </div>
                        </td>
                    </tr>

                    <!-- LINGKAR PERUT -->
                    <tr>
                        <td style="padding: 12px; font-weight: bold; color: #00695c;">
                            Lingkar Perut
                            <div style="font-size: 14px; color: #666; font-weight: normal;">(Ukuran risiko metabolik)
                            </div>
                        </td>
                        <td style="padding: 12px;">
                            {{ $latestRecord->lingkar_perut }} cm
                        </td>
                        <td style="padding: 12px;">
                            @php
                                $jenis_kelamin = $pasien->jenis_kelamin;
                                // Kriteria sama untuk semua usia
                                if (
                                    ($jenis_kelamin == 'Laki-laki' && $latestRecord->lingkar_perut < 90) ||
                                    ($jenis_kelamin == 'Perempuan' && $latestRecord->lingkar_perut < 80)
                                ) {
                                    $status = 'status-normal';
                                    $keterangan = 'Normal';
                                }
                                if ($latestRecord->lingkar_perut < 50) {
                                    $status = 'status-warning';
                                    $keterangan = 'Terlalu Rendah';
                                } else {
                                    $status = 'status-danger';
                                    $keterangan = 'Risiko Tinggi';
                                }
                                $normalRange = $jenis_kelamin == 'Laki-laki' ? 'Normal: <90 cm' : 'Normal: <80 cm';
                            @endphp
                            <span class="status-card {{ $status }}" style="font-size: 15px;">
                                {{ $keterangan }}
                            </span>
                            <div style="font-size: 14px; color: #666; margin-top: 5px;">
                                {{ $normalRange }}
                            </div>
                        </td>
                    </tr>

                    <!-- ASAM URAT -->
                    <tr style="background-color: #f5f5f5;">
                        <td style="padding: 12px; font-weight: bold; color: #00695c;">
                            Asam Urat
                        </td>
                        <td style="padding: 12px;">
                            {{ $latestRecord->asam_urat }} mg/dL
                        </td>
                        <td style="padding: 12px;">
                            @php
                                $jenis_kelamin = $pasien->jenis_kelamin;
                                // Kriteria khusus lansia (lebih tinggi)
                                if ($isLansia) {
                                    if (
                                        ($jenis_kelamin == 'Laki-laki' && $latestRecord->asam_urat <= 7.5) ||
                                        ($jenis_kelamin == 'Perempuan' && $latestRecord->asam_urat <= 6.5)
                                    ) {
                                        $status = 'status-normal';
                                        $keterangan = 'Normal';
                                    } else {
                                        $status = 'status-danger';
                                        $keterangan = 'Tinggi';
                                    }
                                    $normalRange =
                                        $jenis_kelamin == 'Laki-laki'
                                            ? 'Normal lansia: ≤7.5 mg/dL'
                                            : 'Normal lansia: ≤6.5 mg/dL';
                                } else {
                                    // Kriteria dewasa muda
                                    if (
                                        ($jenis_kelamin == 'Laki-laki' && $latestRecord->asam_urat <= 7.0) ||
                                        ($jenis_kelamin == 'Perempuan' && $latestRecord->asam_urat <= 6.0)
                                    ) {
                                        $status = 'status-normal';
                                        $keterangan = 'Normal';
                                    } else {
                                        $status = 'status-danger';
                                        $keterangan = 'Tinggi';
                                    }
                                    $normalRange =
                                        $jenis_kelamin == 'Laki-laki' ? 'Normal: ≤7.0 mg/dL' : 'Normal: ≤6.0 mg/dL';
                                }
                            @endphp
                            <span class="status-card {{ $status }}" style="font-size: 15px;">
                                {{ $keterangan }}
                            </span>
                            <div style="font-size: 14px; color: #666; margin-top: 5px;">
                                {{ $normalRange }}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        @else
            <div style="text-align: center; padding: 20px; background-color: #f5f5f5; border-radius: 5px;">
                <p style="font-size: 15px; color: #666; margin: 0;">
                    Belum ada data pemeriksaan terkini
                </p>
            </div>
        @endif
    </div>

    <div style="font-size: 16px; font-family: Arial, sans-serif; 
            display: flex; align-items: center; gap: 10px;
            white-space: nowrap; flex-wrap: nowrap; overflow-x: auto;">
    <span>Keterangan Status:</span>
    
    <div style="display: flex; align-items: center; gap: 15px; flex-shrink: 0;">
        <div style="display: flex; align-items: center; flex-shrink: 0;">
            <span style="display: inline-block; width: 16px; height: 16px; border-radius: 50%; 
                   background-color: #4CAF50; margin-right: 6px; flex-shrink: 0;"></span>
            <span style="flex-shrink: 0;">Normal</span>
        </div>
        
        <div style="display: flex; align-items: center; flex-shrink: 0;">
            <span style="display: inline-block; width: 16px; height: 16px; border-radius: 50%; 
                   background-color: #FFC107; margin-right: 6px; flex-shrink: 0;"></span>
            <span style="flex-shrink: 0;">Perlu Evaluasi</span>
        </div>
        
        <div style="display: flex; align-items: center; flex-shrink: 0;">
            <span style="display: inline-block; width: 16px; height: 16px; border-radius: 50%; 
                   background-color: #F44336; margin-right: 6px; flex-shrink: 0;"></span>
            <span style="flex-shrink: 0;">Risiko Tinggi</span>
        </div>
    </div>
</div>

    <!-- Medical History -->
    <div class="section-title">RIWAYAT PEMERIKSAAN</div>
    @if ($pasien->rekamMedisLansia && count($pasien->rekamMedisLansia) > 0)
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Berat Badan (kg)</th>
                    <th>Tinggi Badan (cm)</th>
                    <th>IMT (kg/m2) </th>
                    <th>Tekanan Darah (mmHg) </th>
                    <th>Gula Darah (mg/dL)</th>
                    <th>Kolesterol (mg/dL)</th>
                    <th>Asam Urat (mg/dL) </th>
                    <th>Lingkar Perut (cm)</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($pasien->rekamMedisLansia->sortByDesc('tanggal_rekam') as $item)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_rekam)->format('d M Y') }}</td>
                        <td>{{ $item->berat_badan }}</td>
                        <td>{{ $item->tinggi_badan }}</td>
                        <td>
                            @php
                                $tinggi_m = $item->tinggi_badan / 100;
                                echo number_format($item->berat_badan / ($tinggi_m * $tinggi_m), 1);
                            @endphp
                        </td>
                        <td>{{ $item->tekanan_darah_sistolik }}/{{ $item->tekanan_darah_diastolik }}</td>
                        <td>{{ $item->gula_darah }}</td>
                        <td>{{ $item->kolesterol }}</td>
                        <td>{{ $item->asam_urat }}</td>
                        <td>{{ $item->lingkar_perut }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <p>Belum ada data rekam medis untuk pasien ini</p>
        </div>
    @endif

    <!-- Additional Information -->
    @if ($latestRecord)
        <div class="section-title">INFORMASI TAMBAHAN</div>
        <table>
            <tr>
                <td style="font-weight: bold;">Kebiasaan Hidup</td>
                <td>
                    @if (
                        $latestRecord->merokok ||
                            $latestRecord->kurang_aktivitas_fisik ||
                            $latestRecord->kurang_sayur_buah ||
                            $latestRecord->konsumsi_alkohol)
                        {{ $latestRecord->merokok ? 'Merokok, ' : '' }}
                        {{ $latestRecord->kurang_aktivitas_fisik ? 'Kurang Aktivitas Fisik, ' : '' }}
                        {{ $latestRecord->kurang_sayur_buah ? 'Kurang Konsumsi Sayur/Buah, ' : '' }}
                        {{ $latestRecord->konsumsi_alkohol ? 'Konsumsi Alkohol' : '' }}
                    @else
                        Tidak ada kebiasaan berisiko
                    @endif
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Konsumsi Obat</td>
                <td>{{ $latestRecord->obat ?? '-' }}</td>
            </tr>

            <tr>
                <td style="font-weight: bold;">Catatan Petugas</td>
                <td>{{ $latestRecord->catatan_petugas ?? '-' }}</td>
            </tr>
        </table>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i') }}</p>
        <p>© {{ date('Y') }} Posyandu Lansia Kopelma Darussalam</p>
    </div>
</body>

</html>
