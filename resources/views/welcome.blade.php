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
                <img src="{{ asset('images/remela.png') }}" alt="Logo Remela" class="h-20 md:h-24 w-auto">
                <!-- Increased height from original -->
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

        <!-- Jadwal Pelayanan -->
        <div class="flex flex-col lg:flex-row gap-8 mt-8">
            <div
                class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 rounded-lg text-center bg-white shadow-md">
                <h2 class="text-xl md:text-2xl font-bold">Jadwal Pelayanan Selanjutnya</h2>
            </div>
            <div class="w-full lg:w-1/2 bg-white p-4 shadow-md rounded-lg overflow-x-auto">
                <table class="w-full border-collapse border border-gray-400">
                    <thead>
                        <tr class="bg-blue-300">
                            <th class="border p-2 text-sm md:text-base whitespace-nowrap">Kegiatan</th>
                            <th class="border p-2 text-sm md:text-base whitespace-nowrap">Tanggal</th>
                            <th class="border p-2 text-sm md:text-base whitespace-nowrap">Jam</th>
                            <th class="border p-2 text-sm md:text-base whitespace-nowrap">Tempat</th>
                            <th class="border p-2 text-sm md:text-base whitespace-nowrap">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwal as $item)
                            @php
                                // Tentukan status berdasarkan tanggal
                                $status = $item->tanggal < now() ? 'selesai' : 'belum_selesai';
                            @endphp
                            <tr>
                                <td class="border border-gray-400 p-2">{{ $item->nama_kegiatan ?? '-' }}</td>
                                <td class="border border-gray-400 p-2">
                                    {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : '-' }}
                                </td>
                                <td class="border border-gray-400 p-2">{{ $item->waktu ?? '-' }}</td>
                                <td class="border border-gray-400 p-2">{{ $item->lokasi ?? '-' }}</td>
                                <td class="border border-gray-400 p-2">
                                    @if ($status == 'selesai')
                                        <span
                                            class="bg-green-500 text-white px-2 py-1 rounded-full text-sm">Selesai</span>
                                    @else
                                        <span
                                            class="bg-yellow-500 text-white px-2 py-1 rounded-full text-sm whitespace-nowrap">Mendatang</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Dokumentasi Section -->
        <div class="bg-white p-6 shadow-lg rounded-xl mt-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-sky-800 mb-2">Galeri Kegiatan</h2>
                <div class="w-20 h-1 bg-blue-500 mx-auto"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($dokumentasi as $doc)
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <!-- Thumbnail -->
                        <div class="relative">
                            @if ($doc->fotos->count() > 0)
                                <img src="{{ asset('storage/' . $doc->fotos->first()->path) }}"
                                    alt="{{ $doc->nama_kegiatan }}" class="w-full h-48 object-cover cursor-pointer"
                                    onclick="openModal('modal-{{ $doc->id }}')">
                            @else
                                <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif

                            <!-- Tanggal Kegiatan -->
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                <span class="text-white text-sm font-medium">
                                    {{ $doc->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </div>

                        <!-- Konten -->
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $doc->nama_kegiatan }}</h3>
                            <p class="text-sm text-gray-600 line-clamp-2">{{ $doc->deskripsi }}</p>

                            <!-- Tombol Lihat Detail -->
                            <button onclick="openModal('modal-{{ $doc->id }}')"
                                class="mt-3 text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                                Lihat Detail
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Modal untuk setiap dokumen -->
                    <div id="modal-{{ $doc->id }}"
                        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 hidden">
                        <div class="bg-white rounded-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                            <!-- Header Modal -->
                            <div class="sticky top-0 bg-white p-4 border-b flex justify-between items-center">
                                <h3 class="text-xl font-bold text-gray-800">{{ $doc->nama_kegiatan }}</h3>
                                <button onclick="closeModal('modal-{{ $doc->id }}')"
                                    class="text-gray-500 hover:text-gray-700">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Body Modal -->
                            <div class="p-6">
                                @if ($doc->fotos->count() > 0)
                                    <div class="mb-6">
                                        <img src="{{ asset('storage/' . $doc->fotos->first()->path) }}"
                                            alt="{{ $doc->nama_kegiatan }}"
                                            class="w-full h-auto max-h-[60vh] object-contain rounded-lg mx-auto">
                                    </div>
                                @endif

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <p class="text-sm text-gray-500">Tanggal Kegiatan</p>
                                        <p class="font-medium">{{ $doc->created_at->format('d F Y') }}</p>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <p class="text-sm text-gray-500">Lokasi</p>
                                        <p class="font-medium">{{ $doc->lokasi ?? 'Tidak dicantumkan' }}</p>
                                    </div>
                                </div>

                                <div class="prose max-w-none">
                                    <h4 class="text-lg font-semibold mb-2">Deskripsi Kegiatan</h4>
                                    <p class="text-gray-700 whitespace-pre-line">{{ $doc->deskripsi }}</p>

                                    @if ($doc->fotos->count() > 1)
                                        <div class="mt-6">
                                            <h4 class="text-lg font-semibold mb-3">Galeri Foto</h4>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                                @foreach ($doc->fotos as $foto)
                                                    <div class="aspect-square overflow-hidden rounded-lg">
                                                        <img src="{{ asset('storage/' . $foto->path) }}"
                                                            alt="Foto dokumentasi {{ $doc->nama_kegiatan }}"
                                                            class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 cursor-pointer"
                                                            onclick="window.open('{{ asset('storage/' . $foto->path) }}', '_blank')">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Footer Modal -->
                            <div class="sticky bottom-0 bg-white p-4 border-t flex justify-end">
                                <button onclick="closeModal('modal-{{ $doc->id }}')"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($dokumentasi->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">Belum ada dokumentasi</h3>
                    <p class="mt-1 text-gray-500">Tidak ada kegiatan yang terdokumentasi saat ini.</p>
                </div>
            @endif
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
