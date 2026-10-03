<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\SuratPengantarController;
use App\Http\Controllers\LaporanWargaController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Authenticated Routes
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/transparansi', [DashboardController::class, 'transparansi'])->name('transparansi')->middleware('role:warga');

    // Surat Pengantar (Warga)
    Route::middleware('role:warga')->group(function () {
        Route::get('/surat-pengantar', [SuratPengantarController::class, 'index'])->name('surat-pengantar.index');
        Route::post('/surat-pengantar', [SuratPengantarController::class, 'store'])->name('surat-pengantar.store');
    });

    // Surat Pengantar (Cetak & Approval)
    Route::get('/surat-pengantar/{suratPengantar}/cetak', [SuratPengantarController::class, 'cetak'])->name('surat-pengantar.cetak');
    Route::middleware('role:admin,ketua_rt')->group(function () {
        Route::get('/surat-pengantar/approval', [SuratPengantarController::class, 'approvalIndex'])->name('surat-pengantar.approval');
        Route::post('/surat-pengantar/{suratPengantar}/setujui', [SuratPengantarController::class, 'approve'])->name('surat-pengantar.approve');
        Route::post('/surat-pengantar/{suratPengantar}/tolak', [SuratPengantarController::class, 'reject'])->name('surat-pengantar.reject');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Pengumuman Management (Admin & Ketua RT) - Must precede wildcard routes
    Route::middleware('role:admin,ketua_rt')->group(function () {
        Route::get('/pengumuman/create', [PengumumanController::class, 'create'])->name('pengumuman.create');
        Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
        Route::get('/pengumuman/{pengumuman}/edit', [PengumumanController::class, 'edit'])->name('pengumuman.edit');
        Route::put('/pengumuman/{pengumuman}', [PengumumanController::class, 'update'])->name('pengumuman.update');
        Route::delete('/pengumuman/{pengumuman}', [PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
    });

    // Pengumuman - View accessible by all
    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('/pengumuman/{pengumuman}', [PengumumanController::class, 'show'])->name('pengumuman.show');

    // Laporan - accessible by admin, bendahara, ketua_rt
    Route::middleware('role:admin,bendahara,ketua_rt')->prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/pemasukan', [LaporanController::class, 'pemasukan'])->name('pemasukan');
        Route::get('/pengeluaran', [LaporanController::class, 'pengeluaran'])->name('pengeluaran');
        Route::get('/pembayaran', [LaporanController::class, 'pembayaran'])->name('pembayaran');
        Route::post('/pembayaran/generate', [LaporanController::class, 'generateTagihan'])->name('generate-tagihan');
    });

    // Upload Bukti Pembayaran (Warga)
    Route::middleware('role:warga')->group(function () {
        Route::post('/pembayaran/{pembayaran}/upload-bukti', [PembayaranController::class, 'uploadBukti'])->name('pembayaran.upload-bukti');
    });

    // Pelaporan/Tiket Warga
    Route::middleware('role:warga')->group(function () {
        Route::get('/pelaporan', [LaporanWargaController::class, 'wargaIndex'])->name('pelaporan.warga');
        Route::post('/pelaporan', [LaporanWargaController::class, 'store'])->name('pelaporan.store');
    });

    Route::middleware('role:admin,ketua_rt')->group(function () {
        Route::get('/pelaporan/kelola', [LaporanWargaController::class, 'adminIndex'])->name('pelaporan.kelola');
        Route::post('/pelaporan/{laporan}/status', [LaporanWargaController::class, 'updateStatus'])->name('pelaporan.status');
    });

    // Keuangan (Pemasukan & Pengeluaran CRUD) - Admin & Bendahara
    Route::middleware('role:admin,bendahara')->group(function () {
        Route::resource('pemasukan', PemasukanController::class)->except(['show']);
        Route::resource('pengeluaran', PengeluaranController::class)->except(['show']);

        // Verifikasi Bukti Pembayaran
        Route::get('/pembayaran/verifikasi', [PembayaranController::class, 'verifikasi'])->name('pembayaran.verifikasi');
        Route::post('/pembayaran/{pembayaran}/lunas', [PembayaranController::class, 'lunas'])->name('pembayaran.lunas');
        Route::post('/pembayaran/{pembayaran}/tolak', [PembayaranController::class, 'tolak'])->name('pembayaran.tolak');
    });

    // Data Warga - List (Admin & Ketua RT)
    Route::middleware('role:admin,ketua_rt')->group(function () {
        Route::get('/warga', [WargaController::class, 'index'])->name('warga.index');
    });

    // Data Warga - Management (Admin Only) - Must precede /warga/{warga}
    Route::middleware('role:admin')->group(function () {
        Route::get('/warga/create', [WargaController::class, 'create'])->name('warga.create');
        Route::post('/warga', [WargaController::class, 'store'])->name('warga.store');
        Route::get('/warga/{warga}/edit', [WargaController::class, 'edit'])->name('warga.edit');
        Route::put('/warga/{warga}', [WargaController::class, 'update'])->name('warga.update');
        Route::delete('/warga/{warga}', [WargaController::class, 'destroy'])->name('warga.destroy');

        // User Management
        Route::resource('users', UserController::class)->except(['show']);
        Route::put('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    });

    // Data Warga - Show (Admin & Ketua RT)
    Route::middleware('role:admin,ketua_rt')->group(function () {
        Route::get('/warga/{warga}', [WargaController::class, 'show'])->name('warga.show');
    });
});
