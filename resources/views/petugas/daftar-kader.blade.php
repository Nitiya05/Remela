@extends('layouts.petugas')

@section('content')
<div class="container mx-auto p-6">
    <!-- Judul Daftar Kader -->
    <h2 class="text-3xl font-bold mb-6 text-gray-800">
        Daftar Kader
    </h2>

    <!-- Tabel Daftar Kader -->
    <div class="overflow-x-auto rounded-lg" data-intro="Ini adalah tabel daftar kader. Di sini Anda dapat melihat informasi kader seperti nama, email, NIK, dan nomor HP." data-step="7">
        <table class="min-w-full bg-white border border-gray-300 rounded-md border-collapse border-spacing-0">
            <thead class="bg-cyan-800">
                <tr>
                    <th class="py-3 px-4 border-b text-left text-lg font-semibold text-white">Nama</th>
                    <th class="py-3 px-4 border-b text-left text-lg font-semibold text-white">Email</th>
                    <th class="py-3 px-4 border-b text-left text-lg font-semibold text-white">NIK</th>
                    <th class="py-3 px-4 border-b text-left text-lg font-semibold text-white">No HP</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                    <td class="py-3 px-4 border-b text-sm text-gray-700">{{ $user->name }}</td>
                    <td class="py-3 px-4 border-b text-sm text-gray-700">{{ $user->email }}</td>
                    <td class="py-3 px-4 border-b text-sm text-gray-700">{{ $user->nik ?? '-' }}</td>
                    <td class="py-3 px-4 border-b text-sm text-gray-700">
                        @if($user->kader && $user->kader->no_hp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->kader->no_hp) }}" 
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                {{ $user->kader->no_hp }}
                            </a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Script Intro.js -->
<script src="https://cdn.jsdelivr.net/npm/intro.js"></script>

<script>
    // Fungsi untuk memulai tur
    function startTour() {
        introJs().setOptions({
            nextLabel: 'Lanjut',
            prevLabel: 'Kembali',
            doneLabel: 'Selesai',
            exitOnOverlayClick: false,
            showStepNumbers: true,
            showBullets: true,
        }).start();
    }

    // Jalankan tur saat tombol "Mulai Tur" diklik
    document.getElementById('start-tour-button').addEventListener('click', function() {
        startTour();
    });
</script>

@endsection