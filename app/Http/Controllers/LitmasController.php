<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LitmasController extends Controller
{
    /**
     * Menampilkan daftar Litmas
     * (Dashboard / Arsip Litmas)
     */
    public function index()
    {
        // nanti bisa ambil dari database
        // $litmas = Litmas::latest()->get();

        return view('litmas.index');
    }

    /**
     * Menampilkan halaman pilih jenis Litmas
     */
    public function create()
    {
        return view('litmas.create');
    }

    /**
     * Menyimpan Litmas baru (Draft)
     */
    public function store(Request $request)
    {
        // contoh validasi sederhana
        $request->validate([
            'jenis_litmas' => 'required|string',
        ]);

        // contoh simpan (nanti diganti model + database)
        /*
        $litmas = Litmas::create([
            'jenis_litmas' => $request->jenis_litmas,
            'status' => 'draft',
            'created_by' => auth()->id(),
        ]);
        */

        // sementara redirect saja
        return redirect()
            ->route('litmas.index')
            ->with('success', 'Litmas berhasil dibuat sebagai draft');
    }

    /**
     * Menampilkan detail Litmas
     */
    public function show($id)
    {
        // $litmas = Litmas::findOrFail($id);

        return view('litmas.show', compact('id'));
    }

    /**
     * Menampilkan form edit Litmas
     */
    public function edit($id)
    {
        // $litmas = Litmas::findOrFail($id);

        return view('litmas.edit', compact('id'));
    }

    /**
     * Update data Litmas
     */
    public function update(Request $request, $id)
    {
        // validasi contoh
        $request->validate([
            'status' => 'required|string',
        ]);

        /*
        $litmas = Litmas::findOrFail($id);
        $litmas->update($request->all());
        */

        return redirect()
            ->route('litmas.index')
            ->with('success', 'Litmas berhasil diperbarui');
    }

    /**
     * Menghapus Litmas
     */
    public function destroy($id)
    {
        /*
        $litmas = Litmas::findOrFail($id);
        $litmas->delete();
        */

        return redirect()
            ->route('litmas.index')
            ->with('success', 'Litmas berhasil dihapus');
    }
}
