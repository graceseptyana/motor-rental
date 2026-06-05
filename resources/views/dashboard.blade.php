@extends('layouts.app')
@section('title','Dashboard')
@section('page-title','Dashboard')

@push('styles')
<style>
/* ── SECTION LABEL ── */
.section-label {
    font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 1.2px; color: #a08c3a; margin-bottom: 10px;
    font-family: var(--font-mono);
    display: flex; align-items: center; gap: 10px;
}
.section-label::after {
    content: ''; flex: 1; height: 1px;
    background: linear-gradient(90deg, #fde68a, transparent);
}

/* ── FLEET CARDS ── */
.fleet-card {
    border-radius: 14px;
    padding: 14px 16px 10px 16px;
    position: relative;
    overflow: hidden;
    transition: transform 0.25s, box-shadow 0.25s;
    min-height: 110px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    cursor: pointer;
}
.fleet-card:hover { transform: translateY(-3px); }

.fleet-card.fc-small {
    background: linear-gradient(145deg, #fffbeb, #fef3c7);
    border: 1.5px solid #fde68a;
    box-shadow: 0 4px 16px rgba(232,184,0,0.15);
}
.fleet-card.fc-small:hover { box-shadow: 0 6px 24px rgba(232,184,0,0.25); }

.fleet-card.fc-auto {
    background: linear-gradient(145deg, #fff7ed, #ffedd5);
    border: 1.5px solid #fed7aa;
    box-shadow: 0 4px 16px rgba(249,115,22,0.12);
}
.fleet-card.fc-auto:hover { box-shadow: 0 6px 24px rgba(249,115,22,0.2); }

.fleet-card.fc-big {
    background: linear-gradient(145deg, #fefce8, #fef9c3);
    border: 1.5px solid #fde047;
    box-shadow: 0 4px 16px rgba(202,138,4,0.12);
}
.fleet-card.fc-big:hover { box-shadow: 0 6px 24px rgba(202,138,4,0.22); }

.fleet-card::before {
    content: '';
    position: absolute; top: -30px; right: -30px;
    width: 100px; height: 100px; border-radius: 50%; opacity: 0.15;
    pointer-events: none;
}
.fleet-card.fc-small::before { background: #e8b800; }
.fleet-card.fc-auto::before  { background: #f97316; }
.fleet-card.fc-big::before   { background: #ca8a04; }

.fleet-top {
    display: flex; align-items: flex-start;
    justify-content: space-between; gap: 10px;
}
.fleet-info { flex: 1; position: relative; z-index: 1; }

.fleet-type-badge {
    display: inline-block; font-size: 9px; font-weight: 800;
    letter-spacing: 1.5px; text-transform: uppercase;
    padding: 2px 8px; border-radius: 20px; margin-bottom: 4px;
    font-family: var(--font-mono);
}
.fc-small .fleet-type-badge { background: rgba(232,184,0,0.2);  color: #92400e; }
.fc-auto  .fleet-type-badge { background: rgba(249,115,22,0.18); color: #c2410c; }
.fc-big   .fleet-type-badge { background: rgba(202,138,4,0.2);  color: #78350f; }

.fleet-number {
    font-size: 34px; font-weight: 900; line-height: 1; letter-spacing: -1px;
}
.fc-small .fleet-number { color: #b45309; }
.fc-auto  .fleet-number { color: #c2410c; }
.fc-big   .fleet-number { color: #854d0e; }

.fleet-label { font-size: 12px; font-weight: 600; margin-top: 2px; }
.fc-small .fleet-label { color: #d97706; }
.fc-auto  .fleet-label { color: #ea580c; }
.fc-big   .fleet-label { color: #ca8a04; }

.fleet-motor-img {
    width: 90px; height: 58px;
    object-fit: contain; object-position: center bottom;
    flex-shrink: 0;
    filter: drop-shadow(0 3px 8px rgba(0,0,0,0.15));
    transition: transform 0.3s ease;
    align-self: flex-end;
    position: relative; z-index: 1;
}
.fleet-card:hover .fleet-motor-img { transform: scale(1.06) translateY(-3px); }

.fleet-unit-badge {
    position: absolute; bottom: 10px; right: 12px;
    font-size: 9px; font-weight: 800; letter-spacing: 1px;
    padding: 2px 8px; border-radius: 20px;
    font-family: var(--font-mono);
}
.fc-small .fleet-unit-badge { background: rgba(232,184,0,0.25); color: #92400e; }
.fc-auto  .fleet-unit-badge { background: rgba(249,115,22,0.2); color: #c2410c; }
.fc-big   .fleet-unit-badge { background: rgba(202,138,4,0.2);  color: #78350f; }

/* ── HINT KLIK ── */
.fleet-hint {
    position: absolute; bottom: 10px; left: 12px;
    font-size: 8px; color: rgba(0,0,0,0.3);
    font-family: var(--font-mono);
    display: flex; align-items: center; gap: 3px;
}

/* ── STAT MINI ── */
.stat-mini {
    border-radius: 12px; padding: 14px 16px;
    display: flex; align-items: center; gap: 12px;
    transition: transform 0.2s, box-shadow 0.2s; height: 100%;
}
.stat-mini:hover { transform: translateY(-2px); }

.stat-mini.sm-yellow {
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    border: 1.5px solid #fde68a;
    box-shadow: 0 4px 16px rgba(232,184,0,0.12);
}
.stat-mini.sm-orange {
    background: linear-gradient(135deg, #fff7ed, #ffedd5);
    border: 1.5px solid #fed7aa;
    box-shadow: 0 4px 16px rgba(249,115,22,0.1);
}
.stat-mini.sm-amber {
    background: linear-gradient(135deg, #fefce8, #fef9c3);
    border: 1.5px solid #fde047;
    box-shadow: 0 4px 16px rgba(202,138,4,0.1);
}

.sm-icon {
    width: 38px; height: 38px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.sm-yellow .sm-icon { background: rgba(232,184,0,0.2);  color: #b45309; }
.sm-orange .sm-icon { background: rgba(249,115,22,0.18); color: #c2410c; }
.sm-amber  .sm-icon { background: rgba(202,138,4,0.2);  color: #854d0e; }

.sm-value { font-size: 22px; font-weight: 800; line-height: 1; }
.sm-yellow .sm-value { color: #b45309; }
.sm-orange .sm-value { color: #c2410c; }
.sm-amber  .sm-value { color: #854d0e; }
.sm-label  { font-size: 12px; color: #92400e; margin-top: 3px; font-weight: 500; }

/* ── PRED BANNER ── */
.pred-banner {
    border-radius: 14px;
    background: linear-gradient(135deg, #fffdf0 0%, #fffbeb 100%);
    border: 1.5px solid #fde68a;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(232,184,0,0.1);
}
.pred-banner-header {
    padding: 12px 18px;
    border-bottom: 1px solid #fde68a;
    display: flex; align-items: center; justify-content: space-between;
    background: linear-gradient(90deg, #fffbeb, #fef9c3);
}
.best-ls {
    background: #fef2f2; color: #dc2626;
    border: 1px solid #fecaca;
    padding: 4px 10px; border-radius: 20px; font-size: 12px;
    font-weight: 700; display: inline-flex; align-items: center; gap: 5px;
}
.best-des {
    background: #eff6ff; color: #2563eb;
    border: 1px solid #bfdbfe;
    padding: 4px 10px; border-radius: 20px; font-size: 12px;
    font-weight: 700; display: inline-flex; align-items: center; gap: 5px;
}

/* Badge jenis motor */
.badge-small {
    background: rgba(232,184,0,0.15); color: #92400e;
    border: 1px solid #fde68a;
    padding: 4px 12px; border-radius: 20px;
    font-size: 12px; font-weight: 700;
}
.badge-auto {
    background: rgba(249,115,22,0.12); color: #c2410c;
    border: 1px solid #fed7aa;
    padding: 4px 12px; border-radius: 20px;
    font-size: 12px; font-weight: 700;
}
.badge-big {
    background: rgba(202,138,4,0.15); color: #78350f;
    border: 1px solid #fde047;
    padding: 4px 12px; border-radius: 20px;
    font-size: 12px; font-weight: 700;
}

/* Empty state */
.empty-state {
    background: #fffbeb;
    border: 1.5px dashed #fde68a;
    border-radius: 14px; padding: 32px; text-align: center;
}

/* ── MOTOR POPUP ── */
.motor-popup {
    display: none;
    position: fixed;
    z-index: 9999;
    background: #1a1200;
    border: 1.5px solid #e8b800;
    border-radius: 14px;
    padding: 14px 16px 12px;
    min-width: 210px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.45),
                0 0 24px rgba(232,184,0,0.2);
    animation: popupIn 0.2s cubic-bezier(0.34,1.56,0.64,1);
}
@keyframes popupIn {
    from { transform: scale(0.85); opacity: 0; }
    to   { transform: scale(1);    opacity: 1; }
}
.popup-title {
    font-size: 10px; font-weight: 700;
    color: #e8b800; text-transform: uppercase;
    letter-spacing: 1.5px; margin-bottom: 10px;
    padding-bottom: 7px;
    border-bottom: 1px solid rgba(232,184,0,0.2);
    font-family: var(--font-mono);
    display: flex; align-items: center; gap: 6px;
}
.popup-item {
    display: flex; align-items: center; gap: 8px;
    padding: 5px 0;
    font-size: 12px; font-weight: 500; color: #f5f0e0;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}
.popup-item:last-child { border-bottom: none; padding-bottom: 0; }
.popup-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: #e8b800; flex-shrink: 0;
}
.popup-close {
    position: absolute; top: 8px; right: 10px;
    font-size: 14px; color: rgba(255,255,255,0.35);
    cursor: pointer; font-weight: 700; line-height: 1;
    background: none; border: none; padding: 2px 4px;
    transition: color 0.15s;
}
.popup-close:hover { color: #e8b800; }
.popup-footer {
    margin-top: 10px; padding-top: 8px;
    border-top: 1px solid rgba(232,184,0,0.15);
    font-size: 9px; color: rgba(255,255,255,0.3);
    font-family: var(--font-mono);
    text-align: center;
}
</style>
@endpush

@section('content')

{{-- FLEET CARDS --}}
<div class="section-label"><span>Jumlah Armada</span></div>
<div class="row g-3 mb-3">

    <div class="col-md-4">
        <div class="fleet-card fc-small" onclick="showPopup(event, 'small')">
            <div class="fleet-top">
                <div class="fleet-info">
                    <div class="fleet-type-badge">Small</div>
                    <div class="fleet-number">
                        @php $small = $motorTypes->where('name','Small')->first(); @endphp
                        {{ $small->total_units ?? 45 }}
                    </div>
                    <div class="fleet-label">Motor Small</div>
                </div>
                <img src="{{ asset('images/motors/scoopy.png') }}" alt="Scoopy"
                     class="fleet-motor-img" onerror="this.style.display='none'">
            </div>
            <span class="fleet-unit-badge">UNIT</span>
            
        </div>
    </div>

    <div class="col-md-4">
        <div class="fleet-card fc-auto" onclick="showPopup(event, 'auto')">
            <div class="fleet-top">
                <div class="fleet-info">
                    <div class="fleet-type-badge">Auto</div>
                    <div class="fleet-number">
                        @php $auto = $motorTypes->where('name','Auto')->first(); @endphp
                        {{ $auto->total_units ?? 40 }}
                    </div>
                    <div class="fleet-label">Motor Auto</div>
                </div>
                <img src="{{ asset('images/motors/fazzio.png') }}" alt="Fazzio"
                     class="fleet-motor-img" onerror="this.style.display='none'">
            </div>
            <span class="fleet-unit-badge">UNIT</span>
            
        </div>
    </div>

    <div class="col-md-4">
        <div class="fleet-card fc-big" onclick="showPopup(event, 'big')">
            <div class="fleet-top">
                <div class="fleet-info">
                    <div class="fleet-type-badge">Big</div>
                    <div class="fleet-number">
                        @php $big = $motorTypes->where('name','Big')->first(); @endphp
                        {{ $big->total_units ?? 15 }}
                    </div>
                    <div class="fleet-label">Motor Big</div>
                </div>
                <img src="{{ asset('images/motors/nmax.png') }}" alt="NMAX"
                     class="fleet-motor-img" onerror="this.style.display='none'">
            </div>
            <span class="fleet-unit-badge">UNIT</span>
            
        </div>
    </div>

</div>

{{-- STATISTIK --}}
<div class="section-label"><span>Statistik Sistem</span></div>
<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="stat-mini sm-yellow">
            <div class="sm-icon"><i class="bi bi-graph-up-arrow"></i></div>
            <div>
                <div class="sm-value">{{ $totalPredictions }}</div>
                <div class="sm-label">Total Prediksi</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-mini sm-orange">
            <div class="sm-icon"><i class="bi bi-database-fill"></i></div>
            <div>
                <div class="sm-value">{{ $totalData }}</div>
                <div class="sm-label">Total Data Historis</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-mini sm-amber">
            <div class="sm-icon"><i class="bi bi-clock-history"></i></div>
            <div>
                <div class="sm-value" style="font-size:15px;line-height:1.4">
                    {{ $latestPrediction ? $latestPrediction->calculation_date->format('d M Y') : '—' }}
                </div>
                <div class="sm-label">Prediksi Terakhir</div>
            </div>
        </div>
    </div>
</div>

{{-- HASIL PREDIKSI TERAKHIR --}}
<div class="section-label"><span>Hasil Prediksi Terakhir</span></div>

@if($latestPredictions->count() > 0)
<div class="pred-banner">
    <div class="pred-banner-header">
        <div style="display:flex;align-items:center;gap:10px">
            <div style="width:8px;height:8px;border-radius:50%;background:#22c55e;box-shadow:0 0 8px rgba(34,197,94,0.6);flex-shrink:0"></div>
            <span style="font-size:14px;font-weight:700;color:#78350f">5 Prediksi Terbaru</span>
        </div>
        <a href="{{ route('history.index') }}"
           style="font-size:12px;color:#c9a000;text-decoration:none;display:flex;align-items:center;gap:5px;font-weight:700">
            Lihat Semua
        </a>
    </div>
    <div style="overflow-x:auto">
        <table class="table mb-0" style="font-size:13px">
            <thead>
                <tr style="background:#fffbeb">
                    <th style="padding:10px 16px;color:#a08c3a;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;border-color:#fde68a">Tanggal</th>
                    <th style="padding:10px 16px;color:#a08c3a;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;border-color:#fde68a">Jenis Motor</th>
                    <th style="padding:10px 16px;color:#a08c3a;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;border-color:#fde68a">Periode</th>
                    <th style="padding:10px 16px;color:#a08c3a;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;border-color:#fde68a">Metode Terbaik</th>
                    <th style="padding:10px 16px;color:#a08c3a;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;border-color:#fde68a">MAPE LS</th>
                    <th style="padding:10px 16px;color:#a08c3a;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;border-color:#fde68a">MAPE DES</th>
                    <th style="padding:10px 16px;color:#a08c3a;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;border-color:#fde68a"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($latestPredictions as $pred)
                <tr style="border-color:#fde68a">
                    <td style="padding:10px 16px;border-color:#fde68a;color:#78350f;font-family:var(--font-mono);font-size:12px">
                        {{ $pred->calculation_date->format('d M Y') }}
                    </td>
                    <td style="padding:10px 16px;border-color:#fde68a">
                        @php $motorName = strtolower($pred->motorType->name); @endphp
                        <span class="badge-{{ $motorName }}">
                            {{ $pred->motorType->name }}
                        </span>
                    </td>
                    <td style="padding:10px 16px;border-color:#fde68a;color:#78350f;font-family:var(--font-mono)">
                        {{ $pred->periods }} bulan
                    </td>
                    <td style="padding:10px 16px;border-color:#fde68a">
                        <span class="{{ $pred->best_method==='Least Square' ? 'best-ls' : 'best-des' }}">
                            <i class="bi bi-trophy-fill" style="font-size:10px"></i>
                            {{ $pred->best_method }}
                        </span>
                    </td>
                    <td style="padding:10px 16px;border-color:#fde68a;font-weight:700;color:#dc2626;font-family:var(--font-mono)">
                        {{ $pred->ls_mape }}%
                    </td>
                    <td style="padding:10px 16px;border-color:#fde68a;font-weight:700;color:#2563eb;font-family:var(--font-mono)">
                        {{ $pred->des_mape }}%
                    </td>
                    <td style="padding:10px 16px;border-color:#fde68a">
                        <a href="{{ route('result.show', $pred->id) }}"
                           style="font-size:12px;color:#1a1200;text-decoration:none;font-weight:600">
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="empty-state">
    <div style="font-size:40px;margin-bottom:12px">📊</div>
    <div style="font-size:15px;font-weight:700;color:#78350f;margin-bottom:6px">Belum Ada Prediksi</div>
    <div style="font-size:13px;color:#a08c3a;margin-bottom:16px">Upload data historis dan mulai hitung prediksi pertama</div>
    <a href="{{ route('upload.index') }}" class="btn btn-primary">
        <i class="bi bi-upload"></i> Upload Data Sekarang
    </a>
</div>
@endif

<!-- MOTOR POPUP -->
<div id="motorPopup" class="motor-popup">
    <button class="popup-close" onclick="closePopup(event)">✕</button>
    <div class="popup-title" id="popupTitle"></div>
    <div id="popupList"></div>
    <div class="popup-footer">Klik di luar untuk menutup</div>
</div>

@endsection

@push('scripts')
<script>
const motorData = {
    small: {
        title: '🏍️ Motor Small',
        items: [
            'Beat Eco',
            'Beat FI',
            'Scoopy New',
            'Vario 125cc',
            'Vario 150cc',
        ]
    },
    auto: {
        title: '🛵 Motor Auto',
        items: [
            'Yamaha Filano',
            'Yamaha Fazio',
            'Beat Street',
        ]
    },
    big: {
        title: '🏍️ Motor Big',
        items: [
            'Yamaha Nmax',
            'Yamaha Aerox New 2024',
            'Honda PCX',
            'Honda ADV New 2024',
        ]
    }
};

function showPopup(e, type) {
    e.stopPropagation();
    const popup = document.getElementById('motorPopup');
    const title = document.getElementById('popupTitle');
    const list  = document.getElementById('popupList');
    const data  = motorData[type];

    title.textContent = data.title;
    list.innerHTML = data.items.map(item =>
        `<div class="popup-item">
            <span class="popup-dot"></span>
            <span>${item}</span>
        </div>`
    ).join('');

    popup.style.display = 'block';

    /* Posisi popup dekat kursor, tidak keluar layar */
    const pw = popup.offsetWidth;
    const ph = popup.offsetHeight;
    const ww = window.innerWidth;
    const wh = window.innerHeight;

    let left = e.clientX + 14;
    let top  = e.clientY + 14;
    if (left + pw > ww - 10) left = e.clientX - pw - 14;
    if (top  + ph > wh - 10) top  = e.clientY - ph - 14;

    popup.style.left = left + 'px';
    popup.style.top  = top  + 'px';
}

function closePopup(e) {
    if (e) e.stopPropagation();
    document.getElementById('motorPopup').style.display = 'none';
}

document.addEventListener('click', function() {
    closePopup();
});
</script>
@endpush