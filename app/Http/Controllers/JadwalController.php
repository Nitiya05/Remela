<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $kader = Auth::user();
        $jadwal = Jadwal::orderBy('tanggal', 'asc')->get();
        return view('kader.jadwal', compact('kader','jadwal'));
    }

    public function create()
    {
        $jadwal = Jadwal::all();
        return view('kader.jadwalKunjung.create', compact('jadwal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'lokasi' => 'required',
        ]);

        Jadwal::create($request->all());

        return redirect()->route('kader.jadwal')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        return view('kader.jadwalKunjung.edit', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'nama_kegiatan' => 'required',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'lokasi' => 'required',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('kader.jadwal')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();
        return redirect()->route('kader.jadwal')->with('success', 'Jadwal berhasil dihapus!');
    }
}
