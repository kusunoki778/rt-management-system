<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warga;
use App\Models\Aktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('warga');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('name', 'like', "%$q%")->orWhere('email', 'like', "%$q%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $wargas = Warga::orderBy('nama')->get();
        return view('users.create', compact('wargas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,bendahara,ketua_rt,warga'],
            'warga_id' => ['nullable', 'exists:warga,id'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        Aktivitas::log('Tambah User', "User baru ditambahkan: {$user->name} ({$user->role})");

        return redirect()->route('users.index')->with('success', 'Akun pengguna berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $wargas = Warga::orderBy('nama')->get();
        return view('users.edit', compact('user', 'wargas'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:admin,bendahara,ketua_rt,warga'],
            'warga_id' => ['nullable', 'exists:warga,id'],
        ]);

        $user->update($validated);
        Aktivitas::log('Edit User', "Data user diperbarui: {$user->name}");

        return redirect()->route('users.index')->with('success', 'Akun pengguna berhasil diperbarui.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $user->update(['password' => Hash::make($request->password)]);
        Aktivitas::log('Reset Password User', "Password user di-reset: {$user->name}");

        return back()->with('success', 'Password berhasil direset.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $nama = $user->name;
        $user->delete();
        Aktivitas::log('Hapus User', "User dihapus: {$nama}");

        return redirect()->route('users.index')->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
