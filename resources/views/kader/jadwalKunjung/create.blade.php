@extends('layouts.kader')

@section('content')

<form action="{{ route('kader.jadwal.store') }}" method="POST" class="bg-white p-6 rounded shadow" id="formTambahJadwal">
    @csrf

    <label class="block" data-intro="Isi dengan nama kegiatan yang akan ditambahkan.">Nama Kegiatan</label>
    <input type="text" name="nama_kegiatan" class="w-full border px-4 py-2 rounded mb-3"
        placeholder="Masukkan Nama Kegiatan" required>

    <label class="block" data-intro="Pilih tanggal pelaksanaan kegiatan.">Tanggal</label>
    <input type="date" name="tanggal" class="w-full border px-4 py-2 rounded mb-3">

    <label class="block" data-intro="Tentukan waktu kegiatan.">Waktu</label>
    <input type="time" name="waktu" class="w-full border px-4 py-2 rounded mb-3">

    <label class="block" data-intro="Masukkan lokasi kegiatan.">Lokasi</label>
    <input type="text" name="lokasi" class="w-full border px-4 py-2 rounded mb-3"
        placeholder="Masukkan Lokasi Kegiatan" required>

    <div class="flex gap-4 mt-5">
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded transition duration-200"
            data-intro="Klik untuk menyimpan jadwal.">
            Simpan
        </button>
        <a href="{{ route('kader.jadwal') }}"
            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded transition duration-200"
            data-intro="Klik untuk membatalkan dan kembali ke daftar jadwal.">
            Batal
        </a>
    </div>
</form>

{{-- Tambahkan Intro.js --}}
<link rel="stylesheet" href="https://unpkg.com/intro.js/minified/introjs.min.css">
<script src="https://unpkg.com/intro.js/minified/intro.min.js"></script>
<script>
    function startIntro() {
        introJs().setOptions({
            nextLabel: 'Lanjut',
            prevLabel: 'Kembali',
            doneLabel: 'Selesai',
            skipLabel: 'Lewati',
        }).start();
    }
</script>

@endsection