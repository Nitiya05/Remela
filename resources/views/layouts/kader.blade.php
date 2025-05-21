<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Kader</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.1.0/introjs.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.1.0/intro.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .introjs-skipbutton {
            font-size: 18px !important;
            /* Memperkecil ukuran font */
            position: absolute !important;
            left: 170px !important;
            /* Menggeser ke kiri */
        }

        .group:hover .group-hover\:opacity-100 {
            opacity: 1;
        }

        .group .group-hover\:opacity-100 {
            transition: opacity 0.3s ease;
        }

        /* Sembunyikan scrollbar di semua browser */
        .scrollbar-hide {
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE & Edge */
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari */
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed top-0 left-0 h-full w-64 bg-cyan-800 p-5 transform transition-all duration-300 ease-in-out md:translate-x-0 z-50 overflow-y-auto "
            data-intro="Ini adalah sidebar yang berisi menu navigasi utama." data-step="1">

            <!-- Tombol Toggle Sidebar (Hanya Tampil di Layar Kecil) -->
            <button onclick="toggleSidebar()" class="md:hidden absolute top-2 right-2 p-2 bg-gray-300 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Foto Profil -->
            <h1 class="text-2xl font-bold text-center text-white">REMELA</h1>
            <div class="flex justify-center mt-10">
                <div id="profile-icon"
                    class="bg-transparent border-2 border-cyan-600 w-20 h-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-cyan-600 text-3xl"></i> <!-- Ikon pengguna dari FontAwesome -->
                </div>
            </div>


            <!-- Nama Kader -->
            <h1 class="text-3xl text-center font-bold sidebar-text text-white">
                {{ $kader->nama ?? 'Kader' }}
            </h1>

            <!-- Menu Navigasi -->
            <nav class="mt-8" data-intro="Menu navigasi untuk berpindah halaman." data-step="2">
                <a href="{{ route('kader.dashboard') }}"
                    class="flex items-center p-2 rounded-lg transition-all duration-300 ease-in-out hover:pl-5 hover:bg-cyan-600 
                    {{ request()->routeIs('kader.dashboard') ? 'bg-cyan-600 text-blue font-bold' : '' }}"
                    data-intro="Klik di sini untuk melihat halaman utama." data-step="3">
                    <img src="{{ asset('images/Ic_Beranda.png') }}" class="w-8 h-8 min-w-[32px]">
                    <span class="sidebar-text ml-2 text-xl text-white font-semibold">Beranda</span>
                </a>

                <a href="{{ route('kader.dataPasien') }}"
                    class="my-2 flex items-center p-2 rounded-lg transition-all duration-300 ease-in-out hover:pl-5 hover:bg-cyan-600 
                    {{ request()->routeIs('kader.dataPasien') ? 'bg-cyan-600 text-white font-bold' : '' }}"
                    data-intro="Di sini Anda bisa mengelola data pasien." data-step="4">
                    <img src="{{ asset('images/Ic_DataPasien.png') }}" class="w-8 h-8 min-w-[32px]">
                    <span class="sidebar-text ml-2 text-xl text-white font-semibold">Kelola Pasien</span>
                </a>

                <a href="{{ route('kader.rekamMedis') }}"
                    class="my-2 flex items-center p-2 rounded-lg transition-all duration-300 ease-in-out hover:pl-5 hover:bg-cyan-600 
                    {{ request()->routeIs('kader.rekamMedis') ? 'bg-cyan-600 text-white font-bold' : '' }}"
                    data-intro="Halaman untuk melihat rekam medis pasien." data-step="5">
                    <img src="{{ asset('images/Ic_RekamMedis.png') }}" class="w-8 h-8 min-w-[32px]">
                    <span class="sidebar-text ml-2 text-xl text-white font-semibold">Rekam Medis</span>
                </a>

                <a href="{{ route('kader.jadwal') }}"
                    class="my-2 flex items-center p-2 rounded-lg transition-all duration-300 ease-in-out hover:pl-5 hover:bg-cyan-600 
                    {{ request()->routeIs('kader.jadwal') ? 'bg-cyan-600 text-white font-bold' : '' }}"
                    data-intro="Di sini Anda bisa melihat dan mengatur jadwal kegiatan." data-step="6">
                    <img src="{{ asset('images/Ic_Jadwal.png') }}" class="w-8 h-8 min-w-[32px]">
                    <span class="sidebar-text ml-2 text-xl text-white font-semibold">Jadwal</span>
                </a>

                <a href="{{ route('kader.dokumentasi') }}"
                    class="my-2 flex items-center p-2 rounded-lg transition-all duration-300 ease-in-out hover:pl-5 hover:bg-cyan-600 
    {{ request()->routeIs('kader.dokumentasi') ? 'bg-cyan-600 text-white font-bold' : '' }}"
                    data-intro="Di sini Anda bisa melihat dokumentasi kegiatan." data-step="7">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 min-w-[24px] text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <span class="sidebar-text ml-2 text-xl text-white font-semibold">Dokumentasi</span>
                </a>

                <a href="{{ route('kader.editProfil') }}"
                    class="my-2 flex items-center p-2 rounded-lg transition-all duration-300 ease-in-out hover:pl-5 hover:bg-cyan-600 
   {{ request()->routeIs('kader.laporan') ? 'bg-cyan-600 text-white font-bold' : '' }}"
                    data-intro="Di sini Anda bisa mengedit profil atau mengubah password anda." data-step="8">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 min-w-[32px] text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A4.992 4.992 0 0112 15c1.657 0 3.157.804 4.121 2.804M12 12a5 5 0 100-10 5 5 0 000 10z" />
                    </svg>

                    <span class="sidebar-text ml-2 text-xl text-white font-semibold">Edit Profil</span>
                </a>


                <!-- Tombol Keluar -->
                <a href="{{ route('logout') }}"
                    class="flex justify-center items-center p-2 my-10 hover:text-yellow-100 bg-red-600 transition-all duration-300 ease-in-out hover:pl-5 hover:shadow-lg rounded-full"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    data-intro="Klik di sini untuk keluar dari akun." data-step="9">
                    <img src="{{ asset('images/ic_keluar.png') }}" class="w-8 h-8 min-w-[32px]">
                    <span class="sidebar-text ml-2 text-xl text-white font-semibold">Keluar</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main id="main-content"
            class="flex-1 p-6 ml-64 transition-all duration-300 ease-in-out  overflow-y-auto  relative mb-20">

            <div onclick="startTour()"
                class="fixed bottom-8 right-8 z-50 bg-cyan-700 text-white px-4 py-3 rounded-full shadow-xl hover:bg-cyan-800 transition-all cursor-pointer flex items-center">
                <i class="fas fa-question-circle mr-2"></i>
                <span>Panduan</span>
            </div>

            <!-- Konten Utama -->
            @yield('content')
        </main>

        <!-- Footer -->
        <footer id="footer"
            class="bg-[#eaf0f7] p-4 pl-64 pr-6 text-gray font-semibold shadow-md fixed bottom-0 w-full transition-all duration-300 ease-in-out">
            <span class="ml-4">© 2025 Aplikasi REMELA | Hak Cipta Dilindungi</span>
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/intro.min.js"></script>
    <script>
        function toggleSidebar() {
            let sidebar = document.getElementById('sidebar');
            let mainContent = document.getElementById('main-content');
            let footer = document.getElementById('footer');
            let sidebarText = document.querySelectorAll('.sidebar-text');
            let profileImage = document.getElementById('profile-img');

            if (sidebar.classList.contains('w-64')) {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-20');
                mainContent.classList.remove('ml-64');
                mainContent.classList.add('ml-20');
                footer.classList.remove('pl-64');
                footer.classList.add('pl-20');

                sidebarText.forEach(item => item.classList.add('hidden'));

                // Menyesuaikan ukuran gambar agar tetap proporsional
                profileImage.classList.remove('w-20', 'h-20');
                profileImage.classList.add('w-12', 'h-12');
            } else {
                sidebar.classList.remove('w-20');
                sidebar.classList.add('w-64');
                mainContent.classList.remove('ml-20');
                mainContent.classList.add('ml-64');
                footer.classList.remove('pl-20');
                footer.classList.add('pl-64');

                sidebarText.forEach(item => item.classList.remove('hidden'));

                // Kembalikan ukuran gambar ke semula
                profileImage.classList.remove('w-12', 'h-12');
                profileImage.classList.add('w-20', 'h-20');
            }
        }

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
    </script>
</body>

</html>
