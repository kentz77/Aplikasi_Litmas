@extends('layouts.app')

@section('content')

{{-- HEADER --}}
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Data Dasar Hukum</h1>

    <a href="{{ route('pasal.create') }}"
       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition w-fit">
        + Tambah Pasal
    </a>
</div>

{{-- FLASH MESSAGE --}}
@if(session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-700">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-3 rounded bg-red-100 text-red-700">
        {{ session('error') }}
    </div>
@endif

{{-- FILTER --}}
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">

    {{-- SEARCH --}}
    <form method="GET">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari nomor atau judul pasal..."
               class="px-3 py-2 border rounded-lg w-64">
    </form>

    {{-- PER PAGE --}}
    <form method="GET">
        <input type="hidden" name="search" value="{{ request('search') }}">
        <select name="per_page"
                onchange="this.form.submit()"
                class="px-3 py-2 pr-8 border rounded-lg">
            @foreach([10,15,20,30,50] as $size)
                <option value="{{ $size }}" {{ $perPage == $size ? 'selected' : '' }}>
                    {{ $size }}
                </option>
            @endforeach
        </select>
    </form>

</div>

{{-- TABLE --}}
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Nomor Pasal</th>
                <th class="px-4 py-3 text-left">Judul</th>
                <th class="px-4 py-3 text-left">Jumlah Ayat</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse ($pasals as $pasal)
                <tr class="hover:bg-gray-50">

                    {{-- Nomor urut pagination --}}
                    <td class="px-4 py-3">
                        {{ ($pasals->currentPage() - 1) * $pasals->perPage() + $loop->iteration }}
                    </td>

                    <td class="px-4 py-3 font-semibold text-gray-800">
                        Pasal {{ $pasal->nomor_pasal }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $pasal->judul ?? '-' }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $pasal->ayats->count() }} Ayat
                    </td>

                    {{-- AKSI --}}
                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center gap-3">

                            <a href="{{ route('pasal.show', $pasal) }}"
                               class="text-blue-600 hover:underline">
                                Detail
                            </a>

                            <a href="{{ route('pasal.edit', $pasal) }}"
                               class="text-green-600 hover:underline">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('pasal.destroy', $pasal) }}"
                                  onsubmit="return confirm('Hapus pasal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:underline">
                                    Hapus
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="5"
                        class="px-6 py-8 text-center text-gray-500">
                        Data pasal belum tersedia
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- PAGINATION --}}
<div class="mt-4">
    {{ $pasals->links() }}
</div>

@endsection