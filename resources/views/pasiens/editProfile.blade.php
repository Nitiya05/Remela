@extends('layouts.pasien')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-8">
    <div class="w-full max-w-4xl mx-4 bg-white rounded-lg shadow-xl overflow-hidden">
        <!-- Header Edit Profil -->
        <div class="bg-gradient-to-r from-sky-800 to-blue-400 p-6">
            <h2 class="text-2xl font-semibold text-white">Edit Profil</h2>
        </div>

        <!-- Form Edit Profil -->
        <form action="{{ route('pasiens.updateProfile', $user->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <!-- Data dari tabel users -->
            <div class="mb-4">
                <label class="block text-gray-600 font-medium">Nama:</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full px-4 py-2 border rounded-lg @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-medium">Email:</label>
                <input type="email" name="email" value="{{ $user->pasien->email }}" class="w-full px-4 py-2 border rounded-lg @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-medium">Password Lama:</label>
                <input type="password" name="current_password" class="w-full px-4 py-2 border rounded-lg @error('current_password') border-red-500 @enderror">
                @error('current_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-medium">Password Baru:</label>
                <input type="password" name="new_password" class="w-full px-4 py-2 border rounded-lg @error('new_password') border-red-500 @enderror">
                @error('new_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-600 font-medium">Konfirmasi Password Baru:</label>
                <input type="password" name="new_password_confirmation" class="w-full px-4 py-2 border rounded-lg">
            </div>

            <!-- Data dari tabel pasiens -->
            <div class="mb-4">
                <label class="block text-gray-600 font-medium">NIK:</label>
                <input type="text" name="nik" value="{{ $user->pasien->nik }}" class="w-full px-4 py-2 border rounded-lg @error('nik') border-red-500 @enderror">
                @error('nik')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-medium">Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" value="{{ $user->pasien->tanggal_lahir }}" class="w-full px-4 py-2 border rounded-lg @error('tanggal_lahir') border-red-500 @enderror">
                @error('tanggal_lahir')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-medium">Jenis Kelamin:</label>
                <select name="jenis_kelamin" class="w-full px-4 py-2 border rounded-lg @error('jenis_kelamin') border-red-500 @enderror">
                    <option value="Laki-laki" {{ $user->pasien->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ $user->pasien->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-medium">Alamat:</label>
                <textarea name="alamat" class="w-full px-4 py-2 border rounded-lg @error('alamat') border-red-500 @enderror">{{ $user->pasien->alamat }}</textarea>
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Simpan Perubahan -->
            <div>
                <button type="submit" class="w-full md:w-auto px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection