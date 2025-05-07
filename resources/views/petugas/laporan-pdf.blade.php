<!DOCTYPE html>
<html>
<head>
    <title>Data Diri Pasien</title>
    <style>
        @page {
            margin: 2cm; 
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }
        .header p {
            font-size: 12px;
            margin: 0;
        }
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .data-diri {
            max-width: 600px;
            margin: 20px auto;
            padding: 10px;
            border: 1px solid #000;
        }
        .data-diri h1 {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .data-diri p {
            margin: 5px 0;
        }
        .data-diri .left-column {
            float: left;
            width: 50%;
        }
        .data-diri .right-column {
            float: right;
            width: 50%;
        }
        .data-diri::after {
            content: "";
            display: table;
            clear: both;
        }
        .content {
            margin: 0 auto;
            max-width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            font-style: italic;
            color: #666;
            border: 1px dashed #ccc;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>RIWAYAT KESEHATAN</h1>
        <p>Posyandu Lansia Kopelma Darussalam</p>
    </div>
    
    <!-- Data Diri Pasien -->
    <h2 style="font-size: 14px; font-weight: bold; margin-bottom: 10px;">DATA DIRI PASIEN</h2>

    <div class="data-diri">
        <!-- Kolom Kiri -->
        <div class="left-column">
            <p><strong>Nama:</strong> {{ $pasien->nama ?? '-' }}</p>
            <p><strong>NIK:</strong> {{ $pasien->nik ?? '-' }}</p>
            <p><strong>Tanggal Lahir:</strong> 
                @if(isset($pasien->tanggal_lahir))
                    {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d M Y') }}
                @else
                    -
                @endif
            </p>
            <p><strong>Umur:</strong> {{ $pasien->umur ?? '-' }}</p>
            <p><strong>Jenis Kelamin:</strong> {{ $pasien->jenis_kelamin ?? '-' }}</p>
            <p><strong>No. HP:</strong> {{ $pasien->no_hp ?? '-' }}</p>
        </div>
        
        <!-- Kolom Kanan -->
        <div class="right-column">
            <p><strong>Alamat:</strong> {{ $pasien->alamat ?? '-' }}</p>
            <p><strong>Pendidikan Terakhir:</strong> {{ $pasien->pendidikan_terakhir ?? '-' }}</p>
            <p><strong>Pekerjaan:</strong> {{ $pasien->pekerjaan ?? '-' }}</p>
            <p><strong>Status Kawin:</strong> {{ $pasien->status_kawin ?? '-' }}</p>
            <p><strong>Golongan Darah:</strong> {{ $pasien->golongan_darah ?? '-' }}</p>
            <p><strong>Email:</strong> {{ $pasien->email ?? '-' }}</p>
        </div>
    </div>

    <!-- Riwayat Kesehatan -->
    <div class="content">
        <h2 style="font-size: 14px; font-weight: bold; margin-bottom: 10px;">RIWAYAT KESEHATAN</h2>
        
        @if($pasien->rekamMedisLansia && count($pasien->rekamMedisLansia) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Tanggal Rekam</th>
                        <th>Data</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pasien->rekamMedisLansia as $item)
                        <tr>
                            <td rowspan="14">{{ \Carbon\Carbon::parse($item->tanggal_rekam)->format('d M Y') }}</td>
                            <td>Tekanan Darah</td>
                            <td>{{ $item->tekanan_darah_sistolik }}/{{ $item->tekanan_darah_diastolik }} mmHg</td>
                        </tr>
                        <tr>
                            <td>Gula Darah</td>
                            <td>{{ $item->gula_darah }} mg/dL</td>
                        </tr>
                        <tr>
                            <td>Kolesterol</td>
                            <td>{{ $item->kolesterol }} mg/dL</td>
                        </tr>
                        <tr>
                            <td>Berat Badan</td>
                            <td>{{ $item->berat_badan }} kg</td>
                        </tr>
                        <tr>
                            <td>Tinggi Badan</td>
                            <td>{{ $item->tinggi_badan }} cm</td>
                        </tr>
                        <tr>
                            <td>Lingkar Perut</td>
                            <td>{{ $item->lingkar_perut }} cm</td>
                        </tr>
                        <tr>
                            <td>BMI</td>
                            <td>{{ $item->bmi }}</td>
                        </tr>
                        <tr>
                            <td>Asam Urat</td>
                            <td>{{ $item->asam_urat }} mg/dL</td>
                        </tr>
                        <tr>
                            <td>Merokok</td>
                            <td>{{ $item->merokok ? 'Ya' : 'Tidak' }}</td>
                        </tr>
                        <tr>
                            <td>Kurang Aktivitas Fisik</td>
                            <td>{{ $item->kurang_aktivitas_fisik ? 'Ya' : 'Tidak' }}</td>
                        </tr>
                        <tr>
                            <td>Kurang Sayur dan Buah</td>
                            <td>{{ $item->kurang_sayur_buah ? 'Ya' : 'Tidak' }}</td>
                        </tr>
                        <tr>
                            <td>Konsumsi Alkohol</td>
                            <td>{{ $item->konsumsi_alkohol ? 'Ya' : 'Tidak' }}</td>
                        </tr>
                        <tr>
                            <td>Obat</td>
                            <td>{{ $item->obat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Catatan Petugas</td>
                            <td>{{ $item->catatan_petugas ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                <p>Belum ada data rekam medis untuk pasien ini</p>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Tanggal di Cetak: {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}</p>
    </div>
</body>
</html>