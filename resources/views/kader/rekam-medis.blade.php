@extends('layouts.kader')

@section('content')
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 py-6">

        {{-- Header --}}
        <header class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Rekam Medis Lansia</h2>
        </header>

        {{-- Action Buttons and Search --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <button onclick="openModal()"
                class="bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700 transition flex items-center justify-center gap-2 w-full md:w-auto text-base"
                data-intro="Klik di sini untuk menambahkan riwayat rekam medis lansia." data-step="9">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                        clip-rule="evenodd" />
                </svg>
                Tambah Riwayat
            </button>

            <div class="relative w-full md:w-1/2">
                <input type="text" id="search"
                    class="w-full p-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:border-transparent text-base"
                    placeholder="Cari data rekam medis (nama/NIK)..."
                    data-intro="Anda dapat mencari rekam medis lansia berdasarkan nama pasien atau NIK." data-step="10">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <button type="button" id="clearSearch"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 hidden">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Tabel Rekam Medis --}}
        <div class="bg-white shadow-md rounded-lg overflow-hidden"
            data-intro="Ini adalah tabel daftar rekam medis lansia. Di sini Anda dapat melihat informasi rekam medis seperti nama pasien, NIK, tanggal rekam, dan tekanan darah."
            data-step="11">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-base">
                    <thead class="bg-cyan-700 text-white">
                        <tr>
                            <th class="px-4 py-3 text-center font-semibold uppercase tracking-wider">No</th>
                            <th class="px-4 py-3 text-center font-semibold uppercase tracking-wider">Nama</th>
                            <th class="px-4 py-3 text-center font-semibold uppercase tracking-wider">NIK</th>
                            <th class="px-4 py-3 text-center font-semibold uppercase tracking-wider">Tanggal Rekam</th>
                            <th class="px-4 py-3 text-center font-semibold uppercase tracking-wider">Tekanan Darah</th>
                            <th class="px-4 py-3 text-center font-semibold uppercase tracking-wider">Berat Badan</th>
                            <th class="px-4 py-3 text-center font-semibold uppercase tracking-wider">Tinggi Badan</th>
                            <th class="px-4 py-3 text-center font-semibold uppercase tracking-wider">Lingkar Perut</th>
                            <th class="px-4 py-3 text-center font-semibold uppercase tracking-wider">IMT</th>
                            <th class="px-4 py-3 text-center font-semibold uppercase tracking-wider">Gula Darah</th>
                            <th class="px-4 py-3 text-center font-semibold uppercase tracking-wider">Kolesterol</th>
                            <th class="px-4 py-3 text-center font-semibold uppercase tracking-wider">Asam Urat</th>
                            <th class="px-4 py-3 text-center font-semibold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($records as $record)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $record->pasien->nama }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $record->pasien->nik }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $record->tanggal_rekam }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    {{ $record->tekanan_darah_sistolik }}/{{ $record->tekanan_darah_diastolik }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $record->berat_badan }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $record->tinggi_badan }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $record->lingkar_perut }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $record->bmi }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $record->gula_darah }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $record->kolesterol }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $record->asam_urat }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <a href="{{ route('rekam-medis-lansia.show', $record->id) }}"
                                            class="bg-blue-500 text-white px-3 py-1 rounded-lg flex items-center justify-center gap-1 hover:bg-blue-600 transition text-sm"
                                            data-intro="Tombol ini digunakan untuk melihat detail rekam medis lansia."
                                            data-step="12">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Lihat
                                        </a>
                                        <a href="{{ route('rekam-medis-lansia.edit', $record->id) }}"
                                            class="bg-yellow-500 text-white px-3 py-1 rounded-lg flex items-center justify-center gap-1 hover:bg-yellow-600 transition text-sm"
                                            data-intro="Tombol ini digunakan untuk mengedit data rekam medis lansia."
                                            data-step="13">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>

                                        <button
                                            onclick="openDeleteModal('{{ route('rekam-medis-lansia.destroy', $record->id) }}')"
                                            class="bg-red-500 text-white px-3 py-1 rounded-lg flex items-center justify-center gap-1 hover:bg-red-600 transition text-sm"
                                            data-intro="Tombol ini digunakan untuk menghapus rekam medis lansia."
                                            data-step="14">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Pagination --}}
                <div class="mt-4 px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    <div class="flex-1 flex justify-between sm:hidden">
                        @if ($records->onFirstPage())
                            <span
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white">
                                Sebelumnya
                            </span>
                        @else
                            <a href="{{ $records->previousPageUrl() }}"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Sebelumnya
                            </a>
                        @endif

                        @if ($records->hasMorePages())
                            <a href="{{ $records->nextPageUrl() }}"
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Selanjutnya
                            </a>
                        @else
                            <span
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white">
                                Selanjutnya
                            </span>
                        @endif
                    </div>

                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Menampilkan
                                <span class="font-medium">{{ $records->firstItem() }}</span>
                                sampai
                                <span class="font-medium">{{ $records->lastItem() }}</span>
                                dari
                                <span class="font-medium">{{ $records->total() }}</span>
                                rekam medis
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                aria-label="Pagination">
                                @if ($records->onFirstPage())
                                    <span
                                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-300">
                                        <span class="sr-only">Previous</span>
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                @else
                                    <a href="{{ $records->previousPageUrl() }}"
                                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Previous</span>
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @endif

                                @foreach ($records->getUrlRange(1, $records->lastPage()) as $page => $url)
                                    @if ($page == $records->currentPage())
                                        <span aria-current="page"
                                            class="z-10 bg-cyan-600 border-cyan-600 text-white relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}"
                                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                @if ($records->hasMorePages())
                                    <a href="{{ $records->nextPageUrl() }}"
                                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Next</span>
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @else
                                    <span
                                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-300">
                                        <span class="sr-only">Next</span>
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                @endif
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Tambah Riwayat --}}
        <div id="modalTambahRiwayat"
            class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-hidden text-base">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Pilih Pasien</h2>
                        <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Search --}}
                    <div class="relative mb-4">
                        <input type="text" id="searchPasien"
                            class="w-full p-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-600 text-base"
                            placeholder="Cari pasien...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>

                    {{-- Tabel Pasien --}}
                    <div class="overflow-auto" style="max-height: calc(90vh - 180px)">
                        <table class="min-w-full divide-y divide-gray-200 text-base">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold uppercase tracking-wider">No</th>
                                    <th class="px-4 py-3 text-left font-semibold uppercase tracking-wider">Nama</th>
                                    <th class="px-4 py-3 text-left font-semibold uppercase tracking-wider">NIK</th>
                                    <th class="px-4 py-3 text-left font-semibold uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($patient as $patient)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap">{{ $patient->nama }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap">{{ $patient->nik }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <a href="{{ route('rekam-medis-lansia.create', ['patient_id' => $patient->id]) }}"
                                                class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition flex items-center gap-2 text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                                Pilih
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Hapus Riwayat --}}
        <div id="deleteModal"
            class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md text-base">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Konfirmasi Hapus</h2>
                        <button onclick="closeDeleteModal()" class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <p class="mb-6 text-gray-600">Apakah Anda yakin ingin menghapus rekam medis ini?</p>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="closeDeleteModal()"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition text-sm">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm">
                                Hapus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script --}}
    <script>
        // Function to open the modal for adding a new record
        function openModal() {
            document.getElementById('modalTambahRiwayat').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        // Function to close the modal for adding a new record
        function closeModal() {
            document.getElementById('modalTambahRiwayat').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Function to open the delete confirmation modal
        function openDeleteModal(deleteUrl) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteForm').action = deleteUrl;
            document.body.classList.add('overflow-hidden');
        }

        // Function to close the delete confirmation modal
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Live search for main table
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const clearButton = document.getElementById('clearSearch');

            // Toggle clear button
            searchInput.addEventListener('input', function() {
                clearButton.classList.toggle('hidden', this.value === '');

                // Filter table rows
                const searchTerm = this.value.toLowerCase();
                document.querySelectorAll('tbody tr').forEach(row => {
                    const nama = row.children[1].textContent.toLowerCase();
                    const nik = row.children[2].textContent.toLowerCase();
                    row.style.display = (nama.includes(searchTerm) || nik.includes(searchTerm)) ?
                        '' : 'none';
                });
            });

            // Clear search
            clearButton.addEventListener('click', function() {
                searchInput.value = '';
                searchInput.focus();
                clearButton.classList.add('hidden');
                document.querySelectorAll('tbody tr').forEach(row => {
                    row.style.display = '';
                });
            });

            // Search in patient modal
            const searchPasien = document.getElementById('searchPasien');
            if (searchPasien) {
                searchPasien.addEventListener('input', function() {
                    const filter = this.value.toLowerCase();
                    document.querySelectorAll('#modalTambahRiwayat tbody tr').forEach(row => {
                        const nama = row.children[1].textContent.toLowerCase();
                        const nik = row.children[2].textContent.toLowerCase();
                        row.style.display = (nama.includes(filter) || nik.includes(filter)) ? '' :
                            'none';
                    });
                });
            }
        });
    </script>

    <!-- Intro.js -->
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
