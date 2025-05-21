@extends('layouts.pasien')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-8">
    <div class="w-full max-w-4xl mx-4 bg-white rounded-lg shadow-xl overflow-hidden">
        <!-- Header Edit Profil -->
        <div class="bg-gradient-to-r from-sky-800 to-blue-400 p-6">
            <h2 class="text-2xl font-semibold text-white">Edit Profil</h2>
        </div>

        <!-- Form Edit Profil -->
        <form id="profileForm" action="{{ route('pasiens.updateProfile', $user->id) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <!-- Data dari tabel users -->
            <div class="mb-4">
                <label class="block text-gray-600 font-medium">Nama:</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full px-4 py-2 border rounded-lg @error('name') border-red-500 @enderror"
                placeholder="Masukkan nama Anda">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-medium">Email:</label>
                <input type="email" name="email" value="{{ $user->pasien->email }}" class="w-full px-4 py-2 border rounded-lg @error('email') border-red-500 @enderror"
                placeholder="Masukkan email Anda">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Section -->
            <div class="mb-6 border-b pb-4">
                <div class="mb-4">
                    <label class="block text-gray-600 font-medium">Password Lama:</label>
                    <div class="relative">
                        <input type="password" name="current_password" id="current_password" 
                               class="w-full px-4 py-2 border rounded-lg @error('current_password') border-red-500 @enderror"
                               placeholder="Masukkan password lama Anda">
                        <button type="button" onclick="togglePassword('current_password')" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-600 font-medium">Password Baru:</label>
                    <div class="relative">
                        <input type="password" name="new_password" id="new_password" 
                               class="w-full px-4 py-2 border rounded-lg @error('new_password') border-red-500 @enderror"
                               placeholder="Masukkan password baru Anda">
                        <button type="button" onclick="togglePassword('new_password')" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                    @error('new_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-600 font-medium">Konfirmasi Password Baru:</label>
                    <div class="relative">
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" 
                               class="w-full px-4 py-2 border rounded-lg"
                               placeholder="Konfirmasi password baru Anda">
                        <button type="button" onclick="togglePassword('new_password_confirmation')" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Data dari tabel pasiens -->
            <div class="mb-4">
                <label class="block text-gray-600 font-medium">NIK:</label>
                <input type="text" name="nik" value="{{ $user->pasien->nik }}" class="w-full px-4 py-2 border rounded-lg @error('nik') border-red-500 @enderror"
                placeholder="Masukkan NIK Anda">
                @error('nik')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-medium">Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" value="{{ $user->pasien->tanggal_lahir }}" class="w-full px-4 py-2 border rounded-lg @error('tanggal_lahir') border-red-500 @enderror"
                placeholder="Masukkan tanggal lahir Anda">
                @error('tanggal_lahir')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-medium">Jenis Kelamin:</label>
                <select name="jenis_kelamin" class="w-full px-4 py-2 border rounded-lg @error('jenis_kelamin') border-red-500 @enderror">
                    <option value="L" {{ $user->pasien->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ $user->pasien->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
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

            <!-- Tombol Simpan Perubahan dan Batal -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('pasiens.profile', $user->pasien) }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-300">
                    Batal
                </a>
                <button type="button" onclick="showConfirmationModal()" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h3 class="text-xl font-semibold mb-4">Konfirmasi Perubahan</h3>
        <p class="mb-6">Anda yakin ingin menyimpan perubahan pada profil ini?</p>
        <div class="flex justify-end space-x-4">
            <button onclick="hideConfirmationModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-300">
                Batal
            </button>
            <button onclick="submitForm()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300">
                Ya, Simpan
            </button>
        </div>
    </div>
</div>

<script>
    function showConfirmationModal() {
        document.getElementById('confirmationModal').classList.remove('hidden');
    }

    function hideConfirmationModal() {
        document.getElementById('confirmationModal').classList.add('hidden');
    }

    function submitForm() {
        document.getElementById('profileForm').submit();
    }

    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const eyeIcon = passwordField.nextElementSibling.querySelector('i');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>

<!-- Tambahkan Font Awesome untuk icon mata -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endsection