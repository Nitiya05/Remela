@extends('layouts.kader')

@section('content')
    <h2 class="text-2xl font-bold">Edit Dokumentasi Kegiatan</h2>

    <form action="{{ route('kader.dokumentasi.update', $dokumentasi->id) }}" method="POST" enctype="multipart/form-data"
        class="mt-4">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nama_kegiatan" class="block text-sm font-semibold text-gray-700">Nama Kegiatan</label>
            <input type="text" id="nama_kegiatan" name="nama_kegiatan"
                value="{{ old('nama_kegiatan', $dokumentasi->nama_kegiatan) }}"
                class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-sm font-semibold text-gray-700">Deskripsi Kegiatan</label>
            <textarea id="deskripsi" name="deskripsi" class="w-full p-2 border border-gray-300 rounded" required>{{ old('deskripsi', $dokumentasi->deskripsi) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="waktu" class="block text-sm font-semibold text-gray-700">Waktu Kegiatan</label>
            <input type="datetime-local" id="waktu" name="waktu"
                value="{{ old('waktu', date('Y-m-d\TH:i', strtotime($dokumentasi->waktu))) }}"
                class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <div class="mb-4">
            <label for="lokasi" class="block text-sm font-semibold text-gray-700">Lokasi Kegiatan</label>
            <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $dokumentasi->lokasi) }}"
                class="w-full p-2 border border-gray-300 rounded" required>
        </div>

        <!-- Foto yang sudah diupload -->
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Terkait</label>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="foto-container">
                @foreach ($dokumentasi->fotos as $foto)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $foto->path) }}" 
                             class="w-full h-40 object-cover rounded-lg border border-gray-200">
                        
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <label class="flex items-center justify-center cursor-pointer">
                                <input type="checkbox" name="deleted_fotos[]" value="{{ $foto->id }}" 
                                       class="mr-2 h-5 w-5 text-red-600">
                                <span class="text-white">Hapus</span>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Upload foto baru -->
        <div class="mb-4">
            <label for="new_fotos" class="block text-sm font-semibold text-gray-700">Tambah Foto Baru</label>
            <input type="file" id="new_fotos" name="new_fotos[]" class="w-full p-2 border border-gray-300 rounded" multiple accept="image/*">
            <p class="text-xs text-gray-500 mt-1">Format: JPEG, PNG, JPG | Maksimal 5MB per foto</p>
        </div>

        <div class="flex space-x-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Perubahan</button>
            <a href="{{ route('kader.dokumentasi') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Kembali</a>
        </div>
    </form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Debug: Pastikan script terload
    console.log('[DEBUG] Script loaded successfully');
    
    // Delegasi event untuk handle tombol hapus
    document.getElementById('foto-container').addEventListener('click', function(e) {
        if (e.target.closest('.delete-photo')) {
            const button = e.target.closest('.delete-photo');
            const fotoId = button.dataset.fotoId;
            const url = `{{ route('kader.dokumentasi.destroyFoto', '') }}/${fotoId}`;
            
            console.log('[DEBUG] Attempting to delete photo ID:', fotoId);
            
            if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    console.log('[DEBUG] Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('[DEBUG] Response data:', data);
                    if (data.success) {
                        document.getElementById(`foto-${fotoId}`).remove();
                        // Optional: Gunakan toast atau alert lebih elegant
                        showToast('success', data.message);
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    console.error('[ERROR]', error);
                    showToast('error', 'Gagal menghapus foto: ' + error.message);
                });
            }
        }
    });

    function showToast(type, message) {
        Toastify({
            text: message,
            type: type,
            duration: 3000,
            position: 'top-right',
            close: true,
            gravity: 'top',
            backgroundColor: type === 'success' ? '#4CAF50' : '#F44336',
        });
        // Implementasi toast atau gunakan alert sederhana
        alert(message);
    }
});
</script>
@endpush