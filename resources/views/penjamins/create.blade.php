@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-2xl font-bold mb-4">Tambah Data Penjamin</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('penjamin.store') }}">
        @csrf

        {{-- PILIH KLIEN --}}
        <div class="mb-6">
            <label class="font-semibold">Pilih Klien</label>
            <select name="client_id" class="w-full border rounded px-3 py-2 mt-1" required>
                <option value="">-- Pilih Klien --</option>
                @foreach($clients as $c)
                    <option value="{{ $c->id }}">{{ $c->nama }}</option>
                @endforeach
            </select>
        </div>

        <hr class="my-4">

        <div id="penjamin-wrapper">

            <!-- PENJAMIN 1 -->
            <div class="penjamin-item border rounded p-4 mb-4">
                <h3 class="font-bold text-lg mb-3">Penjamin 1</h3>

                <div class="grid grid-cols-2 gap-3">

                    <input type="text" name="penjamin[0][nama]" placeholder="Nama" class="border p-2 rounded" required>

                    <input type="text" name="penjamin[0][no_kk]" placeholder="No KK" class="border p-2 rounded">

                    <input type="text" name="penjamin[0][tempat_lahir]" placeholder="Tempat Lahir" class="border p-2 rounded">

                    <input type="date" name="penjamin[0][tanggal_lahir]" onchange="isiUmur(this)" class="border p-2 rounded" required>

                    <input type="number" name="penjamin[0][usia]" placeholder="Usia" class="border p-2 rounded bg-gray-100" readonly>

                    <select name="penjamin[0][agama]" class="border p-2 rounded">
                        <option value="">Agama</option>
                        <option>Islam</option>
                        <option>Kristen</option>
                        <option>Katolik</option>
                        <option>Hindu</option>
                        <option>Buddha</option>
                        <option>Konghucu</option>
                    </select>

                    <input type="text" name="penjamin[0][suku]" placeholder="Suku" class="border p-2 rounded">

                    <input type="text" name="penjamin[0][kewarganegaraan]" value="Indonesia" class="border p-2 rounded">

                    <input type="text" name="penjamin[0][pendidikan_terakhir]" placeholder="Pendidikan Terakhir" class="border p-2 rounded">

                    <input type="text" name="penjamin[0][pekerjaan]" placeholder="Pekerjaan" class="border p-2 rounded">

                    <select name="penjamin[0][hubungan_keluarga]" class="border p-2 rounded" required>
                        <option value="">Hubungan Keluarga</option>
                        <option>Ayah Kandung</option>
                        <option>Ibu Kandung</option>
                        <option>Saudara Kandung</option>
                        <option>Suami</option>
                        <option>Istri</option>
                    </select>

                </div>

                <textarea name="penjamin[0][alamat]" placeholder="Alamat lengkap" class="border p-2 rounded w-full mt-3"></textarea>
            </div>

        </div>

        <div class="flex gap-3 mt-4">
            <button type="button" onclick="tambahPenjamin()" class="bg-blue-500 text-white px-4 py-2 rounded">
                + Tambah Penjamin
            </button>

            <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded">
                Simpan
            </button>
        </div>

    </form>
</div>

<script>
let index = 1;

function tambahPenjamin(){

    let html = `
    <div class="penjamin-item border rounded p-4 mb-4">
        <h3 class="font-bold text-lg mb-3">Penjamin ${index+1}</h3>

        <div class="grid grid-cols-2 gap-3">

            <input type="text" name="penjamin[${index}][nama]" placeholder="Nama" class="border p-2 rounded" required>

            <input type="text" name="penjamin[${index}][no_kk]" placeholder="No KK" class="border p-2 rounded">

            <input type="text" name="penjamin[${index}][tempat_lahir]" placeholder="Tempat Lahir" class="border p-2 rounded">

            <input type="date" name="penjamin[${index}][tanggal_lahir]" onchange="isiUmur(this)" class="border p-2 rounded" required>

            <input type="number" name="penjamin[${index}][usia]" placeholder="Usia" class="border p-2 rounded bg-gray-100" readonly>

            <select name="penjamin[${index}][agama]" class="border p-2 rounded">
                <option value="">Agama</option>
                <option>Islam</option>
                <option>Kristen</option>
                <option>Katolik</option>
                <option>Hindu</option>
                <option>Buddha</option>
                <option>Konghucu</option>
            </select>

            <input type="text" name="penjamin[${index}][suku]" placeholder="Suku" class="border p-2 rounded">

            <input type="text" name="penjamin[${index}][kewarganegaraan]" value="Indonesia" class="border p-2 rounded">

            <input type="text" name="penjamin[${index}][pendidikan_terakhir]" placeholder="Pendidikan Terakhir" class="border p-2 rounded">

            <input type="text" name="penjamin[${index}][pekerjaan]" placeholder="Pekerjaan" class="border p-2 rounded">

            <select name="penjamin[${index}][hubungan_keluarga]" class="border p-2 rounded" required>
                <option value="">Hubungan Keluarga</option>
                <option>Ayah Kandung</option>
                <option>Ibu Kandung</option>
                <option>Saudara Kandung</option>
                <option>Suami</option>
                <option>Istri</option>
            </select>

        </div>

        <textarea name="penjamin[${index}][alamat]" placeholder="Alamat lengkap" class="border p-2 rounded w-full mt-3"></textarea>

        <button type="button" onclick="hapusPenjamin(this)" class="mt-3 bg-red-500 text-white px-3 py-1 rounded">
            Hapus
        </button>
    </div>
    `;

    document.getElementById('penjamin-wrapper').insertAdjacentHTML('beforeend',html);
    index++;
}

function hapusPenjamin(btn){
    btn.closest('.penjamin-item').remove();
}

function isiUmur(input){

    let tgl = new Date(input.value);
    let today = new Date();

    let umur = today.getFullYear() - tgl.getFullYear();
    let m = today.getMonth() - tgl.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < tgl.getDate())) umur--;

    let usiaField = input.closest('.penjamin-item').querySelector('[name*="[usia]"]');
    usiaField.value = umur;

    if(umur < 18){
        alert("Penjamin minimal berusia 18 tahun");
        input.value="";
        usiaField.value="";
    }
}
</script>
@endsection