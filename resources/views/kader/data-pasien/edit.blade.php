@extends('layouts.kader')

@section('content')
    <div class="container mx-auto p-6">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-6">Edit Pasien</h2>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('kader.data-pasien.update', $pasien->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Nama</label>
                    <input type="text" name="nama" value="{{ $pasien->nama }}"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- NIK -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">NIK</label>
                    <input type="text" name="nik" value="{{ $pasien->nik }}"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Alamat -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Alamat</label>
                    <input type="text" name="alamat" value="{{ $pasien->alamat }}"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Tanggal Lahir -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ $pasien->tanggal_lahir }}"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Jenis Kelamin -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Jenis Kelamin</label>
                    <select name="jenis_kelamin"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="L" {{ $pasien->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki
                        </option>
                        <option value="P" {{ $pasien->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan
                        </option>
                    </select>
                </div>

                <!-- Pendidikan Terakhir -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Pendidikan Terakhir</label>
                    <input type="text" name="pendidikan_terakhir" value="{{ $pasien->pendidikan_terakhir }}"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Pekerjaan -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="{{ $pasien->pekerjaan }}"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Status Kawin -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Status Kawin</label>
                    <select name="status_kawin"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Belum Kawin" {{ $pasien->status_kawin == 'Belum Kawin' ? 'selected' : '' }}>Belum
                            Kawin</option>
                        <option value="Kawin" {{ $pasien->status_kawin == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                        <option value="Cerai" {{ $pasien->status_kawin == 'Cerai' ? 'selected' : '' }}>Cerai</option>
                    </select>
                </div>

                <!-- Golongan Darah -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Golongan Darah</label>
                    <select name="golongan_darah"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="A" {{ $pasien->golongan_darah == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ $pasien->golongan_darah == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ $pasien->golongan_darah == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ $pasien->golongan_darah == 'O' ? 'selected' : '' }}>O</option>
                    </select>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" name="email" value="{{ $pasien->email }}"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- No HP -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">No HP</label>
                    <input type="text" name="no_hp" value="{{ $pasien->no_hp }}"
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Password Reset Section -->
                <div class="mb-6 p-4 border border-yellow-200 bg-yellow-50 rounded-lg">
                    <h3 class="text-lg font-semibold text-yellow-800 mb-2">Reset Password</h3>
                    <p class="text-sm text-yellow-700 mb-3">Reset password user ke default (NIK pasien)</p>

                    @if ($pasien->user)
                        <div class="flex items-center">
                            <input type="checkbox" id="confirmReset" name="confirmReset" value="1" class="mr-2">
                            <label for="confirmReset" class="text-sm text-gray-700">Ya, saya ingin reset password</label>
                        </div>

                        <div id="passwordFields" class="mt-3 hidden">
                            <div class="mb-2">
                                <label class="block text-gray-700 text-sm font-medium mb-1">Password Baru</label>
                                <input type="text" id="newPassword" value="{{ $pasien->nik }}"
                                    class="w-full p-2 border border-gray-300 rounded-lg bg-gray-100" readonly>
                            </div>
                            <p class="text-xs text-gray-500">Password akan direset ke NIK pasien ({{ $pasien->nik }})</p>
                        </div>
                    @else
                        <p class="text-red-500 text-sm">Akun user belum terhubung dengan pasien ini</p>
                    @endif
                </div>

                <!-- Tombol Simpan dan Batal -->
                <div class="mt-6 flex justify-end space-x-4">
                    <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-300">
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('kader.dataPasien') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-300">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle password reset fields
        document.getElementById('confirmReset').addEventListener('change', function() {
            const passwordFields = document.getElementById('passwordFields');
            if (this.checked) {
                passwordFields.classList.remove('hidden');
            } else {
                passwordFields.classList.add('hidden');
            }
        });
    </script>
@endsection
