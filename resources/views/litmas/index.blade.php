@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- =========================
        MODE 1: PILIH JENIS
    ========================== --}}
    @if(!$jenis)

        <h1 class="text-2xl font-semibold mb-2">
            Buat Litmas Baru
        </h1>

        <p class="text-gray-600 mb-6">
            Pilih jenis Litmas yang akan dibuat
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <a href="{{ route('litmas.index', ['jenis' => 'anak']) }}"
               class="block p-6 bg-white rounded-lg shadow hover:shadow-md transition">
                <h2 class="text-lg font-semibold">Litmas Anak</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Anak < 12 Tahun, Diversi, Sidang Anak
                </p>
            </a>

            <a href="{{ route('litmas.index', ['jenis' => 'dewasa']) }}"
               class="block p-6 bg-white rounded-lg shadow hover:shadow-md transition">
                <h2 class="text-lg font-semibold">Litmas Dewasa</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Tersangka & Tahanan Dewasa
                </p>
            </a>

            <a href="{{ route('litmas.index', ['jenis' => 'awal']) }}"
               class="block p-6 bg-white rounded-lg shadow hover:shadow-md transition">
                <h2 class="text-lg font-semibold">Litmas Awal/Pembinaan</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Pembinaan & Rehabilitasi
                </p>
            </a>

        </div>

    {{-- =========================
        MODE 2: PILIH KATEGORI
    ========================== --}}
    @else

        <h1 class="text-2xl font-semibold mb-2 capitalize">
            Litmas {{ str_replace('_',' ', $jenis) }}
        </h1>

        <p class="text-gray-600 mb-6">
            Pilih jenis layanan
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- PB -->
            <a href="{{ route('litmas.form', [
                'jenis_litmas' => $jenis,
                'kategori' => 'pembebasan_bersyarat'
            ]) }}"
            class="block p-6 bg-white rounded-lg shadow hover:shadow-md transition">

                <h2 class="text-lg font-semibold">
                    Pembebasan Bersyarat
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Proses pembebasan sebelum masa pidana selesai
                </p>

            </a>

            <!-- CB -->
            <a href="{{ route('litmas.form', [
                'jenis_litmas' => $jenis,
                'kategori' => 'cuti_bersyarat'
            ]) }}"
            class="block p-6 bg-white rounded-lg shadow hover:shadow-md transition">

                <h2 class="text-lg font-semibold">
                    Cuti Bersyarat
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Cuti dengan syarat tertentu
                </p>

            </a>

        </div>

        {{-- FORM --}}
        <form id="pb-form" action="{{ route('litmas.form') }}" method="GET">
            @csrf
            <input type="hidden" name="jenis_litmas" value="{{ $jenis }}">
            <input type="hidden" name="kategori" value="pembebasan_bersyarat">
        </form>

        <form id="cb-form" action="{{ route('litmas.form') }}" method="GET">
            @csrf
            <input type="hidden" name="jenis_litmas" value="{{ $jenis }}">
            <input type="hidden" name="kategori" value="cuti_bersyarat">
        </form>

    @endif

    {{-- BACK --}}
    <a href="{{ route('litmas.index') }}"
       class="fixed bottom-6 left-10 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
        ← Kembali
    </a>

</div>
@endsection