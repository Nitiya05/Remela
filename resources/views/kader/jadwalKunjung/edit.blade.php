@extends('layouts.kader')

@section('content')

<h2 class="text-2xl font-bold mb-4">Edit Jadwal</h2>

<form action="{{ route('kader.jadwal.update', $jadwal->id) }}" method="POST" class="bg-white p-6 rounded shadow">
    @csrf
    @method('PUT') {{-- Gunakan method PUT untuk update data --}}

    <label class="block">Nama Kegiatan</label>
    <input type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan', $jadwal->nama_kegiatan) }}" class="w-full border px-4 py-2 rounded mb-3">

    <label class="block">Tanggal</label>
    <input type="date" name="tanggal" value="{{ old('tanggal', $jadwal->tanggal) }}" class="w-full border px-4 py-2 rounded mb-3">

    <label class="block">Waktu</label>
    <input type="time" name="waktu" value="{{ old('waktu', $jadwal->waktu) }}" class="w-full border px-4 py-2 rounded mb-3">

    <label class="block">Lokasi</label>
    <input type="text" name="lokasi" value="{{ old('lokasi', $jadwal->lokasi) }}" class="w-full border px-4 py-2 rounded mb-3">

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
</form>

@endsection
