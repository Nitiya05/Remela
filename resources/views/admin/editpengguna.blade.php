@extends('layouts.admin')

@section('content')
<!-- Tambahkan link FontAwesome di head -->
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

<div class="container mx-auto mt-6 px-4">
    <!-- Judul Halaman -->
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Pengguna</h2>

    <!-- Form Edit Pengguna -->
    <form action="{{ route('admin.pengguna.update', $pengguna->id) }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        @method('PUT')

        <!-- Input Nama -->
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-user text-gray-500"></i>
                </div>
                <input type="text" name="name" id="name" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300" value="{{ old('name', $pengguna->name) }}" required>
            </div>
            @error('name')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Email -->
        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-500"></i>
                </div>
                <input type="email" name="email" id="email" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300" value="{{ old('email', $pengguna->email) }}" required>
            </div>
            @error('email')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Nomor HP -->
        <div class="mb-6">
            <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">Nomor HP</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-phone text-gray-500"></i>
                </div>
                <input type="text" name="no_hp" id="no_hp" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300" value="{{ old('no_hp', $pengguna->no_hp) }}">
            </div>
            @error('no_hp')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Role -->
        <div class="mb-6">
            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-users-cog text-gray-500"></i>
                </div>
                <select name="role" id="role" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 appearance-none" required>
                    <option value="petugas" {{ old('role', $pengguna->role) == 'petugas' ? 'selected' : '' }}>Petugas</option>
                    <option value="kader" {{ old('role', $pengguna->role) == 'kader' ? 'selected' : '' }}>Kader</option>
                </select>
            </div>
            @error('role')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Input Password (Opsional) -->
        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru (Opsional)</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-500"></i>
                </div>
                <input type="password" name="password" id="password" class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300">
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePasswordVisibility('password')">
                    <i class="fas fa-eye text-gray-500 hover:text-gray-700 cursor-pointer"></i>
                </button>
            </div>
            @error('password')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Kembali dan Submit -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.manajemenpengguna') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md shadow-md transition duration-300 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md shadow-md transition duration-300 flex items-center">
                <i class="fas fa-save mr-2"></i> Perbarui
            </button>
        </div>
    </form>
</div>

<!-- Script untuk Toggle Password Visibility -->
<script>
    function togglePasswordVisibility(inputId) {
        const input = document.getElementById(inputId);
        const icon = input.nextElementSibling.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
@endsection