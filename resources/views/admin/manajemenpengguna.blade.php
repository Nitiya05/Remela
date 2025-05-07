@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <!-- Judul dan Tombol Tambah Pengguna -->
    <header class="bg-white shadow p-5 rounded-lg mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h2>
    </header>

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.createpengguna') }}" class="bg-sky-700 hover:bg-blue-600 text-white px-4 py-2 rounded-md shadow-md transition duration-300"
            data-intro="Tombol ini digunakan untuk menambahkan pengguna baru."
            data-step="5">
            <i class="fas fa-user-plus mr-2"></i> Tambah Pengguna
        </a>
    </div>

    <!-- Tabel Kader -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6 overflow-hidden" data-intro="Ini adalah tabel daftar kader. Di sini Anda dapat melihat informasi pengguna kader."
        data-step="6">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Daftar Pengguna Kader</h3>
        <div class="overflow-x-auto rounded-lg shadow-md">
            <table class="w-full min-w-[600px]">
                <thead class="bg-sky-800">
                    <tr>
                        <th class="px-6 py-3 text-center text-base font-bold text-white uppercase">Nama</th>
                        <th class="px-6 py-3 text-center text-base font-bold text-white uppercase">Email</th>
                        <th class="px-6 py-3 text-center text-base font-bold text-white uppercase">Role</th>
                        <th class="px-6 py-3 text-center text-base font-bold text-white uppercase">No HP</th>
                        <th class="px-6 py-3 text-center text-base font-bold text-white uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($pengguna->where('role', 'kader') as $user)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 text-base text-gray-700">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-base text-gray-700">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-base text-gray-700">{{ ucfirst($user->role) }}</td>
                        <td class="px-6 py-4 text-base text-gray-700">
                            @if($user->kader && $user->kader->no_hp)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->kader->no_hp) }}" 
                                   target="_blank"
                                   class="text-blue-600 hover:text-blue-800 hover:underline"
                                   title="Kirim pesan WhatsApp">
                                    {{ $user->kader->no_hp }}
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <!-- Edit Button -->
                                <a href="{{ route('admin.editpengguna', $user->id) }}" 
                                   class="inline-flex items-center px-3 py-1.5 border border-blue-300 rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100 hover:text-blue-800 transition-colors duration-200"
                                   title="Edit Pengguna">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    Edit
                                </a>
                        
                                <!-- Delete Button -->
                                <button type="button" onclick="openDeleteModal({{ $user->id }})" 
                                        class="inline-flex items-center px-3 py-1.5 border border-red-300 rounded-md text-red-700 bg-red-50 hover:bg-red-100 hover:text-red-800 transition-colors duration-200"
                                        title="Hapus Pengguna">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Petugas -->
    <div class="bg-white rounded-lg shadow-md p-6" data-intro="Ini adalah tabel daftar petugas. Di sini Anda dapat melihat informasi pengguna petugas."
        data-step="7">
        <h3 class="text-2xl font-semibold text-gray-800 mb-4">Daftar Pengguna Petugas</h3>
        <div class="overflow-x-auto rounded-lg shadow-md">
            <table class="w-full min-w-[600px]">
                <thead class="bg-sky-800">
                    <tr>
                        <th class="px-6 py-3 text-center text-base font-bold text-white uppercase">Nama</th>
                        <th class="px-6 py-3 text-center text-base font-bold text-white uppercase">Email</th>
                        <th class="px-6 py-3 text-center text-base font-bold text-white uppercase">Role</th>
                        <th class="px-6 py-3 text-center text-base font-bold text-white uppercase">No HP</th>
                        <th class="px-6 py-3 text-center text-base font-bold text-white uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($pengguna->where('role', 'petugas') as $user)
                    <tr class="hover:bg-gray-50 transition duration-200">
                        <td class="px-6 py-4 text-base text-gray-700">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-base text-gray-700">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-base text-gray-700">{{ ucfirst($user->role) }}</td>
                        <td class="px-6 py-4 text-base text-gray-700">
                            @if($user->petugas && $user->petugas->no_hp)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->petugas->no_hp) }}" 
                                   target="_blank"
                                   class="text-blue-600 hover:text-blue-800 hover:underline"
                                   title="Kirim pesan WhatsApp">
                                    {{ $user->petugas->no_hp }}
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-3">
                                <!-- Edit Button -->
                                <a href="{{ route('admin.editpengguna', $user->id) }}" 
                                   class="inline-flex items-center px-3 py-1.5 border border-blue-300 rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100 hover:text-blue-800 transition-colors duration-200"
                                   title="Edit Pengguna">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    Edit
                                </a>
                        
                                <!-- Delete Button -->
                                <button type="button" onclick="openDeleteModal({{ $user->id }})" 
                                        class="inline-flex items-center px-3 py-1.5 border border-red-300 rounded-md text-red-700 bg-red-50 hover:bg-red-100 hover:text-red-800 transition-colors duration-200"
                                        title="Hapus Pengguna">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus -->
<div id="deleteModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative bg-white rounded-lg shadow-lg p-6 w-96 z-50">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Konfirmasi Hapus</h3>
        <p class="text-gray-700 mb-6">Apakah Anda yakin ingin menghapus pengguna ini?</p>
        <div class="flex justify-end space-x-4">
            <button onclick="closeDeleteModal()" 
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md shadow-md transition duration-300">
                Batal
            </button>
            <form id="deleteForm" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md shadow-md transition duration-300">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Intro.js Styles dan Script -->
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
            skipLabel: 'Lewati',
            doneLabel: 'Selesai'
        }).start();
    }

    function openDeleteModal(userId) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        form.action = `/admin/pengguna/${userId}`;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    window.addEventListener('click', function(event) {
        const modal = document.getElementById('deleteModal');
        if (event.target === modal || event.target.classList.contains('bg-black')) {
            closeDeleteModal();
        }
    });
</script>
@endsection
