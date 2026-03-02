@extends('layouts.app')

@section('content')
<div class="content-wrapper">
<section class="content">
<div class="container-fluid">

<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Edit Pasal</h3>
    </div>

    <form action="{{ route('pasal.update', $pasal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="form-group">
                <label>Nomor Pasal</label>
                <input type="text" name="nomor_pasal"
                       value="{{ $pasal->nomor_pasal }}"
                       class="form-control" required>
            </div>

            <div class="form-group">
                <label>Judul</label>
                <input type="text" name="judul"
                       value="{{ $pasal->judul }}"
                       class="form-control">
            </div>

            <hr>
            <h5>Daftar Ayat</h5>

            <div id="ayat-container">

                @foreach($pasal->ayats as $i => $ayat)
                    <div class="ayat-item border p-3 mb-3">

                        <input type="hidden"
                               name="ayat[{{ $i }}][id]"
                               value="{{ $ayat->id }}">

                        <div class="form-group">
                            <label>Nomor Ayat</label>
                            <input type="text"
                                   name="ayat[{{ $i }}][nomor]"
                                   value="{{ $ayat->nomor_ayat }}"
                                   class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Isi</label>
                            <textarea name="ayat[{{ $i }}][isi]"
                                      class="form-control"
                                      rows="3" required>{{ $ayat->isi }}</textarea>
                        </div>

                        <button type="button"
                                class="btn btn-danger btn-sm"
                                onclick="hapusAyat(this)">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                @endforeach

            </div>

            <button type="button"
                    class="btn btn-secondary btn-sm"
                    onclick="tambahAyat()">
                <i class="fas fa-plus"></i> Tambah Ayat
            </button>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-warning">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('pasal.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>

</div>
</section>
</div>

<script>
let index = {{ $pasal->ayats->count() }};

function tambahAyat() {
    let container = document.getElementById('ayat-container');

    let html = `
        <div class="ayat-item border p-3 mb-3">
            <div class="form-group">
                <label>Nomor Ayat</label>
                <input type="text" name="ayat[${index}][nomor]" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Isi</label>
                <textarea name="ayat[${index}][isi]" class="form-control" rows="3" required></textarea>
            </div>

            <button type="button"
                    class="btn btn-danger btn-sm"
                    onclick="hapusAyat(this)">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
    index++;
}

function hapusAyat(button) {
    button.parentElement.remove();
}
</script>

@endsection