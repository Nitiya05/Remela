@extends('layouts.pasien')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-8">
    <div class="w-full max-w-4xl mx-4 bg-white rounded-lg shadow-xl overflow-hidden">
        <!-- Header Profil -->
        <div class="bg-gradient-to-r from-sky-800 to-blue-400 p-6">
            <h2 class="text-2xl font-semibold text-white">Profil Pasien</h2>
        </div>

        <!-- Grid Container -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
            <!-- Kolom Pertama -->
            <div class="space-y-4">
                <!-- Card untuk Nama -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div>
                            <label class="block text-gray-600 font-medium">Nama:</label>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->nama ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card untuk NIK -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                        </svg>
                        <div>
                            <label class="block text-gray-600 font-medium">NIK:</label>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->nik ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card untuk Tanggal Lahir -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <label class="block text-gray-600 font-medium">Tanggal Lahir:</label>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->tanggal_lahir ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card untuk Umur -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <label class="block text-gray-600 font-medium">Umur:</label>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->umur ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card untuk Jenis Kelamin -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <div>
                            <label class="block text-gray-600 font-medium">Jenis Kelamin:</label>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->jenis_kelamin ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card untuk Alamat -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <div>
                            <label class="block text-gray-600 font-medium">Alamat:</label>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kedua -->
            <div class="space-y-4">
                <!-- Card untuk Nomor HP -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <div>
                            <label class="block text-gray-600 font-medium">Nomor HP:</label>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->no_hp ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card untuk Pendidikan Terakhir -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <div>
                            <label class="block text-gray-600 font-medium">Pendidikan Terakhir:</label>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->pendidikan_terakhir ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card untuk Pekerjaan -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <label class="block text-gray-600 font-medium">Pekerjaan:</label>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->pekerjaan ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card untuk Status Kawin -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <label class="block text-gray-600 font-medium">Status Kawin:</label>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->status_kawin ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card untuk Golongan Darah -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <div>
                            <label class="block text-gray-600 font-medium">Golongan Darah:</label>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->golongan_darah ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card untuk Email -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <label class="block text-gray-600 font-medium">Email:</label>
                            <p class="text-lg font-medium text-gray-800">{{ $pasien->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card untuk Kata Sandi -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-100">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <div>
                            <label class="block text-gray-600 font-medium">Kata Sandi:</label>
                            <p class="text-lg font-medium text-gray-800">
                                {{ $pasien->password ? '********' : '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Edit Profil -->
        <div class="p-6 bg-gray-50 border-t border-gray-100">
            <a href="{{ route('pasiens.editProfile', $pasien->id) }}" 
                class="w-full md:w-auto px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300 flex items-center justify-center">
                Edit Profil
            </a>
        </div>
    </div>
</div>
@endsection