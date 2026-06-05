<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Hasil Prediksi</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 9.5px;
    color: #1a1200;
    background: #ffffff;
    line-height: 1.5;
}

@page {
    size: A4 portrait;
    margin-top: 58mm;
    margin-bottom: 16mm;
    margin-left: 13mm;
    margin-right: 13mm;
}

#header { position: fixed; top: 0; left: 0; right: 0; width: 100%; }
#footer { position: fixed; bottom: 0; left: 0; right: 0; width: 100%; }

/* ══ HEADER ══ */
.h1 { background: #ffffff; padding: 10px 14px; border-bottom: 2px solid #e8b800; }
.h1-inner { display: table; width: 100%; }
.h1-left  { display: table-cell; vertical-align: middle; }
.h1-right { display: table-cell; vertical-align: middle; text-align: right; width: 135px; }
.logo-wrap { display: table; }
.logo-img  { display: table-cell; vertical-align: middle; }
.logo-img img { width: 48px; height: 48px; border-radius: 50%; border: 2.5px solid #e8b800; object-fit: cover; display: block; }
.logo-info { display: table-cell; vertical-align: middle; padding-left: 9px; }
.brand     { font-size: 16px; font-weight: 700; color: #1a1200; }
.brand span { color: #b45309; }
.tagline   { font-size: 6.5px; color: #92400e; text-transform: uppercase; letter-spacing: 1.5px; margin-top: 2px; }
.address   { font-size: 7px; color: #78350f; margin-top: 3px; line-height: 1.8; }
.cetak-lbl { font-size: 6.5px; color: #a08c3a; text-transform: uppercase; letter-spacing: 1px; }
.cetak-val { font-size: 9px; font-weight: 700; color: #b45309; margin-top: 2px; line-height: 1.9; }
.h2 { height: 3px; background: #e8b800; }
.h3 { background: #fffbeb; border-bottom: 1.5px solid #fde68a; padding: 7px 14px; text-align: center; }
.h3-title { font-size: 13px; font-weight: 700; color: #1a1200; text-transform: uppercase; letter-spacing: 2px; }
.h3-sub   { font-size: 7.5px; color: #92400e; margin-top: 2px; }

/* ══ CONTENT ══ */
.content { padding-top: 11px; padding-bottom: 11px; }
.section { margin-bottom: 11px; }
.sec-title {
    font-size: 9px; font-weight: 700; color: #1a1200;
    background: #fef3c7;
    border: 1px solid #fde68a;
    border-left: 5px solid #e8b800;
    padding: 5px 10px; margin-bottom: 7px;
    page-break-after: avoid;
}

/* ══ INFO CARDS ══ */
.cards { display: table; width: 100%; }
.card-cell { display: table-cell; vertical-align: top; padding-right: 5px; }
.card-cell:last-child { padding-right: 0; }
.i-card { background: #fffbeb; border: 1px solid #fde68a; border-top: 3px solid #e8b800; border-radius: 5px; padding: 7px 9px; }
.i-lbl  { font-size: 6.5px; font-weight: 700; color: #92400e; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 3px; }
.i-val  { font-size: 16px; font-weight: 700; color: #1a1200; line-height: 1; }
.i-unit { font-size: 8.5px; font-weight: 400; color: #78350f; }
.i-sub  { font-size: 6.5px; color: #92400e; margin-top: 2px; }

/* ══ TABEL ══ */
table.t { width: 100%; border-collapse: collapse; font-size: 9px; }
table.t thead { display: table-header-group; }
table.t th { background: #fef3c7; color: #92400e; padding: 5px 10px; text-align: left; font-size: 7.5px; font-weight: 700; border: 1px solid #fde68a; }
table.t th.th-ls  { color: #dc2626; }
table.t th.th-des { color: #2563eb; }
table.t td { padding: 4.5px 10px; border: 1px solid #fde68a; color: #1a1200; }
table.t tr:nth-child(even) td { background: #fffbeb; }
table.t td.vls    { font-weight: 700; color: #dc2626; }
table.t td.vdes   { font-weight: 700; color: #2563eb; }
table.t td.vbest  { font-weight: 700; color: #16a34a; }
table.t td.vworse { color: #dc2626; }
table.t td.tc     { text-align: center; }

/* ══ BADGE ══ */
.bls   { display:inline-block; background:#fef2f2; color:#dc2626; border:1px solid #fca5a5; padding:1px 7px; border-radius:20px; font-size:7px; font-weight:700; }
.bdes  { display:inline-block; background:#eff6ff; color:#1d4ed8; border:1px solid #93c5fd; padding:1px 7px; border-radius:20px; font-size:7px; font-weight:700; }
.bbest { display:inline-block; background:#f0fdf4; color:#15803d; border:1px solid #86efac; padding:1px 7px; border-radius:20px; font-size:7px; font-weight:700; }

/* ══ DUA/TIGA KOLOM ══ */
.two { display: table; width: 100%; }
.cl  { display: table-cell; vertical-align: top; width: 50%; padding-right: 4px; }
.cr  { display: table-cell; vertical-align: top; width: 50%; padding-left: 4px; }

/* ══ BEST BANNER ══ */
.best-banner { background: #fffbeb; border: 1.5px solid #e8b800; border-radius: 7px; padding: 10px 13px; display: table; width: 100%; margin-bottom: 9px; }
.bb-left  { display: table-cell; vertical-align: middle; }
.bb-right { display: table-cell; vertical-align: middle; text-align: right; width: 100px; }
.bb-badge { display:inline-block; background:#e8b800; color:#1a1200; padding:2px 9px; border-radius:20px; font-size:7px; font-weight:700; }
.bb-name  { font-size: 14px; font-weight: 700; color: #1a1200; margin-top: 3px; }
.bb-mape  { font-size: 22px; font-weight: 700; color: #16a34a; line-height: 1; }
.bb-lbl   { font-size: 6.5px; color: #92400e; text-transform: uppercase; letter-spacing: 1px; margin-top: 2px; }

/* ══ KESIMPULAN ══ */
.conc { background: #fffbeb; border: 1.5px solid #fde68a; border-radius: 7px; padding: 10px 12px; }
.conc-title { font-size: 9.5px; font-weight: 700; color: #92400e; border-bottom: 1px solid #fde68a; padding-bottom: 5px; margin-bottom: 7px; }
.conc-p { font-size: 8.5px; color: #1a1200; line-height: 1.9; }
.conc-p strong { color: #b45309; }
.conc-hl { background: #fef9c3; border: 1px solid #fde68a; border-radius: 5px; padding: 7px 9px; margin-top: 7px; }
.conc-hl p { font-size: 8px; color: #1a1200; line-height: 1.9; }
.conc-hl strong { color: #b45309; }

/* ══ FOOTER ══ */
.f-stripe { height: 3px; background: #e8b800; }
.f-body   { background: #fffbeb; padding: 5px 14px; border-top: 1px solid #fde68a; }
.f-inner  { display: table; width: 100%; }
.f-left   { display: table-cell; vertical-align: middle; }
.f-right  { display: table-cell; vertical-align: middle; text-align: right; }
.f-txt    { font-size: 7px; color: #92400e; line-height: 1.7; }
.f-txt strong { color: #b45309; }
</style>
</head>
<body>

@php
    $hist     = $prediction->historical_data;
    $n        = count($hist);
    $lsPreds  = $prediction->ls_predictions;
    $desPreds = $prediction->des_predictions;
    $periods  = $prediction->periods;
    $isBestLS = $prediction->best_method === 'Least Square';

    /* Split prediksi */
    $pHalf  = (int)ceil($periods / 2);
    $pThird = (int)ceil($periods / 3);

    $lsL  = array_slice($lsPreds,  0, $pHalf, true);
    $lsR  = array_slice($lsPreds,  $pHalf, null, true);
    $desL = array_slice($desPreds, 0, $pHalf, true);
    $desR = array_slice($desPreds, $pHalf, null, true);

    $ls1  = array_slice($lsPreds,  0, $pThird, true);
    $ls2  = array_slice($lsPreds,  $pThird, $pThird, true);
    $ls3  = array_slice($lsPreds,  $pThird * 2, null, true);
    $des1 = array_slice($desPreds, 0, $pThird, true);
    $des2 = array_slice($desPreds, $pThird, $pThird, true);
    $des3 = array_slice($desPreds, $pThird * 2, null, true);

    /* Akurasi bar chart */
    $metrics = [
        ['label'=>'MAD',  'ls'=>$prediction->ls_mad,  'des'=>$prediction->des_mad],
        ['label'=>'MSE',  'ls'=>$prediction->ls_mse,  'des'=>$prediction->des_mse],
        ['label'=>'MAPE', 'ls'=>$prediction->ls_mape, 'des'=>$prediction->des_mape],
    ];
    $mMax = max(array_merge(array_column($metrics,'ls'), array_column($metrics,'des'))) ?: 1;
    $maxH = 75;
@endphp

{{-- HEADER --}}
<div id="header">
    <div class="h1">
        <div class="h1-inner">
            <div class="h1-left">
                <div class="logo-wrap">
                    <div class="logo-img">
                        <img src="{{ public_path('images/motors/logofalsud.png') }}" alt="Logo">
                    </div>
                    <div class="logo-info">
                        <div class="brand">UD <span>FALSUD</span></div>
                        <div class="tagline">Rental Motor Terpercaya &middot; Malang</div>
                        <div class="address">
                            Jl. Embong Brantas No.10 Kiduldalem, Kec. Klojen, Kota Malang 65119<br>
                            Telp: 087859391130
                        </div>
                    </div>
                </div>
            </div>
            <div class="h1-right">
                <div class="cetak-lbl">Tanggal &amp; Jam Cetak</div>
                <div class="cetak-val">
                    {{ now()->format('d M Y') }}<br>
                    {{ now()->format('H:i') }} WIB
                </div>
            </div>
        </div>
    </div>
    <div class="h2"></div>
    <div class="h3">
        <div class="h3-title">Laporan Hasil Prediksi</div>
        <div class="h3-sub">
            Tanggal Prediksi: {{ $prediction->calculation_date->format('d F Y') }}
            &nbsp;&middot;&nbsp;
            Jam: {{ $prediction->calculation_date->format('H:i') }} WIB
        </div>
    </div>
</div>

{{-- FOOTER --}}
<div id="footer">
    <div class="f-stripe"></div>
    <div class="f-body">
        <div class="f-inner">
            <div class="f-left">
                <div class="f-txt">
                    <strong>UD FALSUD Rental Motor</strong>
                    &middot; Jl. Embong Brantas No.10, Kec. Klojen, Kota Malang
                    &middot; Telp: 087859391130
                </div>
            </div>
            <div class="f-right">
                <div class="f-txt" style="text-align:right;">
                    Dicetak: <strong>{{ now()->format('d M Y, H:i') }}</strong> WIB
                    &middot; Sistem Peramalan UD FALSUD v1.0
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CONTENT --}}
<div class="content">

    {{-- 1. INFO --}}
    <div class="section">
        <div class="sec-title">Informasi Perhitungan</div>
        <div class="cards">
            <div class="card-cell">
                <div class="i-card">
                    <div class="i-lbl">Jenis Motor</div>
                    <div class="i-val" style="font-size:18px">{{ $prediction->motorType->name }}</div>
                    <div class="i-sub">Kategori motor</div>
                </div>
            </div>
            <div class="card-cell">
                <div class="i-card">
                    <div class="i-lbl">Periode Prediksi</div>
                    <div class="i-val">{{ $periods }}<span class="i-unit"> bulan</span></div>
                    <div class="i-sub">ke depan</div>
                </div>
            </div>
            <div class="card-cell">
                <div class="i-card">
                    <div class="i-lbl">Data Historis</div>
                    <div class="i-val">{{ $n }}<span class="i-unit"> periode</span></div>
                    <div class="i-sub">digunakan</div>
                </div>
            </div>
            <div class="card-cell">
                <div class="i-card">
                    <div class="i-lbl">Metode Terbaik</div>
                    <div class="i-val" style="font-size:11px;margin-top:2px">{{ $isBestLS ? 'Least Square' : 'DES' }}</div>
                    <div class="i-sub">MAPE: {{ $isBestLS ? $prediction->ls_mape : $prediction->des_mape }}%</div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. HASIL PREDIKSI --}}
    <div class="section">
        <div class="sec-title">Hasil Prediksi Kedua Metode</div>

        @if($periods <= 10)
        {{-- 1 kolom --}}
        <table class="t">
            <thead>
                <tr>
                    <th style="width:34%">Periode</th>
                    <th class="th-ls" style="width:33%">Least Square</th>
                    <th class="th-des" style="width:33%">Double Exp. Smoothing</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lsPreds as $pi => $lsV)
                <tr>
                    <td>Periode {{ $n + $pi + 1 }}</td>
                    <td class="vls">{{ number_format($lsV, 2) }}</td>
                    <td class="vdes">{{ number_format($desPreds[$pi], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @elseif($periods <= 30)
        {{-- 2 kolom --}}
        <div class="two">
            <div class="cl">
                <table class="t">
                    <thead><tr><th>Periode</th><th class="th-ls">LS</th><th class="th-des">DES</th></tr></thead>
                    <tbody>
                        @foreach($lsL as $pi => $lsV)
                        <tr>
                            <td>Periode {{ $n + $pi + 1 }}</td>
                            <td class="vls">{{ number_format($lsV, 2) }}</td>
                            <td class="vdes">{{ number_format($desL[$pi], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="cr">
                <table class="t">
                    <thead><tr><th>Periode</th><th class="th-ls">LS</th><th class="th-des">DES</th></tr></thead>
                    <tbody>
                        @foreach($lsR as $pi => $lsV)
                        @php $ai = $pHalf + $pi; @endphp
                        <tr>
                            <td>Periode {{ $n + $ai + 1 }}</td>
                            <td class="vls">{{ number_format($lsV, 2) }}</td>
                            <td class="vdes">{{ number_format($desR[$pi], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @else
        {{-- 3 kolom untuk > 30 periode --}}
        <div style="display:table;width:100%;">
            <div style="display:table-cell;vertical-align:top;width:33.33%;padding-right:3px;">
                <table class="t">
                    <thead><tr><th>Periode</th><th class="th-ls">LS</th><th class="th-des">DES</th></tr></thead>
                    <tbody>
                        @foreach($ls1 as $pi => $lsV)
                        <tr>
                            <td style="font-size:8px">P{{ $n+$pi+1 }}</td>
                            <td class="vls">{{ number_format($lsV,2) }}</td>
                            <td class="vdes">{{ number_format($des1[$pi],2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="display:table-cell;vertical-align:top;width:33.33%;padding:0 1.5px;">
                <table class="t">
                    <thead><tr><th>Periode</th><th class="th-ls">LS</th><th class="th-des">DES</th></tr></thead>
                    <tbody>
                        @foreach($ls2 as $pi => $lsV)
                        @php $ai = $pThird + $pi; @endphp
                        <tr>
                            <td style="font-size:8px">P{{ $n+$ai+1 }}</td>
                            <td class="vls">{{ number_format($lsV,2) }}</td>
                            <td class="vdes">{{ number_format($des2[$pi],2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="display:table-cell;vertical-align:top;width:33.33%;padding-left:3px;">
                <table class="t">
                    <thead><tr><th>Periode</th><th class="th-ls">LS</th><th class="th-des">DES</th></tr></thead>
                    <tbody>
                        @foreach($ls3 as $pi => $lsV)
                        @php $ai = ($pThird * 2) + $pi; @endphp
                        <tr>
                            <td style="font-size:8px">P{{ $n+$ai+1 }}</td>
                            <td class="vls">{{ number_format($lsV,2) }}</td>
                            <td class="vdes">{{ number_format($des3[$pi],2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    {{-- 3. AKURASI --}}
    <div class="section">
        <div class="sec-title">Akurasi Metode</div>

        {{-- Tabel akurasi --}}
        <table class="t" style="margin-bottom:9px;">
            <thead>
                <tr>
                    <th style="width:120px">Metode</th>
                    <th>MAD</th>
                    <th>MSE</th>
                    <th>MAPE</th>
                    <th style="width:65px;text-align:center">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="bls">Least Square</span></td>
                    <td>{{ number_format($prediction->ls_mad, 4) }}</td>
                    <td>{{ number_format($prediction->ls_mse, 4) }}</td>
                    <td class="{{ $isBestLS ? 'vbest' : 'vworse' }}">{{ number_format($prediction->ls_mape, 4) }}%</td>
                    <td class="tc">
                        @if($isBestLS)<span class="bbest">&#10003; Terbaik</span>@else<span style="color:#ccc">—</span>@endif
                    </td>
                </tr>
                <tr>
                    <td><span class="bdes">DES</span></td>
                    <td>{{ number_format($prediction->des_mad, 4) }}</td>
                    <td>{{ number_format($prediction->des_mse, 4) }}</td>
                    <td class="{{ !$isBestLS ? 'vbest' : 'vworse' }}">{{ number_format($prediction->des_mape, 4) }}%</td>
                    <td class="tc">
                        @if(!$isBestLS)<span class="bbest">&#10003; Terbaik</span>@else<span style="color:#ccc">—</span>@endif
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Bar chart akurasi (HTML table, DomPDF safe) --}}
        <div style="background:#fff;border:1.5px solid #fde68a;border-radius:6px;padding:9px 11px 7px;">

            <div style="font-size:7.5px;margin-bottom:9px;">
                <span style="font-weight:700;color:#dc2626;">
                    <span style="display:inline-block;width:8px;height:8px;background:#fca5a5;border-radius:2px;vertical-align:middle;margin-right:3px;"></span>Least Square
                </span>
                &nbsp;&nbsp;
                <span style="font-weight:700;color:#2563eb;">
                    <span style="display:inline-block;width:8px;height:8px;background:#93c5fd;border-radius:2px;vertical-align:middle;margin-right:3px;"></span>Double Exponential Smoothing
                </span>
                &nbsp;&nbsp;
                <span style="font-weight:700;color:#16a34a;">
                    <span style="display:inline-block;width:8px;height:8px;background:#86efac;border-radius:2px;vertical-align:middle;margin-right:3px;"></span>Terbaik
                </span>
            </div>

            <table style="width:100%;border-collapse:collapse;table-layout:fixed;height:{{ $maxH + 28 }}px;">
                <tr style="vertical-align:bottom;height:{{ $maxH + 28 }}px;">
                    @foreach($metrics as $mi => $m)
                    @php
                        $lsBest = $m['ls'] <= $m['des'];
                        $lsH    = max(3, round(($m['ls']  / $mMax) * $maxH));
                        $desH   = max(3, round(($m['des'] / $mMax) * $maxH));
                        $lsCol  = $lsBest  ? '#86efac' : '#fca5a5';
                        $desCol = !$lsBest ? '#86efac' : '#93c5fd';
                        $lsTxt  = $lsBest  ? '#15803d' : '#dc2626';
                        $desTxt = !$lsBest ? '#15803d' : '#2563eb';
                    @endphp
                    <td style="vertical-align:bottom;text-align:center;padding:0 6px;">
                        <div style="font-size:6.5px;font-weight:700;color:{{ $lsTxt }};margin-bottom:2px;">
                            {{ number_format($m['ls'],4) }}@if($lsBest) ✓@endif
                        </div>
                        <div style="width:100%;height:{{ $lsH }}px;background:{{ $lsCol }};border-radius:3px 3px 0 0;border:1px solid {{ $lsBest ? '#86efac' : '#fca5a5' }};"></div>
                        <div style="height:2px;background:#e8b800;"></div>
                        <div style="font-size:6px;color:#dc2626;font-weight:700;margin-top:3px;">LS</div>
                    </td>
                    <td style="vertical-align:bottom;text-align:center;padding:0 6px;{{ $mi < count($metrics)-1 ? 'border-right:1px solid #fde68a;' : '' }}">
                        <div style="font-size:6.5px;font-weight:700;color:{{ $desTxt }};margin-bottom:2px;">
                            {{ number_format($m['des'],4) }}@if(!$lsBest) ✓@endif
                        </div>
                        <div style="width:100%;height:{{ $desH }}px;background:{{ $desCol }};border-radius:3px 3px 0 0;border:1px solid {{ !$lsBest ? '#86efac' : '#93c5fd' }};"></div>
                        <div style="height:2px;background:#e8b800;"></div>
                        <div style="font-size:6px;color:#2563eb;font-weight:700;margin-top:3px;">DES</div>
                    </td>
                    @endforeach
                </tr>
            </table>

            <table style="width:100%;border-collapse:collapse;table-layout:fixed;margin-top:4px;">
                <tr>
                    @foreach($metrics as $m)
                    <td colspan="2" style="text-align:center;font-size:9px;font-weight:700;color:#1a1200;">
                        {{ $m['label'] }}
                    </td>
                    @endforeach
                </tr>
            </table>
        </div>
    </div>

    {{-- 4. KESIMPULAN --}}
    <div class="section">
        <div class="sec-title">Kesimpulan &amp; Rekomendasi</div>

        <div class="best-banner">
            <div class="bb-left">
                <span class="bb-badge">&#11088; Metode Terbaik</span>
                <div class="bb-name">{{ $prediction->best_method }}</div>
            </div>
            <div class="bb-right">
                <div class="bb-mape">{{ $isBestLS ? $prediction->ls_mape : $prediction->des_mape }}%</div>
                <div class="bb-lbl">MAPE Terbaik</div>
            </div>
        </div>

        <div class="conc">
            <div class="conc-title">Analisis &amp; Rekomendasi</div>
            <p class="conc-p">
                Berdasarkan hasil analisis peramalan transaksi sewa motor
                <strong>{{ $prediction->motorType->name }}</strong>
                menggunakan dua metode peramalan, diperoleh nilai MAPE sebesar
                <strong>{{ $prediction->ls_mape }}%</strong> untuk metode Least Square dan
                <strong>{{ $prediction->des_mape }}%</strong> untuk metode Double Exponential Smoothing (DES).
            </p>
            <div class="conc-hl">
                <p>
                    ✦ Metode <strong>{{ $prediction->best_method }}</strong> terbukti lebih akurat
                    dengan MAPE <strong>{{ $isBestLS ? $prediction->ls_mape : $prediction->des_mape }}%</strong>
                    yang termasuk kategori <strong>sangat akurat (MAPE &lt; 10%)</strong>.
                    Metode ini <strong>direkomendasikan</strong> sebagai acuan peramalan
                    transaksi sewa motor <strong>{{ $prediction->motorType->name }}</strong>
                    di <strong>UD FALSUD Rental Motor Malang</strong> untuk periode selanjutnya.
                </p>
            </div>
        </div>
    </div>

</div>

</body>
</html>