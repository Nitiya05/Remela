@extends('layouts.kader')

@section('content')

    <header class="bg-white shadow p-5 rounded-lg">
        <h2 class="text-2xl font-bold">Tambahkan Data Pasien</h2>
    </header>

    <div class="container mx-auto mt-8 p-5 bg-white rounded-lg shadow-md ">
    <form action="{{ route('pasiens.store') }}" method="POST">
        @csrf
        <div class="space-y-6">
            <!-- Nama Pasien -->
            <div class="mb-4">
                <label for="nama" class="block text-xl font-medium text-gray-700">Nama Pasien</label>
                <input type="text" class="form-input mt-2 block w-full p-4 text-xl rounded-lg border-2 border-gray-400 focus:ring-indigo-500 focus:border-indigo-500" id="nama" name="nama" value="{{ old('nama') }}" required>
                @error('nama')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- NIK -->
            <div class="mb-4">
                <label for="nik" class="block text-xl font-medium text-gray-700">NIK</label>
                <input type="text" class="form-input mt-2 block w-full p-4 text-xl rounded-lg border-2 border-gray-400 focus:ring-indigo-500 focus:border-indigo-500" id="nik" name="nik" value="{{ old('nik') }}" required>
                @error('nik')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alamat -->
            <div class="mb-4">
                <label for="alamat" class="block text-xl font-medium text-gray-700">Alamat</label>
                <input type="text" class="form-input mt-2 block w-full p-4 text-xl rounded-lg border-2 border-gray-400 focus:ring-indigo-500 focus:border-indigo-500" id="alamat" name="alamat" value="{{ old('alamat') }}" required>
                @error('alamat')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-4">
                <label for="tanggal_lahir" class="block text-xl font-medium text-gray-700">Tanggal Lahir</label>
                <input type="date" class="form-input mt-2 block w-full p-4 text-xl rounded-lg border-2 border-gray-400 focus:ring-indigo-500 focus:border-indigo-500" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                @error('tanggal_lahir')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Kelamin -->
            <div class="mb-4">
                <label for="jenis_kelamin" class="block text-xl font-medium text-gray-700">Jenis Kelamin</label>
                <select class="form-select mt-2 block w-full p-4 text-xl rounded-lg border-2 border-gray-400 focus:ring-indigo-500 focus:border-indigo-500" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pendidikan Terakhir -->
            <div class="mb-4">
                <label for="pendidikan_terakhir" class="block text-xl font-medium text-gray-700">Pendidikan Terakhir</label>
                <input type="text" class="form-input mt-2 block w-full p-4 text-xl rounded-lg border-2 border-gray-400 focus:ring-indigo-500 focus:border-indigo-500" id="pendidikan_terakhir" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir') }}">
            </div>

            <!-- Pekerjaan -->
            <div class="mb-4">
                <label for="pekerjaan" class="block text-xl font-medium text-gray-700">Pekerjaan</label>
                <input type="text" class="form-input mt-2 block w-full p-4 text-xl rounded-lg border-2 border-gray-400 focus:ring-indigo-500 focus:border-indigo-500" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}">
            </div>

            <!-- Status Kawin -->
            <div class="mb-4">
                <label for="status_kawin" class="block text-xl font-medium text-gray-700">Status Kawin</label>
                <select class="form-select mt-2 block w-full p-4 text-xl rounded-lg border-2 border-gray-400 focus:ring-indigo-500 focus:border-indigo-500" id="status_kawin" name="status_kawin" required>
                    <option value="Belum Kawin" {{ old('status_kawin') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                    <option value="Kawin" {{ old('status_kawin') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                    <option value="Cerai" {{ old('status_kawin') == 'Cerai' ? 'selected' : '' }}>Cerai</option>
                </select>
            </div>

            <!-- Golongan Darah -->
            <div class="mb-4">
                <label for="golongan_darah" class="block text-xl font-medium text-gray-700">Golongan Darah</label>
                <select class="form-select mt-2 block w-full p-4 text-xl rounded-lg border-2 border-gray-400 focus:ring-indigo-500 focus:border-indigo-500" id="golongan_darah" name="golongan_darah" required>
                    <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                    <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                    <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                    <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                </select>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-xl font-medium text-gray-700">Email</label>
                <input type="email" class="form-input mt-2 block w-full p-4 text-xl rounded-lg border-2 border-gray-400 focus:ring-indigo-500 focus:border-indigo-500" id="email" name="email" value="{{ old('email') }}">
            </div>

            <!-- Nomor HP -->
            <div class="mb-4">
                <label for="no_hp" class="block text-xl font-medium text-gray-700">Nomor HP</label>
                <input type="text" class="form-input mt-2 block w-full p-4 text-xl rounded-lg border-2 border-gray-400 focus:ring-indigo-500 focus:border-indigo-500" id="no_hp" name="no_hp" value="{{ old('no_hp') }}">
            </div>

            <!-- Button Submit -->
            <div class="flex justify-center">
                <button type="submit" class="bg-indigo-600 text-white text-xl py-3 px-8 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">Simpan</button>
            </div>
        </div>
    </form>
</div>
@endsection
