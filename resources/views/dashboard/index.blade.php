@extends('layouts.app')
@section('title', 'Dashboard Executive · RT Management System')
@section('page-title', 'Dashboard Ringkasan')

@section('content')
<div class="space-y-6">

    <!-- Top Banner Header -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200/60 w-fit mb-2">
                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Lingkungan RT 05 / RW 02</span>
            </div>
            <h2 class="text-xl font-bold text-slate-900 tracking-tight">Selamat Datang, {{ auth()->user()->name }}</h2>
            <p class="text-xs text-slate-500 mt-0.5">Ringkasan statistik kependudukan dan keuangan RT periode {{ now()->translatedFormat('F Y') }}</p>
        </div>

        <div class="flex items-center gap-2">
            @if(auth()->user()->isAdmin())
            <a href="{{ route('warga.create') }}" class="btn-white">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                <span>Tambah Warga</span>
            </a>
            @endif
            @if(auth()->user()->isAdmin() || auth()->user()->isBendahara())
            <a href="{{ route('pemasukan.create') }}" class="btn-emerald">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                <span>Catat Transaksi</span>
            </a>
            @endif
        </div>
    </div>

    <!-- Executive KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
        <!-- Metric 1: Total Warga -->
        <div class="card-panel flex items-start justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Warga Aktif</p>
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ number_format($totalWarga) }}</h3>
                <p class="text-[11px] font-medium text-slate-400 mt-1">Terdaftar di sistem RT</p>
            </div>
            <div class="w-11 h-11 bg-slate-100 rounded-xl flex items-center justify-center text-slate-700 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>

        <!-- Metric 2: Total Pemasukan -->
        <div class="card-panel flex items-start justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Pemasukan Tahun {{ date('Y') }}</p>
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Rp {{ number_format($totalPemasukan/1000, 0, ',', '.') }}K</h3>
                <p class="text-[11px] font-semibold text-emerald-600 mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    Total Akumulasi
                </p>
            </div>
            <div class="w-11 h-11 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <!-- Metric 3: Total Pengeluaran -->
        <div class="card-panel flex items-start justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Pengeluaran Tahun {{ date('Y') }}</p>
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Rp {{ number_format($totalPengeluaran/1000, 0, ',', '.') }}K</h3>
                <p class="text-[11px] font-semibold text-rose-600 mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                    Total Alokasi Kas
                </p>
            </div>
            <div class="w-11 h-11 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
        </div>

        <!-- Metric 4: Saldo Kas -->
        <div class="card-panel flex items-start justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Saldo Kas RT Saat Ini</p>
                <h3 class="text-2xl font-extrabold {{ $saldoKas >= 0 ? 'text-slate-900' : 'text-rose-600' }} tracking-tight">
                    Rp {{ number_format(abs($saldoKas)/1000, 0, ',', '.') }}K
                </h3>
                <p class="text-[11px] font-semibold {{ $saldoKas >= 0 ? 'text-emerald-600' : 'text-rose-600' }} mt-1">
                    Status: {{ $saldoKas >= 0 ? 'Surplus Operasional' : 'Defisit Kas' }}
                </p>
            </div>
            <div class="w-11 h-11 {{ $saldoKas >= 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
            </div>
        </div>
    </div>

    <!-- Charts & Unpaid Dues Section -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- Main Chart Card -->
        <div class="xl:col-span-2 card-panel">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 tracking-tight">Grafik Financial Control</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Perbandingan Pemasukan & Pengeluaran 6 Bulan Terakhir</p>
                </div>
                <div class="flex items-center gap-4 text-xs font-medium">
                    <div class="flex items-center gap-2"><div class="w-3 h-3 rounded bg-emerald-600"></div><span class="text-slate-600">Pemasukan</span></div>
                    <div class="flex items-center gap-2"><div class="w-3 h-3 rounded bg-rose-500"></div><span class="text-slate-600">Pengeluaran</span></div>
                </div>
            </div>
            <div class="h-64">
                <canvas id="keuanganChart"></canvas>
            </div>
        </div>

        <!-- Unpaid Dues List -->
        <div class="card-panel flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 tracking-tight">Warga Belum Bayar Kas</h3>
                        <p class="text-xs text-slate-400">Bulan {{ now()->translatedFormat('F Y') }}</p>
                    </div>
                    <span class="badge-status badge-rose">{{ $wargaBelumBayar }} Warga</span>
                </div>

                <div class="space-y-2.5">
                    @forelse($belumBayarList as $bp)
                    <div class="flex items-center justify-between p-2.5 bg-slate-50/80 rounded-xl border border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 bg-white rounded-lg border border-slate-200 flex items-center justify-center text-xs font-bold text-slate-700">
                                {{ strtoupper(substr($bp->warga->nama ?? 'W', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-800">{{ $bp->warga->nama ?? '-' }}</p>
                                <p class="text-[11px] text-slate-400">Rumah No. {{ $bp->warga->nomor_rumah ?? '-' }}</p>
                            </div>
                        </div>
                        <span class="text-[11px] font-semibold text-rose-600 bg-rose-50 px-2 py-0.5 rounded border border-rose-200/60">Tunggakan</span>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <p class="text-xs font-bold text-slate-800">Semua Warga Sudah Lunas</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">Tidak ada penunggakan iuran bulan ini</p>
                    </div>
                    @endforelse
                </div>
            </div>

            @if(!auth()->user()->isWarga())
            <div class="mt-4 pt-3 border-t border-slate-100">
                <a href="{{ route('laporan.pembayaran') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center justify-center gap-1">
                    <span>Lihat Seluruh Laporan Pembayaran Warga</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Recent Transactions & Audit Stream -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <!-- Recent Income Table -->
        <div class="card-panel">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-900 tracking-tight">Pemasukan Kas Terbaru</h3>
                @if(!auth()->user()->isWarga() && !auth()->user()->isKetuaRt())
                <a href="{{ route('pemasukan.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">Lihat Semua →</a>
                @endif
            </div>

            <div class="space-y-3">
                @forelse($recentPemasukan as $p)
                <div class="flex items-center justify-between p-3 bg-slate-50/60 rounded-xl border border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-emerald-100 text-emerald-700 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-800">{{ $p->warga->nama ?? 'Pemasukan Umum' }}</p>
                            <p class="text-[11px] text-slate-400">{{ $p->kategori->nama_kategori }} · {{ $p->tanggal->format('d M Y') }}</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-emerald-600">+Rp {{ number_format($p->nominal, 0, ',', '.') }}</span>
                </div>
                @empty
                <p class="text-xs text-slate-400 text-center py-6">Belum ada transaksi pemasukan</p>
                @endforelse
            </div>
        </div>

        <!-- Audit Activity Log Stream -->
        <div class="card-panel">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                <h3 class="text-sm font-bold text-slate-900 tracking-tight">Aktivitas Sistem & Audit Log</h3>
                <span class="text-[11px] text-slate-400 font-medium">Real-time Log</span>
            </div>

            <div class="space-y-3">
                @forelse($recentAktivitas as $a)
                <div class="flex items-start gap-3">
                    <div class="w-7 h-7 bg-slate-100 rounded-lg flex items-center justify-center text-xs font-bold text-slate-600 flex-shrink-0 mt-0.5">
                        {{ strtoupper(substr($a->user->name ?? 'S', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-slate-800">{{ $a->user->name ?? 'Sistem' }}</span>
                            <span class="text-[10px] font-medium text-slate-400">• {{ $a->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-slate-600 font-medium leading-snug mt-0.5">{{ $a->aktivitas }}</p>
                        @if($a->detail)
                        <p class="text-[11px] text-slate-400 truncate">{{ $a->detail }}</p>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-xs text-slate-400 text-center py-6">Belum ada aktivitas tercatat</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('keuanganChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Pemasukan (Rp)',
                data: @json($chartPemasukan),
                backgroundColor: '#059669',
                borderRadius: 6,
                borderSkipped: false,
                barPercentage: 0.6,
            }, {
                label: 'Pengeluaran (Rp)',
                data: @json($chartPengeluaran),
                backgroundColor: '#f43f5e',
                borderRadius: 6,
                borderSkipped: false,
                barPercentage: 0.6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f172a',
                    padding: 12,
                    titleFont: { family: 'Plus Jakarta Sans', size: 12, weight: 'bold' },
                    bodyFont: { family: 'Plus Jakarta Sans', size: 11 },
                    callbacks: {
                        label: function(context) {
                            return ' ' + context.dataset.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, color: '#64748b' }
                },
                y: {
                    grid: { color: '#f1f5f9' },
                    border: { display: false },
                    ticks: {
                        font: { family: 'Plus Jakarta Sans', size: 11 },
                        color: '#64748b',
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp ' + (value/1000000).toFixed(1) + 'M';
                            if (value >= 1000) return 'Rp ' + (value/1000).toFixed(0) + 'K';
                            return 'Rp ' + value;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
