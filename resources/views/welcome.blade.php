<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remela</title>
    <link rel="icon" type="image/png" href="{{ asset('images/remela.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">


    <!-- Tailwind CDN (jika belum pakai Vite atau Webpack) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Google -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>

<body class="bg-sky-50 text-gray-800 leading-relaxed">

    <!-- Header -->
    <header class="bg-white shadow-sm py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
          <!-- Larger Logo Remela -->
          <div class="flex items-center">
            <img src="{{ asset('images/remela.png') }}" 
                 alt="Logo Remela" 
                 class="h-20 md:h-24 w-auto"> <!-- Increased height from original -->
            <span class="ml-3 text-2xl md:text-3xl font-bold text-sky-800 hidden sm:block">
              REMELA
            </span>
          </div>
          
          <div>
            <a href="{{ route('login') }}" 
               class="bg-sky-600 hover:bg-sky-700 text-white px-5 py-2 rounded-lg text-lg font-medium transition">
              <i class="fas fa-sign-in-alt mr-2"></i> Masuk
            </a>
          </div>
        </div>
      </header>

    <!-- Hero Section -->
    <section class="text-center bg-cover bg-center py-20"
        style="background-image: linear-gradient(rgba(255,255,255,0.9), rgba(255,255,255,0.9)), url('{{ asset('images/lansia-bg.jpg') }}');">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-4">Sistem Pelayanan Lansia Terpadu </h1>
            <h1 class="text-4xl font-bold mb-4">Kopelma Darussalam</h1>
            <p class="text-xl mb-4">Rekam Medis Elektronik Untuk Lansia</p>
            <p class="text-lg mb-8">Akses layanan kesehatan dan sosial dengan mudah bagi warga lanjut usia</p>
            <div class="flex justify-center mb-5">
                <a href="{{ route('login') }}"
                    class="bg-sky-700 text-white text-xl font-semibold py-4 px-12 rounded-full shadow-md hover:bg-sky-600 hover:-translate-y-1 transition">
                    <i class="fas fa-sign-in-alt mr-2"></i> MASUK LANGSUNG
                </a>
            </div>
            <p class="text-sm text-gray-600">Gunakan NIK dan password yang telah didaftarkan</p>
        </div>
    </section>

    <!-- Fitur -->
    <section class="container mx-auto my-12 px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Masuk Mudah -->
            <div
                class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300 text-center border-t-4 border-sky-500">
                <div class="text-5xl text-sky-600 mb-5">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Akses Mudah</h3>
                <p class="text-gray-600">Masuk sederhana dengan NIK dan password yang telah didaftarkan oleh kader.</p>
            </div>

            <!-- Jadwal Pelayanan -->
            <div
                class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300 text-center border-t-4 border-emerald-500">
                <div class="text-5xl text-emerald-600 mb-5">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Jadwal Pelayanan</h3>
                <p class="text-gray-600">Pantau jadwal posyandu Lansia terdekat.</p>
            </div>

            <!-- Statistik Kesehatan -->
            <div
                class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl hover:-translate-y-2 transition-all duration-300 text-center border-t-4 border-purple-500">
                <div class="text-5xl text-purple-600 mb-5">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Statistik Kesehatan</h3>
                <p class="text-gray-600">Pantau perkembangan kesehatan melalui grafik.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-sky-700 text-white py-5 mt-12">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h5 class="text-lg font-semibold mb-2">Sistem Rekam Medis Elektronik Lansia</h5>
                <p>Memberikan pelayanan terbaik untuk warga lanjut usia</p>
            </div>
            <div class="text-md md:text-right">
                <h5 class="text-lg font-semibold mb-2">Kontak Darurat</h5>
                <p><i class="fas fa-phone mr-2"></i>(021) 1234-5678</p>
            </div>
        </div>

        <div class=" text-white text-center mt-8 text-sm">
            &copy; 2025 REMELA. Semua Hak Dilindungi.
        </div>
    </footer>



    <!-- Tombol Aksesibilitas -->
    <button
        class="fixed bottom-8 right-8 w-14 h-14 rounded-full bg-sky-400 text-white text-2xl shadow-lg z-50 hover:bg-sky-500 transition"
        onclick="increaseFontSize()">➕</button>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function increaseFontSize() {
            const html = document.documentElement;
            const currentSize = parseFloat(window.getComputedStyle(html).fontSize);
            html.style.fontSize = (currentSize + 1) + 'px';
        }
    </script>
</body>

</html>
