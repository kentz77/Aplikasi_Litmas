@extends('layouts.app')

@section('content')
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">
            Detail Pasal {{ $pasal->nomor_pasal }}
        </h3>
    </div>

    <div class="card-body">

        <p><strong>Judul:</strong> {{ $pasal->judul ?? '-' }}</p>

        <hr>
        <h5>Daftar Ayat</h5>

        @forelse($pasal->ayats as $ayat)
            <div class="border p-3 mb-3">
                <strong>Ayat ({{ $ayat->nomor_ayat }})</strong>
                <p class="mb-0">{{ $ayat->isi }}</p>
            </div>
        @empty
            <p>Tidak ada ayat.</p>
        @endforelse

    </div>

    <div class="card-footer">
        <a href="{{ route('pasal.edit', $pasal->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('pasal.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>

</div>

</div>
</section>
</div>
@endsection