@extends('layouts.petugas')

@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-3xl mx-auto">
            <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Edit Profil petugas</h2>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('petugas.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama') border-red-500 @enderror"
                        value="{{ old('nama', $petugas->nama) }}" required>
                    @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" name="email" id="email"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                        value="{{ old('email', $petugas->email) }}" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor HP -->
                <div class="mb-4">
                    <label for="no_hp" class="block text-gray-700 font-medium mb-2">Nomor HP</label>
                    <input type="tel" name="no_hp" id="no_hp"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('no_hp') border-red-500 @enderror"
                        value="{{ old('no_hp', $petugas->no_hp) }}">
                    @error('no_hp')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Section -->
                <div class="border-t pt-4 mt-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Ganti Password</h3>

                    <!-- Password Lama -->
                    <div class="mb-4 relative">
                        <label for="current_password" class="block text-gray-700 font-medium mb-2">Password Saat Ini</label>
                        <div class="relative">
                            <input type="password" name="current_password" id="current_password"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Masukkan password saat ini">
                            <button type="button" onclick="togglePassword('current_password', 'eyeIcon1')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <i id="eyeIcon1" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Password Baru -->
                    <div class="mb-4 relative">
                        <label for="password" class="block text-gray-700 font-medium mb-2">Password Baru</label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Masukkan password baru">
                            <button type="button" onclick="togglePassword('password', 'eyeIcon2')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <i id="eyeIcon2" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div class="mb-6 relative">
                        <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Konfirmasi Password
                            Baru</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Masukkan konfirmasi password baru">
                            <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon3')"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <i id="eyeIcon3" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('petugas.dashboard') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-6 rounded-lg transition duration-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition duration-200">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Load FontAwesome dari CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>

@endsection
