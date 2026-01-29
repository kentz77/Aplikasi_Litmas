<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // =========================
    // LIST + SEARCH + PAGINATION
    // =========================
    public function index(Request $request)
    {
        $search  = $request->search;
        $perPage = $request->per_page ?? 10; // default 10

        $users = User::when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('username', 'like', "%{$search}%");
            })
            ->orderBy('role')
            ->paginate($perPage)
            ->withQueryString(); // agar search & per_page ikut pagination

        return view('users.index', compact('users', 'search', 'perPage'));
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,superuser,user',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    // =========================
    // EDIT
    // =========================
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // =========================
    // UPDATE + EDIT PASSWORD
    // =========================
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'role'     => 'required|in:admin,superuser,user',
            'password' => 'nullable|min:6',
        ]);

        $user->name     = $request->name;
        $user->username = $request->username;
        $user->role     = $request->role;

        // 🔐 password hanya berubah jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    // =========================
    // RESET PASSWORD
    // =========================
    public function resetPassword(User $user)
    {
        // admin tidak boleh reset password sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak bisa reset password sendiri');
        }

        $user->update([
            'password' => Hash::make('password123'),
        ]);

        return back()->with('success', 'Password direset ke: password123');
    }

    // =========================
    // DELETE USER
    // =========================
    public function destroy(User $user)
    {
        // admin tidak bisa hapus diri sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }
}