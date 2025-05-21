<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Lansia</title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" href="app.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <style>
        .introjs-skipbutton {
            font-size: 18px !important;
            /* Memperkecil ukuran font */
            position: absolute !important;
            left: 170px !important;
            /* Menggeser ke kiri */
        }

        .scrollbar-hidden::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hidden {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav
            class="bg-sky-800 px-4 md:px-8 py-4 shadow-2xl text-white flex flex-col md:flex-row justify-between items-center">
            <div class="text-2xl md:text-3xl font-bold mb-4 md:mb-0">REMELA</div>
            <div class="flex space-x-4 md:space-x-8">
                <a href="{{ route('pasiens.index') }}"
                    class="font-semibold text-lg md:text-xl hover:underline">Beranda</a>
                <a href="{{ route('pasiens.profile', ['pasien' => Auth::user()->id]) }}"
                    class="font-semibold text-lg md:text-xl hover:underline">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="font-semibold text-lg md:text-xl hover:underline">Keluar</button>
                </form>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 overflow-hidden overflow-y-auto scrollbar-hidden p-4 md:p-8">
            @yield('content')
        </main>

        <footer class="bg-sky-800 p-4 md:p-8 text-white font-semibold shadow-md w-full">
            <div
                class="container mx-auto flex flex-col md:flex-row justify-between items-start text-center md:text-left gap-6 md:gap-8">

                <!-- Terhubung dengan Kami -->
                <div class="w-full md:w-1/2 lg:w-1/3 mb-6 md:mb-0">
                    <h3 class="font-bold text-xl mb-2">Terhubung dengan Kami</h3>
                    <div class="flex flex-col gap-2">
                        <a href="https://web.facebook.com/puskesmaskopelma.darussalam/?_rdc=1&_rdr#"
                            class="hover:text-yellow-300 text-lg">📘 Facebook</a>
                        <a href="https://www.instagram.com/gampongkopelmadarussalam/"
                            class="hover:text-yellow-300 text-lg">📷 Instagram</a>
                    </div>
                </div>

                <!-- Kontak Kami -->
                <div class="w-full md:w-1/2 lg:w-1/3 mb-6 md:mb-0">
                    <h3 class="font-bold text-xl mb-2">Kontak Kami</h3>
                    <p class="text-lg">📧 Email: <span class="text-yellow-300">remelattg61@gmail.com</span></p>
                    <p class="text-lg">📞 Telepon: <span class="text-yellow-300">+62 89529055416</span></p>
                </div>

            </div>

            <!-- Hak Cipta -->
            <div class="mt-6 text-center text-lg border-t border-white pt-4">
                <span>© 2025 Aplikasi REMELA | Hak Cipta Dilindungi</span>
            </div>
        </footer>

    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/7.2.0/intro.min.js"></script>
<script>
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

</html>
