@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">

    <h1 class="text-2xl font-semibold mb-2 capitalize">
        Litmas {{ str_replace('_',' ', $jenis) }}
    </h1>

    <p class="text-gray-600 mb-6">
        Pilih jenis layanan
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Pembebasan Bersyarat -->
        <a href="#"
           onclick="event.preventDefault(); document.getElementById('pb-form').submit();"
           class="block p-6 bg-white rounded-lg shadow hover:shadow-md transition">

            <h2 class="text-lg font-semibold">
                Pembebasan Bersyarat
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Proses pembebasan sebelum masa pidana selesai
            </p>

        </a>

        <!-- Cuti Bersyarat -->
        <a href="#"
           onclick="event.preventDefault(); document.getElementById('cb-form').submit();"
           class="block p-6 bg-white rounded-lg shadow hover:shadow-md transition">

            <h2 class="text-lg font-semibold">
                Cuti Bersyarat
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Cuti dengan syarat tertentu bagi warga binaan
            </p>

        </a>

    </div>

    <!-- FORM HIDDEN -->
    <form id="pb-form" action="{{ route('litmas.store') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="jenis_litmas" value="{{ $jenis }}">
        <input type="hidden" name="kategori" value="pembebasan_bersyarat">
    </form>

    <form id="cb-form" action="{{ route('litmas.store') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="jenis_litmas" value="{{ $jenis }}">
        <input type="hidden" name="kategori" value="cuti_bersyarat">
    </form>

    <!-- BACK -->
    <a href="{{ route('litmas.index') }}"
       class="fixed bottom-6 left-10 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
        ← Kembali
    </a>

</div>
@endsection