@extends('layouts.app')
@section('title','Hasil Prediksi')
@section('page-title','Hasil Prediksi')
@section('breadcrumb','rental / perhitungan / hasil')
@section('content')

@php
    $p=$prediction; $historical=$p->historical_data; $n=count($historical);
    $lsPreds=$p->ls_predictions; $desPreds=$p->des_predictions;
    $predLabels=array_map(fn($i)=>"P".($n+$i),range(1,$p->periods));
@endphp

<style>
    .stat-card::before { display: none !important; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('calculation.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Hitung Lagi</a>
    <div class="d-flex gap-2">
        <a href="{{ route('history.index') }}" class="btn btn-outline-secondary"><i class="bi bi-clock-history"></i> Riwayat</a>
        <a href="{{ route('result.pdf', $p->id) }}" class="btn btn-primary" target="_blank"><i class="bi bi-file-pdf"></i> Export PDF</a>
    </div>
</div>

{{-- Notifikasi Warning Akurasi --}}
@if(session('warning'))
<div id="warningAlert" class="alert d-flex align-items-start gap-3 mb-4" style="background:rgba(227,179,65,0.08);border:1px solid rgba(227,179,65,0.35);border-radius:12px;padding:16px;position:relative;">
    <i class="bi bi-exclamation-triangle-fill mt-1" style="color:#e3b341;font-size:22px;flex-shrink:0"></i>
    <div style="flex:1">
        <div style="font-weight:700;color:#e3b341;font-size:14px;margin-bottom:4px">⚠️ Peringatan Akurasi Prediksi</div>
        <div style="font-size:13px;color:var(--text-dim);line-height:1.6">{{ session('warning') }}</div>
        <div style="font-size:11px;color:var(--text-dim);margin-top:6px;font-family:var(--font-mono)">
                Tip: Tambahkan lebih banyak data historis untuk meningkatkan akurasi prediksi.
        </div>
    </div>
    {{-- Tombol X --}}
    <button onclick="document.getElementById('warningAlert').style.display='none'"
            style="position:absolute;top:10px;right:12px;
                   background:none;border:none;cursor:pointer;
                   color:#e3b341;font-size:18px;font-weight:700;
                   line-height:1;padding:0;opacity:0.7;transition:opacity 0.2s;"
            onmouseover="this.style.opacity='1'"
            onmouseout="this.style.opacity='0.7'"
            title="Tutup">
        ✕
    </button>
</div>
@endif

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card blue">
            <div class="stat-icon blue" style="font-size:20px">🏍️</div>
            <div class="stat-value">{{ $p->motorType->name }}</div>
            <div class="stat-label">Jenis Motor</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card green">
            <div class="stat-icon green"><i class="bi bi-calendar-range"></i></div>
            <div class="stat-value">{{ $p->periods }}</div>
            <div class="stat-label">Periode Prediksi</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card yellow">
            <div class="stat-icon yellow"><i class="bi bi-database-check"></i></div>
            <div class="stat-value">{{ $n }}</div>
            <div class="stat-label">Data Historis</div>
        </div>
    </div>
</div>

<div class="mb-4 p-4 d-flex align-items-center gap-3" style="background:rgba(22,163,74,0.07);border:1px solid rgba(22,163,74,0.2);border-radius:12px">
    <div style="font-size:32px">🏆</div>
    <div>
        <div style="font-size:13px;color:#16a34a;font-weight:700;text-transform:uppercase;letter-spacing:0.5px">Metode Terbaik</div>
        <div style="font-size:20px;font-weight:700;color:var(--text-primary)">{{ $p->best_method }}</div>
        <div style="font-size:12px;color:var(--text-dim);font-family:var(--font-mono)">MAPE: {{ $p->best_method==='Least Square'?$p->ls_mape:$p->des_mape }}%</div>
    </div>
</div>

<!-- Grafik Prediksi + Akurasi Sejajar -->
<div class="row g-4 mb-4">
    <div class="col-md-8">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title" style="border-left:4px solid #e8b800;padding-left:12px">
                    <i class="bi bi-graph-up me-2"></i>Grafik Prediksi
                </h5>
                <div class="d-flex gap-3" style="font-size:12px">
                    <span style="color:#dc2626;display:flex;align-items:center;gap:5px">
                        <span style="display:inline-block;width:16px;height:3px;background:#dc2626;border-radius:2px"></span>
                        Least Square
                    </span>
                    <span style="color:#2563eb;display:flex;align-items:center;gap:5px">
                        <span style="display:inline-block;width:16px;height:3px;background:#2563eb;border-radius:2px"></span>
                        DES
                    </span>
                </div>
            </div>
            <div class="card-body" style="padding:16px">
                <canvas id="combinedChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title" style="border-left:4px solid #e8b800;padding-left:12px">
                    <i class="bi bi-bar-chart me-2"></i>Akurasi Metode
                </h5>
            </div>
            <div class="card-body" style="padding:16px">
                <canvas id="accChart" style="width:100%;height:280px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- TABEL PREDIKSI GABUNGAN -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title" style="border-left:4px solid #e8b800;padding-left:12px">
            <i class="bi bi-table me-2"></i>Detail Prediksi per Periode
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0" style="font-size:13px">
                <thead>
                    <tr style="background:linear-gradient(90deg,#1a1200,#2d1e00)">
                        <th style="padding:12px 16px;color:#e8b800;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;border:none;width:12%">Periode</th>
                        <th style="padding:12px 16px;color:#f87171;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;border:none;width:26%"><i class="bi bi-activity me-1"></i>Least Square</th>
                        <th style="padding:12px 16px;color:#60a5fa;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;border:none;width:26%"><i class="bi bi-bezier2 me-1"></i>Double Exp. Smoothing</th>
                        <th style="padding:12px 16px;color:#fde68a;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;border:none;width:18%">Selisih</th>
                        <th style="padding:12px 16px;color:#6ee7b7;font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:1px;border:none;width:18%">Terbaik</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lsPreds as $i=>$val)
                    @php
                        $desVal   = $desPreds[$i] ?? 0;
                        $selisih  = abs($val - $desVal);
                        $lsBetter = $p->ls_mape <= $p->des_mape;
                    @endphp
                    <tr style="border-color:#fde68a;{{ $i % 2 === 0 ? 'background:#fffdf0' : 'background:#fffbeb' }}">
                        <td style="padding:10px 16px;border-color:#fde68a;vertical-align:middle">
                            <span style="background:#f5f0e0;border:1px solid #fde68a;color:#78350f;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;font-family:var(--font-mono)">
                                P{{ $n+$i+1 }}
                            </span>
                        </td>
                        <td style="padding:10px 16px;border-color:#fde68a;vertical-align:middle">
                            <span style="font-weight:700;color:#dc2626;font-family:var(--font-mono);font-size:14px">
                                {{ number_format($val, 2) }}
                            </span>
                        </td>
                        <td style="padding:10px 16px;border-color:#fde68a;vertical-align:middle">
                            <span style="font-weight:700;color:#2563eb;font-family:var(--font-mono);font-size:14px">
                                {{ number_format($desVal, 2) }}
                            </span>
                        </td>
                        <td style="padding:10px 16px;border-color:#fde68a;vertical-align:middle">
                            <span style="font-size:13px;color:#92400e;font-family:var(--font-mono);font-weight:600">
                                {{ number_format($selisih, 2) }}
                            </span>
                        </td>
                        <td style="padding:10px 16px;border-color:#fde68a;vertical-align:middle">
                            @if($lsBetter)
                                <span style="font-size:11px;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;padding:3px 10px;border-radius:20px;font-weight:700">
                                    ✓ LS
                                </span>
                            @else
                                <span style="font-size:11px;background:#eff6ff;color:#2563eb;border:1px solid #bfdbfe;padding:3px 10px;border-radius:20px;font-weight:700">
                                    ✓ DES
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const predLabels    = @json($predLabels);
const lsPredictions = @json($lsPreds);
const desPredictions= @json($desPreds);
const n = {{ $n }};

/* ── Gradient helper ── */
function makeGradient(ctx, color1, color2) {
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, color1);
    gradient.addColorStop(1, color2);
    return gradient;
}

/* ── Grafik Prediksi ── */
const ctxLine = document.getElementById('combinedChart').getContext('2d');
const gradLS  = makeGradient(ctxLine, 'rgba(220,38,38,0.25)', 'rgba(220,38,38,0.02)');
const gradDES = makeGradient(ctxLine, 'rgba(37,99,235,0.25)', 'rgba(37,99,235,0.02)');

new Chart(ctxLine, {
    type: 'line',
    data: {
        labels: predLabels,
        datasets: [
            {
                label: 'Prediksi Least Square',
                data: lsPredictions,
                borderColor: '#dc2626',
                backgroundColor: gradLS,
                borderWidth: 2.5,
                pointRadius: 4,
                pointHoverRadius: 7,
                pointBackgroundColor: '#dc2626',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                tension: 0.4,
                fill: true
            },
            {
                label: 'Prediksi DES',
                data: desPredictions,
                borderColor: '#2563eb',
                backgroundColor: gradDES,
                borderWidth: 2.5,
                pointRadius: 4,
                pointHoverRadius: 7,
                pointBackgroundColor: '#2563eb',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                tension: 0.4,
                fill: true
            }
        ]
    },
    options: {
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            legend: {
                position: 'top',
                align: 'end',
                labels: {
                    boxWidth: 10,
                    boxHeight: 10,
                    borderRadius: 5,
                    usePointStyle: true,
                    pointStyle: 'circle',
                    padding: 16,
                    font: { size: 12 },
                    color: '#6b5c00'
                }
            },
            tooltip: {
                backgroundColor: '#1a1200',
                borderColor: '#e8b800',
                borderWidth: 1,
                padding: 12,
                titleColor: '#e8b800',
                bodyColor: '#f5f0e0',
                cornerRadius: 8,
                callbacks: {
                    label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y.toFixed(2)}`
                }
            }
        },
        scales: {
            x: {
                grid: { display: false },
                border: { display: false },
                ticks: {
                    font: { size: 11 },
                    color: '#a08c3a',
                    padding: 8
                }
            },
            y: {
                grid: { color: 'rgba(240,230,192,0.6)' },
                border: { display: false },
                ticks: {
                    font: { size: 11 },
                    color: '#a08c3a',
                    padding: 8
                }
            }
        }
    }
});

/* ── Plugin: label nilai di atas bar ── */
const datalabelsPlugin = {
    id: 'datalabels',
    afterDatasetsDraw(chart) {
        const { ctx } = chart;
        chart.data.datasets.forEach((dataset, i) => {
            const meta = chart.getDatasetMeta(i);
            meta.data.forEach((bar, index) => {
                const value = dataset.data[index];
                if (value === null || value === undefined) return;
                ctx.save();
                ctx.font = 'bold 10px "Plus Jakarta Sans", sans-serif';
                ctx.fillStyle = dataset.borderColor || '#1a1200';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';
                ctx.fillText(Number(value).toFixed(2), bar.x, bar.y - 4);
                ctx.restore();
            });
        });
    }
};

/* ── Chart Akurasi Gabungan ── */
new Chart(document.getElementById('accChart'), {
    type: 'bar',
    data: {
        labels: ['MAD', 'MSE', 'MAPE'],
        datasets: [
            {
                label: 'Least Square',
                data: [{{ $p->ls_mad }}, {{ $p->ls_mse }}, {{ $p->ls_mape }}],
                backgroundColor: 'rgba(220,38,38,0.55)',
                borderColor: '#dc2626',
                borderWidth: 0,
                borderRadius: 6,
                borderSkipped: false,
                barPercentage: 1.0,
                categoryPercentage: 0.95
            },
            {
                label: 'DES',
                data: [{{ $p->des_mad }}, {{ $p->des_mse }}, {{ $p->des_mape }}],
                backgroundColor: 'rgba(37,99,235,0.55)',
                borderColor: '#2563eb',
                borderWidth: 0,
                borderRadius: 6,
                borderSkipped: false,
                barPercentage: 1.0,
                categoryPercentage: 0.95
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    boxWidth: 10,
                    boxHeight: 10,
                    borderRadius: 5,
                    usePointStyle: true,
                    pointStyle: 'circle',
                    padding: 12,
                    font: { size: 11 },
                    color: '#6b5c00'
                }
            },
            tooltip: {
                backgroundColor: '#1a1200',
                borderColor: '#e8b800',
                borderWidth: 1,
                padding: 10,
                titleColor: '#e8b800',
                bodyColor: '#f5f0e0',
                cornerRadius: 8,
                callbacks: { label: ctx => ` ${ctx.dataset.label}: ${ctx.parsed.y.toFixed(4)}` }
            }
        },
        scales: {
            x: {
                grid: { display: false },
                border: { display: false },
                ticks: { font: { size: 11, weight: '600' }, color: '#6b5c00' }
            },
            y: {
                grid: { color: 'rgba(240,230,192,0.6)' },
                border: { display: false },
                ticks: { font: { size: 10 }, color: '#a08c3a' },
                beginAtZero: true
            }
        },
        layout: { padding: { top: 24, left: 2, right: 2, bottom: 16 } }
    },
    plugins: [datalabelsPlugin]
});
</script>
@endpush