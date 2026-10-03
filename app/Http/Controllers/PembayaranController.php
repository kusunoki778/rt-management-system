<?php

namespace App\Http\Controllers;

use App\Models\PembayaranBulanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function uploadBukti(Request $request, PembayaranBulanan $pembayaran)
    {
        $request->validate([
            'bukti_bayar' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $warga = auth()->user()->warga;

        if (! $warga || $pembayaran->warga_id !== $warga->id) {
            abort(403);
        }

        if ($pembayaran->status === 'lunas') {
            return back()->with('error', 'Tagihan ini sudah lunas.');
        }

        // Hapus bukti lama jika ada (opsional, untuk menghemat storage)
        if ($pembayaran->bukti_bayar_path && Storage::disk('public')->exists($pembayaran->bukti_bayar_path)) {
            Storage::disk('public')->delete($pembayaran->bukti_bayar_path);
        }

        $path = $request->file('bukti_bayar')->store('bukti_bayar', 'public');

        $pembayaran->update([
            'bukti_bayar_path' => $path,
            'status' => 'menunggu_verifikasi',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi bendahara.');
    }

    public function verifikasi()
    {
        $buktiPembayaran = PembayaranBulanan::with('warga')
            ->where('status', 'menunggu_verifikasi')
            ->latest('updated_at')
            ->get();

        return view('pembayaran.verifikasi', compact('buktiPembayaran'));
    }

    public function lunas(PembayaranBulanan $pembayaran)
    {
        $pembayaran->update([
            'status' => 'lunas',
            'tanggal_bayar' => now(),
        ]);

        return back()->with('success', "Pembayaran {$pembayaran->jenis_iuran} untuk {$pembayaran->warga->nama} ditandai lunas.");
    }

    public function tolak(PembayaranBulanan $pembayaran)
    {
        $pembayaran->update([
            'status' => 'belum_bayar',
            'tanggal_bayar' => null,
        ]);

        return back()->with('error', "Bukti pembayaran {$pembayaran->warga->nama} ditolak. Warga harus upload ulang.");
    }
}
