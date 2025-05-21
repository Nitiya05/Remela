@extends('layouts.kader')

@section('content')

<h2 class="text-2xl font-bold mb-4">Edit Jadwal</h2>

<form action="{{ route('kader.jadwal.update', $jadwal->id) }}" method="POST" class="bg-white p-6 rounded shadow" id="editForm">
    @csrf
    @method('PUT') {{-- Gunakan method PUT untuk update data --}}

    <label class="block" data-intro="Masukkan nama kegiatan yang ingin diedit.">Nama Kegiatan</label>
    <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan', $jadwal->nama_kegiatan) }}" class="w-full border px-4 py-2 rounded mb-3">

    <label class="block" data-intro="Pilih tanggal pelaksanaan kegiatan.">Tanggal</label>
    <input type="date" name="tanggal" value="{{ old('tanggal', $jadwal->tanggal) }}" class="w-full border px-4 py-2 rounded mb-3">

    <label class="block" data-intro="Tentukan waktu pelaksanaan kegiatan.">Waktu</label>
    <input type="time" name="waktu" value="{{ old('waktu', $jadwal->waktu) }}" class="w-full border px-4 py-2 rounded mb-3">

    <label class="block" data-intro="Masukkan lokasi kegiatan.">Lokasi</label>
    <input type="text" name="lokasi" value="{{ old('lokasi', $jadwal->lokasi) }}" class="w-full border px-4 py-2 rounded mb-6">

    <div class="flex justify-left gap-4">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded" data-intro="Klik di sini untuk menyimpan perubahan.">Simpan Perubahan</button>
        <a href="{{ route('kader.jadwal') }}" class="bg-gray-300 text-black px-4 py-2 rounded" data-intro="Klik di sini jika ingin membatalkan dan kembali ke daftar jadwal.">Batal</a>
    </div>
</form>

{{-- Tambahkan Intro.js --}}
<link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css">
<script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
<script>
    function startTour() {
            introJs().setOptions({
                showStepNumbers: false,
                showBullets: true,
                exitOnOverlayClick: false,
                nextLabel: 'Lanjut',
                prevLabel: 'Kembali',
                doneLabel: 'Selesai',
                showStepNumbers: true
            }).start();
        }
</script>

@endsection
