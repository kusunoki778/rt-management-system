<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Aktivitas;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengumuman::with('creator');

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('judul', 'like', "%$q%")->orWhere('isi', 'like', "%$q%");
            });
        }

        if (auth()->user()->isWarga()) {
            $query->where('status', 'published');
        } elseif ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengumuman = $query->orderByDesc('is_pinned')->latest()->paginate(10)->withQueryString();

        return view('pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('pengumuman.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'is_pinned' => ['boolean'],
        ]);

        $validated['created_by'] = auth()->id();
        $validated['is_pinned'] = $request->boolean('is_pinned');

        if ($validated['status'] === 'published') {
            $validated['tanggal_publish'] = Carbon::now();
        }

        $pengumuman = Pengumuman::create($validated);

        Aktivitas::log('Buat Pengumuman', "Pengumuman baru: {$pengumuman->judul}");

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function show(Pengumuman $pengumuman)
    {
        if (auth()->user()->isWarga() && $pengumuman->status !== 'published') {
            abort(404);
        }

        return view('pengumuman.show', compact('pengumuman'));
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'is_pinned' => ['boolean'],
        ]);

        $validated['is_pinned'] = $request->boolean('is_pinned');

        if ($validated['status'] === 'published' && $pengumuman->status === 'draft') {
            $validated['tanggal_publish'] = Carbon::now();
        }

        $pengumuman->update($validated);
        Aktivitas::log('Edit Pengumuman', "Pengumuman diperbarui: {$pengumuman->judul}");

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $judul = $pengumuman->judul;
        $pengumuman->delete();
        Aktivitas::log('Hapus Pengumuman', "Pengumuman dihapus: {$judul}");

        return redirect()->route('pengumuman.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
