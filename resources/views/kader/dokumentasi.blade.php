@extends('layouts.kader')

@section('content')
<div>
    <h2 class="bg-white shadow p-5 rounded-lg text-2xl font-bold">Daftar Dokumentasi Kegiatan</h2>

    <div>
        <a href="{{ route('kader.dokumentasi.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mt-4 inline-block"
        data-intro="Tombol ini digunakan untuk menambahkan dokumentasi kegiatan baru." data-step="9">
            + Tambah Dokumentasi </a>    
    </div>

    <div class="mt-4 bg-cyan-700 shadow-md rounded-lg overflow-x-auto" x-data="{ showModal: false, deleteUrl: '', showFullDetails: false, detailItem: {} }">
        <table id="patientRecordsTable" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-lightblue font-bold text-white">
                <tr>
                    <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Nama Kegiatan</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">Waktu</th>
                        <th class="px-6 py-3">Lokasi</th>
                        <th class="px-6 py-3">Foto</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($dokumentasi as $key => $item)
                    <tr class="hover:bg-gray-100">
                        <td class="px-6 py-3">{{ $key + 1 }}</td>
                            <td class="px-6 py-3">{{ $item->nama_kegiatan }}</td>
                            <td class="px-6 py-3 text-sm truncate max-w-xs">{{ $item->deskripsi }}</td>
                            <td class="px-6 py-3">{{ \Carbon\Carbon::parse($item->waktu)->format('d M Y H:i') }}</td>
                            <td class="px-6 py-3">{{ $item->lokasi }}</td>
                            <td class="px-6 py-3">
                                <div class="flex flex-wrap gap-2">
                                    @if ($item->fotos->count() > 0)
                                        <img src="{{ asset('storage/' . $item->fotos->first()->path) }}" alt="Foto" class="w-16 h-16 object-cover rounded-lg shadow">
                                        @if ($item->fotos->count() > 1)
                                            <span class="text-xs text-gray-500">{{ $item->fotos->count() }} foto lainnya</span>
                                        @endif
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-3 flex justify-center items-center space-x-2 h-full">
                                <!-- Tombol untuk melihat detail -->
                                <button @click="showFullDetails = true; detailItem = {{ json_encode($item) }}" 
                                    class="bg-blue-500 text-white px-3 py-1 rounded-lg shadow hover:bg-blue-600"
                                    data-intro="Tombol ini digunakan untuk melihat detail dokumentasi kegiatan."
                                    data-step="10">
                                    Lihat
                                </button>
                                
                                <a href="{{ route('kader.dokumentasi.edit', $item->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg shadow hover:bg-yellow-600"
                                    data-intro="Tombol ini digunakan untuk mengedit data dokumentasi kegiatan."
                                    data-step="11">
                                    Edit</a>

                                <!-- Tombol untuk memunculkan modal hapus -->
                                <button @click="showModal = true; deleteUrl = '{{ route('kader.dokumentasi.destroy', $item->id) }}'" 
                                    class="bg-red-500 text-white px-3 py-1 rounded-lg shadow hover:bg-red-600"
                                    data-intro="Tombol ini digunakan untuk menghapus data dokumentasi kegiatan."
                                    data-step="12">
                                    Hapus
                                </button>

                            </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal Konfirmasi Hapus -->
        <div x-show="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-[400px] md:w-[500px]">
                <h2 class="text-xl font-bold mb-4">Konfirmasi Hapus</h2>
                <p>Apakah Anda yakin ingin menghapus dokumentasi ini?</p>
                <div class="mt-4 flex justify-end space-x-4">
                    <button @click="showModal = false" class="px-4 py-2 bg-gray-500 text-white rounded-lg">Batal</button>
                    <form :action="deleteUrl" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg">Hapus</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Lihat Detail -->
        <div x-show="showFullDetails" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-[500px] md:w-[700px] overflow-auto max-h-[90vh]">
                <h2 class="text-2xl font-bold mb-4 text-center" x-text="detailItem.nama_kegiatan"></h2>
                <p class="mb-4 text-gray-700" x-text="detailItem.deskripsi"></p>
                <p class="mb-4 text-blue-800">Waktu: <span x-text="new Date(detailItem.waktu).toLocaleString('id-ID')"></span></p>
                <p class="mb-4 text-gray-700">Lokasi: <span x-text="detailItem.lokasi"></span></p>
                <div class="flex flex-wrap gap-2">
                    <template x-for="foto in detailItem.fotos">
                        <img :src="'{{ asset('storage/') }}/' + foto.path" alt="Foto" class="w-32 h-32 object-cover rounded-lg shadow">
                    </template>
                </div>
                <div class="mt-4 flex justify-end">
                    <button @click="showFullDetails = false" class="px-4 py-2 bg-red-500 text-white rounded-lg">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan Intro.js untuk Panduan Interaktif -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.1.0/introjs.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.1.0/intro.min.js"></script>

<script>
    function startTour() {
        introJs().setOptions({
            showStepNumbers: false,
            showBullets: true,
            exitOnOverlayClick: false,
            nextLabel: 'Lanjut',
            prevLabel: 'Kembali',
            doneLabel: 'Selesai',
            showStepNumbers: true
        }).start();
    }
</script>

@endsection
