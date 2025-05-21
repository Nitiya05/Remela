@extends('layouts.kader')

@section('title', 'Detail Pasien')

@section('content')

    <!-- Header -->
    <header class="bg-white shadow p-5 rounded-lg">
        <h2 class="text-2xl font-bold">Detail Pasien</h2>
    </header>

    <div class="mt-6 mb-20">
        <!-- Card untuk Detail Pasien -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-4">Informasi Umum</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->nama ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">NIK</p>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->nik ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Alamat</p>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->alamat ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Pendidikan</p>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->pendidikan_terakhir ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->status_kawin ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->email ?: '-' }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500 mt-10">Umur</p>
                            <p class="text-lg font-medium text-gray-800">
                                {{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->age . ' tahun' : '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Lahir</p>
                            <p class="text-lg font-medium text-gray-800">
                                {{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d M Y') : '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Jenis Kelamin</p>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->jenis_kelamin ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Golongan Darah</p>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->golongan_darah ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Pekerjaan</p>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->pekerjaan ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">No Hp</p>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->no_hp ?: '-' }}</p>
                        </div>
                    </div>
                </div>


                <!-- Tombol Aksi -->
                <div class="mt-6 flex space-x-4">
                    <a href="{{ route('kader.dataPasien') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-300">
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Modal Konfirmasi Hapus -->
        <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50"
            style="display: none;">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h3 class="text-lg font-semibold text-center">Konfirmasi Hapus</h3>
                <p class="mt-2 text-center text-gray-600">Apakah Anda yakin ingin menghapus data ini?</p>
                <form id="deleteForm" method="POST">
                    @csrf @method('DELETE')
                    <div class="flex justify-center space-x-4 mt-6">
                        <button type="button" onclick="closeModal()"
                            class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-300">Batal</button>
                        <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300">Hapus</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- JavaScript untuk Modal -->
        <script>
            function openModal(deleteUrl) {
                document.getElementById("deleteForm").action = deleteUrl;
                document.getElementById("deleteModal").classList.remove("hidden");
            }

            function closeModal() {
                document.getElementById("deleteModal").classList.add("hidden");
            }
        </script>
    @endsection
