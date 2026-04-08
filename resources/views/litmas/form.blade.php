@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-xl font-bold mb-4">
        Form Litmas {{ $jenis }} - {{ str_replace('_',' ', $kategori) }}
    </h2>

    <form action="{{ route('litmas.preview') }}" method="POST">
        @csrf

        <input type="hidden" name="jenis_litmas" value="{{ $jenis }}">
        <input type="hidden" name="kategori" value="{{ $kategori }}">

        {{-- DATA KLIEN --}}
        <div class="mb-4">
            <label>Nama Klien</label>
            <input type="text" name="nama_klien" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="w-full border px-3 py-2 rounded">
        </div>

        {{-- PENJAMIN --}}
        <div class="mb-4">
            <label>Nama Penjamin</label>
            <input type="text" name="nama_penjamin" class="w-full border px-3 py-2 rounded">
        </div>

        {{-- DASAR HUKUM --}}
        <div class="mb-4">
            <label>Dasar Hukum</label>
            <textarea name="dasar_hukum" class="w-full border px-3 py-2 rounded"></textarea>
        </div>

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded">
            Preview Litmas
        </button>

    </form>

</div>
@endsection