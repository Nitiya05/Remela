@extends('layouts.petugas')

@section('content')
<div class="container mx-auto p-5">
    <h2 class="text-3xl font-bold mb-6 text-gray-800">Catatan Petugas</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-cyan-700 text-white">
                    <th class="px-6 py-3 text-left">No</th>
                    <th class="px-6 py-3 text-left">Nama Pasien</th>
                    <th class="px-6 py-3 text-left">NIK</th>
                    <th class="px-6 py-3 text-center">Umur</th>
                    <th class="px-6 py-3 text-center">Jenis Kelamin</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pasiens as $index => $pasien)
                <tr class="hover:bg-gray-50 border-b border-gray-200">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $pasien->nama }}</td>
                    <td class="px-6 py-4">{{ $pasien->nik }}</td>
                    <td class="px-6 py-4 text-center">{{ $pasien->umur }}</td>
                    <td class="px-6 py-4 text-center">{{ $pasien->jenis_kelamin }}</td>
                    <td class="px-6 py-4 text-center">
                        <button onclick="openModal('modal-{{ $pasien->id }}')" 
                                class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition-colors">
                            Tambah Catatan
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $pasiens->links() }}
    </div>

    <!-- Modals untuk setiap pasien -->
    @foreach($pasiens as $pasien)
    <div id="modal-{{ $pasien->id }}" class="fixed inset-0 z-50 flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeModal('modal-{{ $pasien->id }}')"></div>
        
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl mx-4 max-h-[90vh] overflow-y-auto relative">
            <!-- Modal Header -->
            <div class="sticky top-0 bg-white p-6 border-b flex justify-between items-center z-10">
                <h3 class="text-xl font-bold text-gray-800">Rekam Medis {{ $pasien->nama }}</h3>
                <button onclick="closeModal('modal-{{ $pasien->id }}')" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Content -->
            <div class="p-6">
                <!-- Rekam Medis Terakhir -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold mb-4">Rekam Medis Terakhir</h4>
                    
                    @if($pasien->rekamMedisTerakhir)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="text-sm text-blue-600">Tanggal Rekam</p>
                                <p class="font-medium">{{ $pasien->rekamMedisTerakhir->tanggal_rekam ?? '-' }}</p>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="text-sm text-blue-600">Riwayat Penyakit</p>
                                <p class="font-medium">{{ $pasien->rekamMedisTerakhir->riwayat_penyakit ?? '-' }}</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div class="bg-green-50 p-4 rounded-lg">
                                <p class="text-sm text-green-600">Berat Badan</p>
                                <p class="font-medium">{{ $pasien->rekamMedisTerakhir->berat_badan ? $pasien->rekamMedisTerakhir->berat_badan.' kg' : '-' }}</p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <p class="text-sm text-green-600">Tinggi Badan</p>
                                <p class="font-medium">{{ $pasien->rekamMedisTerakhir->tinggi_badan ? $pasien->rekamMedisTerakhir->tinggi_badan.' cm' : '-' }}</p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <p class="text-sm text-green-600">Lingkar Perut</p>
                                <p class="font-medium">{{ $pasien->rekamMedisTerakhir->lingkar_perut ? $pasien->rekamMedisTerakhir->lingkar_perut.' cm' : '-' }}</p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <p class="text-sm text-green-600">BMI</p>
                                <p class="font-medium">{{ $pasien->rekamMedisTerakhir->bmi ?? '-' }}</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                            <div class="bg-purple-50 p-4 rounded-lg">
                                <p class="text-sm text-purple-600">Tekanan Darah</p>
                                <p class="font-medium">
                                    @if($pasien->rekamMedisTerakhir->tekanan_darah_sistolik && $pasien->rekamMedisTerakhir->tekanan_darah_diastolik)
                                        {{ $pasien->rekamMedisTerakhir->tekanan_darah_sistolik }}/{{ $pasien->rekamMedisTerakhir->tekanan_darah_diastolik }} mmHg
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg">
                                <p class="text-sm text-purple-600">Gula Darah</p>
                                <p class="font-medium">{{ $pasien->rekamMedisTerakhir->gula_darah ? $pasien->rekamMedisTerakhir->gula_darah.' mg/dL' : '-' }}</p>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg">
                                <p class="text-sm text-purple-600">Kolesterol</p>
                                <p class="font-medium">{{ $pasien->rekamMedisTerakhir->kolesterol ? $pasien->rekamMedisTerakhir->kolesterol.' mg/dL' : '-' }}</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div class="bg-yellow-50 p-4 rounded-lg">
                                <p class="text-sm text-yellow-600">Merokok</p>
                                <p class="font-medium">{{ $pasien->rekamMedisTerakhir->merokok ? 'Ya' : 'Tidak' }}</p>
                            </div>
                            <div class="bg-yellow-50 p-4 rounded-lg">
                                <p class="text-sm text-yellow-600">Aktivitas Fisik</p>
                                <p class="font-medium">{{ $pasien->rekamMedisTerakhir->kurang_aktivitas_fisik ? 'Kurang' : 'Cukup' }}</p>
                            </div>
                            <div class="bg-yellow-50 p-4 rounded-lg">
                                <p class="text-sm text-yellow-600">Konsumsi Sayur/Buah</p>
                                <p class="font-medium">{{ $pasien->rekamMedisTerakhir->kurang_sayur_buah ? 'Kurang' : 'Cukup' }}</p>
                            </div>
                            <div class="bg-yellow-50 p-4 rounded-lg">
                                <p class="text-sm text-yellow-600">Konsumsi Alkohol</p>
                                <p class="font-medium">{{ $pasien->rekamMedisTerakhir->konsumsi_alkohol ? 'Ya' : 'Tidak' }}</p>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Obat yang Dikonsumsi</p>
                            <p class="font-medium">{{ $pasien->rekamMedisTerakhir->obat ?? '-' }}</p>
                        </div>
                        
                        @if($pasien->rekamMedisTerakhir->catatan_petugas)
                            <div class="mb-4 bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-600">Catatan Petugas Sebelumnya</p>
                                <p class="font-medium">{{ $pasien->rekamMedisTerakhir->catatan_petugas }}</p>
                            </div>
                        @endif
                    @else
                        <div class="bg-gray-100 p-4 rounded-lg text-center text-gray-500">
                            Belum ada rekam medis untuk pasien ini.
                        </div>
                    @endif
                </div>
                
                <!-- Form Catatan Petugas -->
                <form method="POST" action="{{ route('petugas.simpanLaporan') }}" class="mt-6">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $pasien->id }}">
                    
                    <div class="mb-4">
                        <label class="block font-bold mb-2 text-gray-700">Catatan Petugas</label>
                        <textarea name="catatan" class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="4" placeholder="Tambahkan catatan medis..." required>{{ old('catatan') }}</textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal('modal-{{ $pasien->id }}')" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            Simpan Catatan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<script>
    // Fungsi untuk membuka modal
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    // Fungsi untuk menutup modal
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Tutup modal saat mengklik di luar konten modal
    window.addEventListener('click', function(event) {
        if (event.target.classList.contains('bg-black')) {
            const modalId = event.target.parentElement.id;
            closeModal(modalId);
        }
    });
</script>
@endsection