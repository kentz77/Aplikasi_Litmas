@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto bg-white rounded-xl shadow p-6">

    <h2 class="text-xl font-semibold mb-6">
        Tambah User
    </h2>

    {{-- Error Validation --}}
    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-100 p-4 text-red-700">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Nama --}}
        <div>
            <label class="block text-sm font-medium mb-1">Nama</label>
            <input type="text" name="name"
                   value="{{ old('name') }}"
                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                   required>
        </div>

        {{-- Username --}}
        <div>
            <label class="block text-sm font-medium mb-1">Username</label>
            <input type="text" name="username"
                   value="{{ old('username') }}"
                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                   required>
        </div>

        {{-- Password --}}
        <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password"
                   class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                   required>
        </div>

        {{-- Role --}}
        <div>
            <label class="block text-sm font-medium mb-1">Role</label>
            <select name="role"
                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    required>
                <option value="">-- Pilih Role --</option>
                <option value="admin">Admin</option>
                <option value="superuser">Super User</option>
                <option value="user">User</option>
            </select>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('users.index') }}"
               class="px-4 py-2 rounded-lg border text-gray-700 hover:bg-gray-100">
                Batal
            </a>

            <button type="submit"
                    class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                Simpan
            </button>
        </div>

    </form>
</div>

@endsection
