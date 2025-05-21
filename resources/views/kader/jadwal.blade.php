@extends('layouts.kader')

@section('content')
<!-- Mobile Menu Button - Slightly smaller -->
<button onclick="toggleSidebar()" class="md:hidden bg-blue-600 text-white p-2 rounded-lg mb-3 text-base">
    ☰ Menu
</button>

<!-- Header with adjusted text size -->
<header class="bg-white shadow p-4 rounded-lg mb-4">
    <h1 class="text-xl md:text-2xl font-bold text-gray-800">Jadwal Kegiatan Lansia</h1>
</header>

<!-- Add Schedule Button - Slightly smaller -->
<a href="{{ route('kader.jadwalKunjung.create') }}" 
   class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300 text-base font-medium inline-flex items-center mb-4"
   data-intro="Tombol ini digunakan untuk menambahkan jadwal kunjungan baru." data-step="9">
    <i class="fas fa-plus mr-1"></i> Tambah Jadwal
</a>

<!-- Schedule Table - Adjusted size -->
<div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6"
     data-intro="Ini adalah tabel jadwal kegiatan. Anda dapat melihat informasi seperti nama kegiatan, tanggal, waktu, lokasi, dan status."
     data-step="10">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-base">
            <!-- Table headers remain the same -->
            <thead class="bg-cyan-700 text-white">
                <tr>
                    <th class="px-4 py-3 uppercase text-center font-semibold">No</th>
                    <th class="px-4 py-3 uppercase text-center font-semibold">Nama Kegiatan</th>
                    <th class="px-4 py-3 uppercase text-center font-semibold">Tanggal</th>
                    <th class="px-4 py-3 uppercase text-center font-semibold">Waktu</th>
                    <th class="px-4 py-3 uppercase text-center font-semibold hidden md:table-cell">Lokasi</th>
                    <th class="px-4 py-3 uppercase text-center font-semibold">Status</th>
                    <th class="px-4 py-3 uppercase text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @php
                    // Separate activities by status
                    $upcoming = [];
                    $ongoing = [];
                    $completed = [];
                    $today = \Carbon\Carbon::today();
                    
                    foreach ($jadwal as $item) {
                        $date = \Carbon\Carbon::parse($item->tanggal);
                        if ($date->isPast()) {
                            $completed[] = $item;
                        } elseif ($date->isToday()) {
                            $ongoing[] = $item;
                        } else {
                            $upcoming[] = $item;
                        }
                    }
                    
                    // Combine in desired order
                    $sortedActivities = array_merge($upcoming, $ongoing, $completed);
                    $counter = ($jadwal->currentPage() - 1) * $jadwal->perPage() + 1;
                @endphp
                
                @foreach ($sortedActivities as $item)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-4 py-3 whitespace-nowrap text-gray-800">{{ $counter++ }}</td>
                        <!-- Rest of your table row remains the same -->
                        <td class="px-4 py-3 font-medium text-gray-900">
                            <span class="cursor-pointer hover:text-blue-600" 
                                  onclick="openDetailModal('{{ $item->nama_kegiatan }}', '{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}', '{{ $item->waktu }}', '{{ $item->lokasi }}')">
                                {{ $item->nama_kegiatan }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-800">
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-gray-800">
                            {{ $item->waktu }}
                        </td>
                        <td class="px-4 py-3 text-gray-800 hidden md:table-cell">
                            {{ $item->lokasi }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $date = \Carbon\Carbon::parse($item->tanggal);
                                $isToday = $date->isToday();
                                $isPast = $date->isPast();
                            @endphp
                            
                            @if($isToday)
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-play-circle mr-1"></i> Berlangsung
                                </span>
                            @elseif($isPast)
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-check-circle mr-1"></i> Selesai
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">
                                    <i class="fas fa-clock mr-1"></i> Akan Datang
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex space-x-1">
                                <!-- View Button -->
                                <button onclick="openDetailModal('{{ $item->nama_kegiatan }}', '{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}', '{{ $item->waktu }}', '{{ $item->lokasi }}')" 
                                        class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition duration-300 text-sm flex items-center"
                                        data-intro="Tombol ini digunakan untuk melihat detail jadwal kegiatan."
                                        data-step="11">
                                    <i class="fas fa-eye mr-1"></i> Lihat
                                </button>
                                
                                <!-- Edit Button -->
                                <a href="{{ route('kader.jadwal.edit', $item->id) }}" 
                                   class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600 transition duration-300 text-sm flex items-center"
                                   data-intro="Tombol ini digunakan untuk mengedit data jadwal kegiatan."
                                   data-step="12">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                
                                <!-- Delete Button -->
                                <button onclick="openDeleteModal('{{ route('kader.jadwal.destroy', $item->id) }}')" 
                                        class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition duration-300 text-sm flex items-center"
                                        data-intro="Tombol ini digunakan untuk menghapus jadwal kegiatan."
                                        data-step="13">
                                    <i class="fas fa-trash mr-1"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
        <div class="flex-1 flex justify-between sm:hidden">
            @if ($jadwal->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white">
                    Sebelumnya
                </span>
            @else
                <a href="{{ $jadwal->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Sebelumnya
                </a>
            @endif
            
            @if ($jadwal->hasMorePages())
                <a href="{{ $jadwal->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Selanjutnya
                </a>
            @else
                <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white">
                    Selanjutnya
                </span>
            @endif
        </div>
        
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Menampilkan 
                    <span class="font-medium">{{ $jadwal->firstItem() }}</span>
                    sampai 
                    <span class="font-medium">{{ $jadwal->lastItem() }}</span>
                    dari 
                    <span class="font-medium">{{ $jadwal->total() }}</span>
                    hasil
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    @if ($jadwal->onFirstPage())
                        <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-300">
                            <span class="sr-only">Previous</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @else
                        <a href="{{ $jadwal->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Previous</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif
                    
                    @foreach ($jadwal->getUrlRange(1, $jadwal->lastPage()) as $page => $url)
                        @if ($page == $jadwal->currentPage())
                            <span aria-current="page" class="z-10 bg-cyan-600 border-cyan-600 text-white relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                    
                    @if ($jadwal->hasMorePages())
                        <a href="{{ $jadwal->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Next</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-300">
                            <span class="sr-only">Next</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @endif
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal - Adjusted size -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-4 rounded-lg shadow-xl w-11/12 md:w-2/3 lg:w-1/2">
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-xl font-bold text-gray-800">Detail Jadwal Kegiatan</h3>
            <button onclick="closeDetailModal()" class="text-gray-500 hover:text-gray-700 text-xl">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="space-y-3 text-base">
            <div class="flex items-start">
                <div class="w-1/3 font-semibold text-gray-700">Nama Kegiatan:</div>
                <div class="w-2/3" id="detailNamaKegiatan"></div>
            </div>
            <div class="flex items-start">
                <div class="w-1/3 font-semibold text-gray-700">Tanggal:</div>
                <div class="w-2/3" id="detailTanggal"></div>
            </div>
            <div class="flex items-start">
                <div class="w-1/3 font-semibold text-gray-700">Waktu:</div>
                <div class="w-2/3" id="detailWaktu"></div>
            </div>
            <div class="flex items-start">
                <div class="w-1/3 font-semibold text-gray-700">Lokasi:</div>
                <div class="w-2/3" id="detailLokasi"></div>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button onclick="closeDetailModal()" 
                    class="bg-gray-300 text-black px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-300 text-base">
                <i class="fas fa-times mr-1"></i> Tutup
            </button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal - Adjusted size -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
    <div class="bg-white p-4 rounded-lg shadow-xl w-11/12 md:w-1/2 lg:w-1/3">
        <div class="text-center mb-4">
            <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-2"></i>
            <h3 class="text-xl font-bold text-gray-800">Konfirmasi Penghapusan</h3>
            <p class="text-base text-gray-600 mt-1">Apakah Anda yakin ingin menghapus jadwal ini?</p>
        </div>
        <div class="flex justify-center space-x-3">
            <button id="cancelDelete" 
                    class="bg-gray-300 text-black px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-300 text-base font-medium">
                <i class="fas fa-times mr-1"></i> Batal
            </button>
            <form id="deleteForm" action="" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300 text-base font-medium">
                    <i class="fas fa-trash mr-1"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    // Function to open the detail modal
    function openDetailModal(namaKegiatan, tanggal, waktu, lokasi) {
        document.getElementById('detailNamaKegiatan').textContent = namaKegiatan;
        document.getElementById('detailTanggal').textContent = tanggal;
        document.getElementById('detailWaktu').textContent = waktu;
        document.getElementById('detailLokasi').textContent = lokasi;
        document.getElementById('detailModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Function to close the detail modal
    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Function to open the delete confirmation modal
    function openDeleteModal(deleteUrl) {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteForm').action = deleteUrl;
        document.body.style.overflow = 'hidden';
    }

    // Close the modal when clicking cancel
    document.getElementById('cancelDelete').addEventListener('click', function() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = '';
    });

    // Close modals when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target == document.getElementById('deleteModal')) {
            document.getElementById('deleteModal').classList.add('hidden');
            document.body.style.overflow = '';
        }
        if (event.target == document.getElementById('detailModal')) {
            document.getElementById('detailModal').classList.add('hidden');
            document.body.style.overflow = '';
        }
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('detailModal').classList.add('hidden');
            document.body.style.overflow = '';
        }
    });
</script>

<!-- Intro.js for interactive guide -->
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
    
    // Add custom styling for the tour
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