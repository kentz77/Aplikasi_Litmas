@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">

    <h1 class="text-2xl font-semibold mb-2">
        Buat Litmas Baru
    </h1>
    <p class="text-gray-600 mb-6">
        Pilih jenis Litmas yang akan dibuat
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Litmas Anak -->
        <a href="{{ route('litmas.store') }}"
           onclick="event.preventDefault(); document.getElementById('litmas-anak').submit();"
           class="block p-6 bg-white rounded-lg shadow hover:shadow-md transition">
            <h2 class="text-lg font-semibold">Litmas Anak</h2>
            <p class="text-sm text-gray-500 mt-1">
                Anak < 12 Tahun, Diversi, Sidang Anak
            </p>
        </a>

        <!-- Litmas Dewasa -->
        <a href="{{ route('litmas.store') }}"
           onclick="event.preventDefault(); document.getElementById('litmas-dewasa').submit();"
           class="block p-6 bg-white rounded-lg shadow hover:shadow-md transition">
            <h2 class="text-lg font-semibold">Litmas Dewasa</h2>
            <p class="text-sm text-gray-500 mt-1">
                Tersangka & Tahanan Dewasa
            </p>
        </a>

        <!-- Litmas Saksi/Korban -->
        <a href="{{ route('litmas.store') }}"
           onclick="event.preventDefault(); document.getElementById('litmas-saksi').submit();"
           class="block p-6 bg-white rounded-lg shadow hover:shadow-md transition">
            <h2 class="text-lg font-semibold">Litmas Saksi / Korban</h2>
            <p class="text-sm text-gray-500 mt-1">
                Perlindungan & Rehabilitasi
            </p>
        </a>

    </div>

    <!-- FORM HIDDEN -->
    <form id="litmas-anak" action="{{ route('litmas.store') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="jenis_litmas" value="anak">
    </form>

    <form id="litmas-dewasa" action="{{ route('litmas.store') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="jenis_litmas" value="dewasa">
    </form>

    <form id="litmas-saksi" action="{{ route('litmas.store') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="jenis_litmas" value="saksi_korban">
    </form>

    <!-- TOMBOL KEMBALI -->
    <a href="{{ route('dashboard') }}"
   class="btn-secondary-outline fixed bottom-6 left-30">
    ← Kembali
</a>

</div>
@endsection
