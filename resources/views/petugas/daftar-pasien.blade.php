@extends('layouts.petugas')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Daftar Pasien</h2>

    <!-- Form Pencarian -->
    <form action="{{ route('petugas.daftarPasien') }}" method="GET" class="mb-6">
        <div class="flex items-center">
            <input 
                type="text" 
                name="search" 
                placeholder="Cari pasien..." 
                value="{{ request('search') }}" 
                class="w-full px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-cyan-800"
                data-intro="Kotak pencarian. Anda bisa mencari pasien berdasarkan nama atau NIK."
                data-step="7">
            <button 
                type="submit" 
                class="bg-cyan-800 text-white px-6 py-2 hover:bg-cyan-900 transition duration-150 ease-in-out"
             data-intro="Tombol Cari. Klik untuk memulai pencarian." data-step="8">

                Cari
            </button>
            @if(request('search'))
                <a 
                    href="{{ route('petugas.daftarPasien') }}" 
                    class="bg-gray-500 text-white px-6 py-2 rounded-r-lg hover:bg-gray-600 transition duration-150 ease-in-out"
                data-intro="Tombol Reset. Klik untuk menghapus kata kunci pencarian." data-step="9">
                    Reset
                </a>
            @endif
            @if(request('search') && $pasiens->isEmpty())
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
        <p>Hasil pencarian untuk <strong>"{{ request('search') }}"</strong> tidak ditemukan.</p>
    </div>
@endif
        </div>
    </form>

    <!-- Tabel Data Pasien -->
    <div class="bg-white p-6 rounded-lg shadow-lg overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300 rounded-lg"
        data-intro="Ini adalah tabel daftar pasien. Di sini Anda dapat melihat informasi pasien seperti nama, NIK, umur, alamat, dan jenis kelamin."
        data-step="10">
            <thead class="bg-cyan-800 rounded-lg">
                <tr>
                    <th class="border p-3 text-white">No</th>
                    <th class="border p-3 text-white">Nama</th>
                    <th class="border p-3 text-white">NIK</th>
                    <th class="border p-3 text-white">Umur</th>
                    <th class="border p-3 text-white">Alamat</th>
                    <th class="border p-3 text-white">Jenis Kelamin</th>
                    <th class="border p-3 text-white">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pasiens as $index => $pasien)
                <tr class="hover:bg-gray-100">
                    <td class="border p-3">{{ $index + $pasiens->firstItem() }}</td>
                    <td class="border p-3">{{ $pasien->nama }}</td>
                    <td class="border p-3">{{ $pasien->nik }}</td>
                    <td class="border p-3">{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->age }} tahun</td>
                    <td class="border p-3">{{ $pasien->alamat }}</td>
                    <td class="border p-3">{{ $pasien->jenis_kelamin }}</td>
                    <td class="border p-3">
                        <a href="{{ route('petugas.rekamMedis.show', $pasien->id) }}" 
                            class="bg-blue-500 text-white px-3 py-1 rounded inline-block hover:bg-blue-600"
                            data-intro="Tombol Lihat Rekam Medis. Klik untuk melihat rekam medis pasien."
                            data-step="11">
                            Lihat Rekam Medis
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center border p-4">Tidak ada data pasien.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $pasiens->links() }}
        </div>
    </div>
</div>

<!-- Script Intro.js -->
<script src="https://cdn.jsdelivr.net/npm/intro.js"></script>

<script>
    // Fungsi untuk memulai tur
    function startTour() {
        introJs().setOptions({
            nextLabel: 'Lanjut',
            prevLabel: 'Kembali',
            doneLabel: 'Selesai',
            exitOnOverlayClick: false,
            showStepNumbers: true,
            showBullets: true,
        }).start();
    }

    // Jalankan tur saat tombol "Mulai Tur" diklik
    document.getElementById('start-tour-button').addEventListener('click', function() {
        startTour();
    });
</script>
@endsection
