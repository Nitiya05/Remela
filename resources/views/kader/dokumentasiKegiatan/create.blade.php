@extends('layouts.kader')

@section('content')
    <h2 class="text-2xl font-bold">Tambah Dokumentasi Kegiatan</h2>

    <form action="{{ route('kader.dokumentasi.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf

        <div class="mb-4">
            <label for="nama_kegiatan" class="block text-sm font-semibold text-gray-700">Nama Kegiatan</label>
            <input type="text" id="nama_kegiatan" name="nama_kegiatan" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-sm font-semibold text-gray-700">Deskripsi Kegiatan</label>
            <textarea id="deskripsi" name="deskripsi" class="w-full p-2 border border-gray-300 rounded" required></textarea>
        </div>

        <div class="mb-4">
            <label for="waktu" class="block text-sm font-semibold text-gray-700">Waktu Kegiatan</label>
            <input type="datetime-local" id="waktu" name="waktu" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label for="lokasi" class="block text-sm font-semibold text-gray-700">Lokasi Kegiatan</label>
            <input type="text" id="lokasi" name="lokasi" class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label for="foto" class="block text-sm font-semibold text-gray-700">Foto Kegiatan</label>
            <input type="file" id="foto" name="foto[]" class="w-full p-2 border border-gray-300 rounded" multiple required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Dokumentasi</button>
    </form>
@endsection
