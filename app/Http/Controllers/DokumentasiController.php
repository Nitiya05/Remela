<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class DokumentasiController extends Controller
{
    public function index()
    {
        $kader = Auth::user();
        $dokumentasi = Dokumentasi::with('fotos')
            ->orderBy('waktu', 'desc')
            ->get();

        return view('kader.dokumentasi', compact('kader', 'dokumentasi'));
    }

    public function create()
    {
        return view('kader.dokumentasiKegiatan.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'waktu' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'foto' => 'required|array|min:1',
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120', // Max 5MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Buat direktori jika belum ada
            $storagePath = storage_path('app/public/dokumentasi/foto');
            if (!File::exists($storagePath)) {
                File::makeDirectory($storagePath, 0755, true); // true untuk recursive
            }

            $dokumentasi = Dokumentasi::create($request->only([
                'nama_kegiatan',
                'deskripsi',
                'waktu',
                'lokasi'
            ]));

            foreach ($request->file('foto') as $foto) {
                $path = $foto->store('dokumentasi/foto', 'public');
                $dokumentasi->fotos()->create(['path' => $path]);
            }

            return redirect()->route('kader.dokumentasi')
                ->with('success', 'Dokumentasi berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan dokumentasi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $dokumentasi = Dokumentasi::with('fotos')->findOrFail($id);
        return view('kader.dokumentasiKegiatan.edit', compact('dokumentasi'));
    }

    public function update(Request $request, $id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);

        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'waktu' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'new_fotos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'deleted_fotos' => 'nullable|array', // Tambah validasi untuk foto yang dihapus
            'deleted_fotos.*' => 'exists:fotos,id' // Pastikan foto yang dihapus ada di database
        ]);

        try {
            DB::beginTransaction();

            // Update data dokumentasi
            $dokumentasi->update($validated);

            // Hapus foto yang ditandai
            if ($request->has('deleted_fotos')) {
                $fotosToDelete = Foto::whereIn('id', $request->deleted_fotos)
                    ->where('dokumentasi_id', $dokumentasi->id)
                    ->get();

                foreach ($fotosToDelete as $foto) {
                    Storage::disk('public')->delete($foto->path);
                    $foto->delete();
                }
            }

            // Tambah foto baru
            if ($request->hasFile('new_fotos')) {
                foreach ($request->file('new_fotos') as $photo) {
                    $path = $photo->store('dokumentasi/foto', 'public');
                    $dokumentasi->fotos()->create(['path' => $path]);
                }
            }

            DB::commit();

            return redirect()->route('kader.dokumentasi')
                ->with('success', 'Dokumentasi berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal memperbarui dokumentasi: ' . $e->getMessage());
        }
    }

    public function destroyFoto(Foto $foto)
    {
        try {
            // Verifikasi kepemilikan (optional)
            if ($foto->dokumentasi->kader_id != Auth::id()) {
                abort(403, 'Unauthorized action');
            }

            // Hapus file dari storage
            Storage::disk('public')->delete($foto->path);

            // Hapus record dari database
            $foto->delete();

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus foto: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $dokumentasi = Dokumentasi::with('fotos')->findOrFail($id);

        try {
            DB::transaction(function () use ($dokumentasi) {
                // Hapus semua file foto
                foreach ($dokumentasi->fotos as $foto) {
                    Storage::disk('public')->delete($foto->path);
                }

                // Hapus record
                $dokumentasi->fotos()->delete();
                $dokumentasi->delete();
            });

            return redirect()->route('kader.dokumentasi')
                ->with('success', 'Dokumentasi berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus dokumentasi: ' . $e->getMessage());
        }
    }
}
