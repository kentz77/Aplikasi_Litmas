@extends('layouts.app')

@section('content')

{{-- HEADER --}}
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Manajemen User</h1>

    <a href="{{ route('users.create') }}"
       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        + Tambah User
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

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">

{{-- SEARCH --}}
<form method="GET" class="mb-4">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cari nama / username..."
           class="px-3 py-2 border rounded-lg w-64">
</form>

<!-- PER PAGE -->
    <form method="GET">
        <input type="hidden" name="search" value="{{ $search }}">

        <select name="per_page"
                onchange="this.form.submit()"
                class="px-3 py-2 border rounded-lg">
            @foreach([10,15,20,30,50] as $size)
                <option value="{{ $size }}" {{ $perPage == $size ? 'selected' : '' }}>
                    {{ $size }}
                </option>
            @endforeach
        </select>
    </form>

</div>

{{-- TABLE --}}
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full border-collapse">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold">No</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Nama</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Username</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Role</th>
                <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($users as $user)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3">{{ $user->name }}</td>
                    <td class="px-4 py-3">{{ $user->username }}</td>

                    {{-- BADGE ROLE --}}
                    <td class="px-4 py-3">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                            @if($user->role === 'admin') bg-red-100 text-red-700
                            @elseif($user->role === 'superuser') bg-yellow-100 text-yellow-700
                            @else bg-green-100 text-green-700
                            @endif">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>

                    {{-- AKSI --}}
                    <td class="px-4 py-3 flex gap-3">
                        {{-- EDIT --}}
                        <a href="{{ route('users.edit', $user) }}"
                           class="text-blue-600 hover:underline">
                            ✏️ Edit
                        </a>

                        {{-- RESET PASSWORD --}}
                        <form method="POST"
                              action="{{ route('users.reset-password', $user) }}"
                              onsubmit="return confirm('Reset password user ini?')">
                            @csrf
                            <button type="submit"
                                    class="text-gray-600 hover:underline">
                                🔁 Reset
                            </button>
                        </form>

                        {{-- DELETE (TIDAK BOLEH HAPUS DIRI SENDIRI) --}}
                        @if(auth()->id() !== $user->id)
                            <form method="POST"
                                  action="{{ route('users.destroy', $user) }}"
                                  onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:underline">
                                    🗑️ Hapus
                                </button>
                            </form>
                        @else
                            <span class="text-gray-400 text-sm italic">
                                (Akun sendiri)
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5"
                        class="px-4 py-6 text-center text-gray-500">
                        Belum ada user
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- PAGINATION --}}
<div class="mt-4">
    {{ $users->links() }}
</div>

@endsection
