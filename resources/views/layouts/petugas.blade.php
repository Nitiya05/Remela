<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intro.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.1.0/introjs.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>

        .introjs-skipbutton {
            font-size: 18px !important; /* Memperkecil ukuran font */
            position: absolute !important;
            left: 170px !important; /* Menggeser ke kiri */
        }
        /* Sembunyikan scrollbar di semua browser */
        .scrollbar-hide {
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE & Edge */
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none; /* Chrome, Safari */
        }

        /* Animasi untuk sidebar */
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }

        /* Overlay untuk sidebar di mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }

        .sidebar-overlay.active {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Overlay untuk sidebar di mobile -->
        <div id="sidebar-overlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-sky-800 p-5 transform sidebar-transition -translate-x-full md:translate-x-0 z-50 overflow-y-auto scrollbar-hide"
        data-intro="Ini adalah sidebar. Di sini Anda dapat mengakses menu navigasi."
        data-step="1">
            <!-- Tombol Toggle untuk Mobile -->
            <button id="sidebar-toggle" class="md:hidden absolute top-4 right-4 text-gray-600 focus:outline-none" onclick="toggleSidebar()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>

            <!-- Logo dan Profil -->
            <h1 class="text-2xl font-bold text-center text-white">REMELA</h1>
            <div class="flex justify-center mt-10">
                <div id="profile-icon" class="bg-transparent border-2 border-cyan-600 w-20 h-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-cyan-600 text-3xl"></i> <!-- Ikon pengguna dari FontAwesome -->
                </div>
            </div>
            <h1 class="text-3xl text-center font-bold sidebar-text text-white mt-4">
                {{ $petugas->nama ?? 'Petugas Kesehatan' }} 
            </h1>

            <!-- Navigasi -->
            <nav class="mt-8">
                <a href="{{ route('petugas.dashboard') }}" 
                    class="flex items-center p-2 rounded-lg transition-all duration-300 ease-in-out hover:pl-5 hover:bg-sky-600
                    {{ request()->routeIs('petugas.dashboard') ? 'bg-sky-600 text-blue font-bold' : '' }}"
                     data-intro="Klik di sini untuk melihat halaman utama." data-step="2">
                    <img src="{{ asset('images/Ic_Beranda.png') }}" class="w-8 h-8 min-w-[32px]">
                    <span class="sidebar-text ml-2 text-xl text-white font-semibold">Dashboard</span>
                </a>
                <a href="{{ route('petugas.daftarKader') }}" 
                    class="my-2 flex items-center p-2 rounded-lg transition-all duration-300 ease-in-out hover:pl-5 hover:bg-sky-600
                    {{ request()->routeIs('petugas.daftarKader') ? 'bg-sky-600 text-white font-bold' : '' }}"
                     data-intro="Di sini Anda bisa melihat daftar kader." data-step="3">
                    <img src="{{ asset('images/Ic_DataPasien.png') }}" class="w-8 h-8 min-w-[32px]">
                    <span class="sidebar-text ml-2 text-xl text-white font-semibold">Daftar Kader</span>
                </a>
                <a href="{{ route('petugas.daftarPasien') }}" 
                    class="my-2 flex items-center p-2 rounded-lg transition-all duration-300 ease-in-out hover:pl-5 hover:bg-sky-600
                    {{ request()->routeIs('petugas.daftarPasien') ? 'bg-sky-600 text-white font-bold' : '' }}"
                     data-intro="Di sini Anda bisa melihat daftar pasien." data-step="4">
                    <img src="{{ asset('images/Ic_RekamMedis.png') }}" class="w-8 h-8 min-w-[32px]">
                    <span class="sidebar-text ml-2 text-xl text-white font-semibold">Daftar Pasien</span>
                </a>
                <a href="{{ route('petugas.laporan') }}" 
                    class="my-2 flex items-center p-2 rounded-lg transition-all duration-300 ease-in-out hover:pl-5 hover:bg-sky-600
                    {{ request()->routeIs('petugas.laporan') ? 'bg-sky-600 text-white font-bold' : '' }}"
                     data-intro="Di sini Anda bisa melihat laporan data pasien." data-step="5">
                    <img src="{{ asset('images/Ic_Jadwal.png') }}" class="w-8 h-8 min-w-[32px]">
                    <span class="sidebar-text ml-2 text-xl text-white font-semibold">Catatan</span>
                </a>
                
                <!-- Tombol Logout -->
                <a href="{{ route('logout') }}" 
                    class="flex justify-center items-center p-2 my-10 hover:text-yellow-100 bg-red-600 transition-all duration-300 ease-in-out hover:pl-5 hover:shadow-lg rounded-full"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    data-intro="Tombol Logout. Klik untuk keluar dari aplikasi."
                    data-step="6">
                    <img src="{{ asset('images/ic_keluar.png') }}" class="w-8 h-8 min-w-[32px]">
                    <span class="sidebar-text ml-2 text-xl text-white font-semibold">Keluar</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main id="main-content" class="flex-1 p-6 ml-0 md:ml-64 transition-all duration-300 ease-in-out overflow-y-auto mb-10">
            <!-- Tombol Toggle untuk Mobile -->
            <button id="sidebar-toggle" class="md:hidden fixed top-4 left-4 text-gray-600 focus:outline-none z-50" onclick="toggleSidebar()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>

            <!-- Konten Utama -->
            @yield('content')

            <!-- Tombol Panduan -->
            <div onclick="startTour()" class="fixed bottom-8 right-8 z-50 bg-cyan-700 text-white px-4 py-3 rounded-full shadow-xl hover:bg-cyan-800 transition-all cursor-pointer flex items-center">
                <i class="fas fa-question-circle mr-2"></i>
                <span>Panduan</span>
            </div>
        </main>

        <!-- Footer -->
        <footer id="footer" class="bg-[#eaf0f7] p-4 text-black font-semibold shadow-md fixed bottom-0 w-full transition-all duration-300 ease-in-out md:pl-64">
            <span class="ml-4">© 2025 Aplikasi REMELA | Hak Cipta Dilindungi</span>
        </footer>
    </div>

    <!-- Intro.js JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/intro.min.js"></script>
    <script>
        // Fungsi untuk memulai tur
        function startTour() {
            introJs().setOptions({
                nextLabel: 'Lanjut',
                prevLabel: 'Kembali',
                skipLabel: 'Lewati',
                doneLabel: 'Selesai',
                showProgress: true,
                showBullets: true,
            }).start();
        }

        // Jalankan tur saat tombol "Panduan" diklik
        document.getElementById('guide-button').addEventListener('click', function() {
            startTour();
        });

        // Toggle Sidebar untuk Mobile
        function toggleSidebar() {
            let sidebar = document.getElementById('sidebar');
            let overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('md:translate-x-0');
            overlay.classList.toggle('active');
        }

        // Tutup sidebar ketika mengklik overlay
        document.getElementById('sidebar-overlay').addEventListener('click', function() {
            toggleSidebar();
        });
    </script>
</body>
</html>