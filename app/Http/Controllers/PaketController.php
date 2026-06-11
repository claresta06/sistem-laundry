<?php

namespace App\Http\Controllers;

use App\Models\PaketLaundry;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = PaketLaundry::orderBy('nama_paket', 'asc')->get();
        return view('paket.index', compact('pakets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'jenis_paket' => 'required|in:kiloan,satuan',
            'harga_per_satuan' => 'required|numeric|min:0',
        ]);

        PaketLaundry::create([
            'nama_paket' => $request->nama_paket,
            'jenis_paket' => $request->jenis_paket,
            'harga_per_satuan' => $request->harga_per_satuan,
        ]);

        return redirect()->route('paket.index')->with('success', 'Paket laundry berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_paket' => 'required|string|max:255',
            'jenis_paket' => 'required|in:kiloan,satuan',
            'harga_per_satuan' => 'required|numeric|min:0',
        ]);

        $paket = PaketLaundry::findOrFail($id);
        $paket->update([
            'nama_paket' => $request->nama_paket,
            'jenis_paket' => $request->jenis_paket,
            'harga_per_satuan' => $request->harga_per_satuan,
        ]);

        return redirect()->route('paket.index')->with('success', 'Paket laundry berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $paket = PaketLaundry::findOrFail($id);
        $paket->delete();

        return redirect()->route('paket.index')->with('success', 'Paket laundry berhasil dihapus!');
    }
}
