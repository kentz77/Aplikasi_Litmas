<?php

namespace App\Http\Controllers;
use App\Models\PBDewasa;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\KlasifikasiHukum;
use App\Models\Family;
use App\Models\User;


class PBDewasaController extends Controller
{
    /**
     * Form create
     */
    public function create()
    {
        $clients = Client::all(); // dropdown client
        $klasifikasi = KlasifikasiHukum::all(); // dropdown klasifikasi hukum

        return view('litmas.create', compact('clients', 'klasifikasi'));
    }

    /**
     * Get data client (AJAX untuk auto fill)
     */
    public function getClient($id)
    {
        $client = Client::with(['user', 'guarantor'])->findOrFail($id);

        return response()->json([
            'user_id' => $client->user_id,
            'guarantor_id' => $client->guarantor_id,
            'user_name' => $client->user->name ?? null,
            'guarantor_name' => $client->guarantor->name ?? null,
        ]);
    }

    /**
     * Store data Litmas + Family
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'klasifikasi_hukums_id' => 'required',
        ]);

        // =========================
        // SIMPAN DATA LITMAS
        // =========================
        $litmas = PBDewasa::create([
            'no_litmas' => $request->no_litmas,
            'tanggal_litmas' => $request->tanggal_litmas,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'perkara' => $request->perkara,

            'client_id' => $request->client_id,
            'user_id' => $request->user_id,
            'guarantor_id' => $request->guarantor_id,
            'klasifikasi_hukums_id' => $request->klasifikasi_hukums_id,
        ]);

        // =========================
        // SIMPAN DATA FAMILY (KELUARGA)
        // =========================
        if ($request->family) {
            foreach ($request->family as $item) {
                Family::create([
                    'client_id' => $request->client_id,
                    'nama' => $item['nama'],
                    'hubungan' => $item['hubungan'],
                    'umur' => $item['umur'],
                    'pekerjaan' => $item['pekerjaan'],
                ]);
            }
        }

        return redirect()->route('litmas.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Edit
     */
    public function edit($id)
    {
        $litmas = PBDewasa::with('client')->findOrFail($id);
        $clients = Client::all();
        $klasifikasi = KlasifikasiHukum::all();
        $families = Family::where('client_id', $litmas->client_id)->get();

        return view('litmas.edit', compact('litmas', 'clients', 'klasifikasi', 'families'));
    }

    /**
     * Update
     */
    public function update(Request $request, $id)
    {
        $litmas = PBDewasa::findOrFail($id);

        $litmas->update($request->all());

        // update family (hapus lama → insert ulang biar simple)
        Family::where('client_id', $request->client_id)->delete();

        if ($request->family) {
            foreach ($request->family as $item) {
                Family::create([
                    'client_id' => $request->client_id,
                    'nama' => $item['nama'],
                    'hubungan' => $item['hubungan'],
                    'umur' => $item['umur'],
                    'pekerjaan' => $item['pekerjaan'],
                ]);
            }
        }

        return redirect()->route('litmas.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Delete
     */
    public function destroy($id)
    {
        $litmas = PBDewasa::findOrFail($id);
        $litmas->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
