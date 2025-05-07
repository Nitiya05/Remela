@extends('layouts.kader')

@section('content')
    <!-- Mobile Menu Button - Adjusted size -->
    <button onclick="toggleSidebar()" class="md:hidden bg-blue-600 text-white p-2 rounded-lg mb-4 text-base">
        ☰ Menu
    </button>

    <!-- Header with adjusted text size -->
    <header class="bg-white shadow p-4 rounded-lg mb-4">
        <h1 class="text-xl md:text-2xl font-bold text-gray-800">Data Pasien Lansia</h1>
    </header>

    <section class="space-y-4">
        <!-- Add Data Button - Slightly smaller -->
        <div class="flex justify-between items-center">
            <a href="{{ route('pasiens.create') }}"
                class="bg-cyan-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300 text-base font-medium"
                data-intro="Ini adalah tombol 'Tambah Data'. Klik di sini untuk menambahkan data pasien baru." data-step="9">
                <i class="fas fa-plus mr-1"></i>Tambah Data Pasien
            </a>
        </div>

        <!-- Live Search Form - Adjusted size -->
        <div class="bg-white p-4 rounded-lg shadow-md"
            data-intro="Ini adalah form pencarian. Ketik langsung untuk mencari pasien." data-step="10">
            <div class="relative">
                <label for="liveSearch" class="block text-base font-medium text-gray-700 mb-1">Cari Pasien:</label>
                <div class="flex items-center">
                    <input type="text" id="liveSearch" placeholder="Masukkan nama, NIK, atau alamat..."
                        class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-800 text-base">
                    <button type="button" id="resetSearch" class="ml-2 text-gray-500 hover:text-gray-700 hidden p-2">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Patient Data Table - Adjusted size -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden"
            data-intro="Ini adalah tabel data pasien lansia. Anda dapat melihat informasi seperti nama, NIK, alamat, dan lainnya."
            data-step="11">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-base" id="patientTable">
                    <thead class="bg-cyan-700 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">No</th>
                            <th class="px-4 py-3 text-left font-semibold">Nama Pasien</th>
                            <th class="px-4 py-3 text-left font-semibold hidden lg:table-cell">NIK</th>
                            <th class="px-4 py-3 text-left font-semibold hidden md:table-cell">Alamat</th>
                            <th class="px-4 py-3 text-left font-semibold">Umur</th>
                            <th class="px-4 py-3 text-left font-semibold">Jenis Kelamin</th>
                            <th class="px-4 py-3 text-left font-semibold hidden lg:table-cell">Gol. Darah</th>
                            <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($pasiens as $pasien)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="px-4 py-3 whitespace-nowrap text-gray-800">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900">{{ $pasien->nama }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-gray-800 hidden lg:table-cell">
                                    {{ $pasien->nik }}</td>
                                <td class="px-4 py-3 text-gray-800 hidden md:table-cell">{{ $pasien->alamat }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-gray-800">{{ $pasien->umur }} tahun</td>
                                <td class="px-4 py-3 whitespace-nowrap text-gray-800">
                                    {{ $pasien->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-gray-800 hidden lg:table-cell">
                                    {{ $pasien->golongan_darah }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('kader.data-pasien.show', $pasien) }}"
                                           class="flex items-center bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition duration-300 text-sm"
                                           data-intro="Ini adalah tombol 'Lihat'. Klik di sini untuk melihat detail data pasien."
                                           data-step="12">
                                           <i class="fas fa-eye mr-1"></i> Lihat
                                        </a>
                                        
                                        <a href="{{ route('kader.data-pasien.edit', $pasien) }}"
                                           class="flex items-center bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition duration-300 text-sm"
                                           data-intro="Ini adalah tombol 'Edit'. Klik di sini untuk mengubah data pasien."
                                           data-step="13">
                                           <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        
                                        <button onclick="openModal('{{ route('kader.data-pasien.destroy', $pasien) }}')"
                                                class="flex items-center bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition duration-300 text-sm"
                                                data-intro="Ini adalah tombol 'Hapus'. Klik di sini untuk menghapus data pasien."
                                                data-step="14">
                                                <i class="fas fa-trash mr-1"></i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Delete Confirmation Modal - Adjusted size -->
    <div id="deleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 hidden">
        <div class="bg-white p-5 rounded-lg shadow-xl w-11/12 md:w-1/2 max-w-md transform transition-transform duration-300 scale-95 opacity-0"
            id="modalContent">
            <div class="text-center">
                <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-3"></i>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Konfirmasi Penghapusan</h3>
                <p class="text-base text-gray-600 mb-4">Apakah Anda yakin ingin menghapus data pasien ini?</p>
            </div>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-center space-x-3">
                    <button type="button" onclick="closeModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-300 text-base font-medium">
                        <i class="fas fa-times mr-1"></i> Batal
                    </button>
                    <button type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300 text-base font-medium">
                        <i class="fas fa-trash mr-1"></i> Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Adjusted touch targets
            const interactiveElements = document.querySelectorAll('a, button, input');
            interactiveElements.forEach(el => {
                el.style.minHeight = '40px';
                el.style.minWidth = '40px';
            });

            // Enhanced search functionality
            const liveSearch = document.getElementById('liveSearch');
            const resetSearch = document.getElementById('resetSearch');
            const tableRows = document.querySelectorAll('#patientTable tbody tr');

            liveSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                let hasResults = false;

                tableRows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let rowMatches = false;

                    for (let i = 0; i < cells.length - 1; i++) {
                        if (cells[i].textContent.toLowerCase().includes(searchTerm)) {
                            rowMatches = true;
                            break;
                        }
                    }

                    row.style.display = rowMatches ? '' : 'none';
                    if (rowMatches) hasResults = true;
                });

                resetSearch.classList.toggle('hidden', searchTerm.length === 0);
                showNoResultsMessage(!hasResults && searchTerm.length > 0);
            });

            resetSearch.addEventListener('click', function() {
                liveSearch.value = '';
                liveSearch.dispatchEvent(new Event('input'));
                liveSearch.focus();
            });

            function showNoResultsMessage(show) {
                let noResultsDiv = document.getElementById('noResultsMessage');

                if (show) {
                    if (!noResultsDiv) {
                        noResultsDiv = document.createElement('div');
                        noResultsDiv.id = 'noResultsMessage';
                        noResultsDiv.className =
                            'bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-3 mt-2 rounded text-base';
                        noResultsDiv.innerHTML =
                            '<i class="fas fa-info-circle mr-1"></i> Hasil pencarian tidak ditemukan';
                        liveSearch.parentNode.parentNode.appendChild(noResultsDiv);
                    }
                } else if (noResultsDiv) {
                    noResultsDiv.remove();
                }
            }
        });

        // Modal functions
        function openModal(deleteUrl) {
            document.getElementById("deleteForm").action = deleteUrl;
            const modal = document.getElementById("deleteModal");
            modal.classList.remove("hidden");
            document.body.style.overflow = 'hidden';

            setTimeout(() => {
                document.getElementById("modalContent").classList.remove("scale-95", "opacity-0");
                document.getElementById("modalContent").classList.add("scale-100", "opacity-100");
            }, 10);

            setTimeout(() => {
                document.querySelector('#deleteModal button[type="button"]').focus();
            }, 20);
        }

        function closeModal() {
            const modalContent = document.getElementById("modalContent");
            modalContent.classList.remove("scale-100", "opacity-100");
            modalContent.classList.add("scale-95", "opacity-0");

            setTimeout(() => {
                document.getElementById("deleteModal").classList.add("hidden");
                document.body.style.overflow = '';
            }, 300);
        }

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('deleteModal').classList.contains('hidden')) {
                closeModal();
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
                nextLabel: 'Lanjut →',
                prevLabel: '← Kembali',
                doneLabel: 'Selesai',
                tooltipClass: 'introjs-tooltip-custom',
                highlightClass: 'introjs-highlight-custom',
                scrollToElement: true,
                scrollPadding: 80
            }).start();
        }

        // Custom styling for the tour
        const style = document.createElement('style');
        style.textContent = `
            .introjs-tooltip-custom {
                min-width: 280px;
                max-width: 450px;
                font-size: 16px;
                line-height: 1.4;
            }
            .introjs-highlight-custom {
                border: 3px solid rgba(6, 182, 212, 0.5);
                border-radius: 6px;
            }
            .introjs-button {
                padding: 8px 12px;
                font-size: 14px;
            }
        `;
        document.head.appendChild(style);
    </script>
@endsection
