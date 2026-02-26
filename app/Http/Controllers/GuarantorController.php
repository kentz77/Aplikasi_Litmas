<?php

namespace App\Http\Controllers;

use App\Models\Guarantor;
use App\Models\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GuarantorController extends Controller
{

    /**
     * FORM TAMBAH
     * tampilkan halaman + dropdown klien
     */
    public function create()
    {
        $clients = Client::orderBy('nama')->get();

        return view('penjamin.create', compact('clients'));
    }


    /**
     * SIMPAN BANYAK PENJAMIN SEKALIGUS
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'penjamin.*.nama' => 'required|string',
            'penjamin.*.tanggal_lahir' => 'required|date',
            'penjamin.*.hubungan_keluarga' => 'required|in:Ayah Kandung,Ibu Kandung,Saudara Kandung,Suami,Istri'
        ]);

        foreach ($request->penjamin as $i => $data) {

            // VALIDASI UMUR >= 18
            $umur = Carbon::parse($data['tanggal_lahir'])->age;

            if ($umur < 18) {
                return back()
                    ->withInput()
                    ->withErrors([
                        "penjamin.$i.tanggal_lahir" => "Penjamin minimal berusia 18 tahun"
                    ]);
            }

            Guarantor::create([
                'client_id' => $request->client_id,
                'no_kk' => $data['no_kk'] ?? null,
                'nama' => $data['nama'],
                'tempat_lahir' => $data['tempat_lahir'] ?? null,
                'tanggal_lahir' => $data['tanggal_lahir'],
                'agama' => $data['agama'] ?? null,
                'suku' => $data['suku'] ?? null,
                'kewarganegaraan' => $data['kewarganegaraan'] ?? null,
                'pendidikan_terakhir' => $data['pendidikan_terakhir'] ?? null,
                'pekerjaan' => $data['pekerjaan'] ?? null,
                'alamat' => $data['alamat'] ?? null,
                'hubungan_keluarga' => $data['hubungan_keluarga'],
            ]);
        }

        return redirect()->route('penjamin.create')
            ->with('success', 'Data penjamin berhasil disimpan');
    }


    /**
     * FORM EDIT (1 klien → banyak penjamin)
     */
    public function edit(Client $client)
    {
        $penjamins = Guarantor::where('client_id', $client->id)->get();

        return view('penjamin.edit', compact('client', 'penjamins'));
    }


    /**
     * UPDATE MASSAL (create + update + delete)
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'penjamin.*.nama' => 'required|string',
            'penjamin.*.tanggal_lahir' => 'required|date',
            'penjamin.*.hubungan_keluarga' => 'required|in:Ayah Kandung,Ibu Kandung,Saudara Kandung,Suami,Istri'
        ]);

        $existingIds = Guarantor::where('client_id', $client->id)->pluck('id')->toArray();
        $sentIds = [];

        foreach ($request->penjamin as $i => $data) {

            // VALIDASI UMUR
            $umur = Carbon::parse($data['tanggal_lahir'])->age;
            if ($umur < 18) {
                return back()->withInput()
                    ->withErrors([
                        "penjamin.$i.tanggal_lahir" => "Penjamin minimal 18 tahun"
                    ]);
            }

            // UPDATE
            if (isset($data['id']) && in_array($data['id'], $existingIds)) {

                $g = Guarantor::find($data['id']);
                $g->update($data);
                $sentIds[] = $g->id;
            }
            // CREATE BARU
            else {

                $g = Guarantor::create([
                    'client_id' => $client->id,
                    'no_kk' => $data['no_kk'] ?? null,
                    'nama' => $data['nama'],
                    'tempat_lahir' => $data['tempat_lahir'] ?? null,
                    'tanggal_lahir' => $data['tanggal_lahir'],
                    'agama' => $data['agama'] ?? null,
                    'suku' => $data['suku'] ?? null,
                    'kewarganegaraan' => $data['kewarganegaraan'] ?? null,
                    'pendidikan_terakhir' => $data['pendidikan_terakhir'] ?? null,
                    'pekerjaan' => $data['pekerjaan'] ?? null,
                    'alamat' => $data['alamat'] ?? null,
                    'hubungan_keluarga' => $data['hubungan_keluarga'],
                ]);

                $sentIds[] = $g->id;
            }
        }

        // HAPUS YANG DIHILANGKAN DI FORM
        $deleteIds = array_diff($existingIds, $sentIds);
        Guarantor::destroy($deleteIds);

        return redirect()->route('penjamin.edit', $client->id)
            ->with('success', 'Data penjamin berhasil diperbarui');
    }


    /**
     * LIST PENJAMIN PER KLIEN (optional untuk AJAX tabel)
     */
    public function byClient($client_id)
    {
        $client = Client::with('guarantors')->findOrFail($client_id);
        return view('penjamin.partials.table', compact('client'));
    }


    /**
     * DETAIL PENJAMIN
     */
    public function show($id)
    {
        $guarantor = Guarantor::with('client')->findOrFail($id);
        return view('penjamin.show', compact('guarantor'));
    }
}