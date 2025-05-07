@extends('layouts.kader')

@section('content')

<h2 class="text-2xl font-bold mb-4">Tambah Jadwal</h2>

<form action="{{ route('kader.jadwal.store') }}" method="POST" class="bg-white p-6 rounded shadow">
    @csrf
    <label class="block">Nama Kegiatan</label>
    <input type="text" name="nama_kegiatan" class="w-full border px-4 py-2 rounded mb-3">

    <label class="block">Tanggal</label>
    <input type="date" name="tanggal" class="w-full border px-4 py-2 rounded mb-3">

    <label class="block">Waktu</label>
    <input type="time" name="waktu" class="w-full border px-4 py-2 rounded mb-3">

    <label class="block">Lokasi</label>
    <input type="text" name="lokasi" class="w-full border px-4 py-2 rounded mb-3">

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
</form>

@endsection
