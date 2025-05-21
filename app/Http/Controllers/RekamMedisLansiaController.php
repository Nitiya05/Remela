<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use App\Models\RekamMedisLansia;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RekamMedisLansiaController extends Controller
{
    /**
     * Menampilkan daftar rekam medis lansia.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = RekamMedisLansia::with('pasien');

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->whereHas('pasien', function ($q) use ($searchTerm) {
                $q->where('nama', 'like', '%' . $searchTerm . '%')
                    ->orWhere('nik', 'like', '%' . $searchTerm . '%');
            });
        }

        $records = $query->paginate(20);
        $patient = Pasien::all();

        return view('kader.rekam-medis', compact('records', 'patient'));
    }

    /**
     * Menampilkan form untuk membuat rekam medis baru.
     *
     * @param int $patient_id
     * @return \Illuminate\View\View
     */
    public function create($patient_id)
    {
        // Ambil data pasien berdasarkan ID
        $patient = Pasien::findOrFail($patient_id);

        // Tampilkan view form dengan data pasien
        return view('kader.rekamMedis.create', compact('patient'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'patient_id' => 'required|exists:pasiens,id',
            'tanggal_rekam' => 'required|date',
            'riwayat_penyakit' => 'nullable|string',
            'berat_badan' => 'required|numeric|min:1|max:300', // dalam kg
            'tinggi_badan' => 'required|numeric|min:30|max:300', // dalam cm
            'lingkar_perut' => 'required|numeric|min:20|max:200', // dalam cm
            'bmi' => 'nullable|numeric',
            'tekanan_darah_sistolik' => 'required|numeric|min:30|max:300',
            'tekanan_darah_diastolik' => 'required|numeric|min:30|max:200',
            'gula_darah' => 'nullable|numeric|min:30|max:1000',
            'kolesterol' => 'nullable|numeric|min:30|max:1000',
            'asam_urat' => 'nullable|numeric|min:1|max:20', // dalam mg/dL
            'obat' => 'nullable|string',
            'merokok' => 'nullable|boolean',
            'kurang_aktivitas_fisik' => 'nullable|boolean',
            'kurang_sayur_buah' => 'nullable|boolean',
            'konsumsi_alkohol' => 'nullable|boolean',
            'tindak_lanjut' => 'nullable|string',
        ], [
            'required' => 'Field :attribute wajib diisi.',
            'numeric' => 'Field :attribute harus berupa angka.',
            'min' => 'Field :attribute minimal :min.',
            'max' => 'Field :attribute maksimal :max.',
            'date' => 'Field :attribute harus berupa tanggal yang valid.',
            'exists' => 'Data pasien tidak ditemukan.'
        ]);

        // Simpan data ke database
        RekamMedisLansia::create($validated);

        // Redirect ke halaman rekam medis dengan pesan sukses
        return redirect()->route('rekam-medis-lansia.index')->with('success', 'Rekam medis berhasil disimpan');
    }

    /**
     * Menampilkan form untuk mengedit rekam medis.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // Ambil data rekam medis berdasarkan ID
        $record = RekamMedisLansia::findOrFail($id);

        // Tampilkan view form edit dengan data rekam medis
        return view('kader.rekamMedis.edit', compact('record'));
    }

    /**
     * Memperbarui rekam medis di database.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Ambil data rekam medis berdasarkan ID
        $record = RekamMedisLansia::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'tanggal_rekam' => 'required|date',
            'riwayat_penyakit' => 'nullable|string',
            'merokok' => 'nullable|boolean',
            'kurang_aktivitas_fisik' => 'nullable|boolean',
            'kurang_sayur_buah' => 'nullable|boolean',
            'konsumsi_alkohol' => 'nullable|boolean',
            'berat_badan' => 'nullable|numeric|min:1|max:300',
            'tinggi_badan' => 'nullable|numeric|min:30|max:300',
            'lingkar_perut' => 'nullable|numeric|min:10|max:200',
            'tekanan_darah_sistolik' => 'nullable|numeric|min:50|max:300',
            'tekanan_darah_diastolik' => 'nullable|numeric|min:30|max:200',
            'gula_darah' => 'nullable|numeric|min:30|max:500',
            'kolesterol' => 'nullable|numeric|min:30|max:500',
            'asam_urat' => 'nullable|numeric|min:1|max:20',
            'obat' => 'nullable|string',
            'tindak_lanjut' => 'nullable|string',
        ]);

        // Set nilai default untuk checkbox jika tidak dicentang
        $validated['merokok'] = $request->has('merokok') ? 1 : 0;
        $validated['kurang_aktivitas_fisik'] = $request->has('kurang_aktivitas_fisik') ? 1 : 0;
        $validated['kurang_sayur_buah'] = $request->has('kurang_sayur_buah') ? 1 : 0;
        $validated['konsumsi_alkohol'] = $request->has('konsumsi_alkohol') ? 1 : 0;

        // Perbarui data di database
        $record->update($validated);

        // Redirect ke halaman rekam medis dengan pesan sukses
        return redirect()->route('rekam-medis-lansia.index')->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Menampilkan detail rekam medis.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show(Request $request, $id)
    {
        // Ambil data rekam medis berdasarkan ID
        $record = RekamMedisLansia::with('pasien')->find($id);

        if (!$record) {
            return redirect()->route('rekam-medis-lansia.index')->with('error', 'Rekam medis tidak ditemukan.');
        }

        // Ambil data pasien terkait
        $pasien = $record->pasien;

        // Query untuk mengambil rekam medis berdasarkan ID pasien
        $query = RekamMedisLansia::with('pasien')->where('patient_id', $pasien->id);

        // Filter berdasarkan bulan jika ada
        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('tanggal_rekam', $request->bulan);
        }

        // Filter berdasarkan tahun jika ada
        if ($request->has('tahun') && $request->tahun != '') {
            $query->whereYear('tanggal_rekam', $request->tahun);
        }

        // Ambil data rekam medis
        $records = $query->get();

        // Siapkan data untuk grafik
        $labels = [];
        $tekananDarahSistolik = [];
        $tekananDarahDiastolik = [];
        $gulaDarah = [];
        $kolesterol = [];
        $asamUrat = [];
        $imt = [];
        $lingkarPerut = [];

        foreach ($records as $record) {
            $labels[] = \Carbon\Carbon::parse($record->tanggal_rekam)->format('d M Y');
            $tekananDarahSistolik[] = $record->tekanan_darah_sistolik;
            $tekananDarahDiastolik[] = $record->tekanan_darah_diastolik;
            $gulaDarah[] = $record->gula_darah;
            $kolesterol[] = $record->kolesterol;
            $asamUrat[] = $record->asam_urat;
            $imt[] = $record->bmi;
            $lingkarPerut[] = $record->lingkar_perut;
        }

        // Tampilkan view dengan data yang diperlukan
        return view('kader.rekamMedis.show', compact(
            'records',
            'labels',
            'tekananDarahSistolik',
            'tekananDarahDiastolik',
            'gulaDarah',
            'kolesterol',
            'asamUrat',
            'imt',
            'lingkarPerut',
            'pasien'
        ));
    }

    /**
     * Menghapus rekam medis dari database.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Ambil data rekam medis berdasarkan ID
        $record = RekamMedisLansia::find($id);

        // Jika data ditemukan, hapus dan redirect dengan pesan sukses
        if ($record) {
            $record->delete();
            return redirect()->route('rekam-medis-lansia.index')->with('success', 'Data berhasil dihapus');
        }

        // Jika data tidak ditemukan, redirect dengan pesan error
        return redirect()->route('rekam-medis-lansia.index')->with('error', 'Data tidak ditemukan');
    }

    public function generatePdf()
    {
        // Ambil bulan dan tahun terakhir dari data rekam medis
        $latestRecordDate = RekamMedisLansia::orderBy('tanggal_rekam', 'desc')->value('tanggal_rekam');

        if (!$latestRecordDate) {
            return redirect()->back()->with('error', 'Tidak ada data rekam medis tersedia.');
        }

        $latestMonth = \Carbon\Carbon::parse($latestRecordDate)->month;
        $latestYear = \Carbon\Carbon::parse($latestRecordDate)->year;

        // Ambil data rekam medis di bulan dan tahun tersebut
        $record = RekamMedisLansia::with('pasien')
            ->whereMonth('tanggal_rekam', $latestMonth)
            ->whereYear('tanggal_rekam', $latestYear)
            ->orderBy('tanggal_rekam', 'desc')
            ->first(); // ambil salah satu rekam medis terbaru dari bulan itu

        if (!$record) {
            return redirect()->back()->with('error', 'Rekam medis bulan terakhir tidak ditemukan.');
        }

        $pasien = $record->pasien;

        $pdf = Pdf::loadView('kader.rekamMedis.printpdf', [
            'pasien' => $pasien,
            'record' => $record,
        ]);

        return $pdf->stream('rekam_medis_' . $pasien->nama . '.pdf');
    }
}
