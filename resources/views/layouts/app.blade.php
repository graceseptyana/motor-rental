<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Rental Motor FALSUD')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-main:       #fffdf0;
            --bg-card:       #ffffff;
            --bg-sidebar:    #1a1200;
            --bg-hover:      #2a1e00;
            --bg-topbar:     #ffffff;
            --border:        #f0e6c0;
            --border-light:  #fde68a;
            --accent-blue:   #e8b800;
            --accent-indigo: #c9a000;
            --accent-green:  #10b981;
            --accent-red:    #ef4444;
            --accent-yellow: #f59e0b;
            --accent-orange: #f97316;
            --accent-purple: #8b5cf6;
            --accent-pink:   #ec4899;
            --accent-teal:   #14b8a6;
            --text-primary:  #1a1200;
            --text-muted:    #6b5c00;
            --text-dim:      #a08c3a;
            --grad-blue:     linear-gradient(135deg, #e8b800, #f5c518);
            --grad-green:    linear-gradient(135deg, #10b981, #14b8a6);
            --grad-orange:   linear-gradient(135deg, #f97316, #f59e0b);
            --grad-pink:     linear-gradient(135deg, #ec4899, #8b5cf6);
            --grad-sidebar:  linear-gradient(180deg, #1a1200 0%, #2d1e00 100%);
            --sidebar-w:     260px;
            --font-main:     'Plus Jakarta Sans', sans-serif;
            --font-mono:     'JetBrains Mono', monospace;
            --shadow-sm:     0 1px 3px rgba(232,184,0,0.08), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md:     0 4px 16px rgba(232,184,0,0.14), 0 2px 8px rgba(0,0,0,0.06);
            --shadow-lg:     0 10px 40px rgba(232,184,0,0.18), 0 4px 16px rgba(0,0,0,0.08);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font-main);
            background: var(--bg-main);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--grad-sidebar);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 4px 0 24px rgba(0,0,0,0.25);
        }

        .sidebar-brand {
            padding: 20px 20px 18px;
            border-bottom: 1px solid rgba(232,184,0,0.2);
        }
        .brand-logo {
            display: flex; align-items: center; gap: 10px; text-decoration: none;
        }
        .brand-icon {
            width: 56px; height: 56px; border-radius: 50%;
            overflow: hidden; flex-shrink: 0;
            border: 2.5px solid #e8b800;
            box-shadow: 0 0 14px rgba(232,184,0,0.45);
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .brand-icon:hover {
            transform: scale(1.08);
            box-shadow: 0 0 24px rgba(232,184,0,0.7);
        }
        .brand-icon img {
            width: 100%; height: 100%; object-fit: cover; display: block;
        }
        .brand-name {
            font-size: 17px; font-weight: 800;
            color: #ffffff; letter-spacing: -0.3px;
        }
        .brand-sub {
            font-size: 10px; color: rgba(255,255,255,0.45);
            font-family: var(--font-mono); margin-top: 2px;
        }

        .sidebar-nav { flex: 1; padding: 14px 0; }

        .nav-section-label {
            font-size: 9px; font-weight: 700;
            color: rgba(232,184,0,0.5);
            text-transform: uppercase; letter-spacing: 1.5px;
            padding: 10px 20px 5px;
            font-family: var(--font-mono);
        }

        .nav-item a {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 20px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 14px; font-weight: 500;
            margin: 1px 10px;
            border-radius: 10px;
            transition: all 0.2s;
        }
        .nav-item a:hover {
            color: #fff;
            background: rgba(232,184,0,0.15);
        }
        .nav-item a.active {
            color: #1a1200;
            background: #e8b800;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(232,184,0,0.4);
        }
        .nav-item a i { font-size: 16px; width: 20px; text-align: center; }

        .motor-info-item a {
            display: flex; align-items: center; gap: 8px;
            padding: 6px 14px;
            color: rgba(255,255,255,0.75);
            text-decoration: none;
            font-size: 12.5px; font-weight: 500;
            margin: 2px 10px;
            border-radius: 10px;
            transition: all 0.2s;
            cursor: default;
            pointer-events: none;
        }
        .motor-thumb {
            width: 44px; height: 28px;
            object-fit: contain; object-position: center;
            flex-shrink: 0;
            filter: drop-shadow(0 1px 3px rgba(0,0,0,0.3));
            transition: transform 0.2s;
        }
        .motor-info-item a:hover .motor-thumb { transform: scale(1.08); }
        .motor-info-text { display: flex; flex-direction: column; line-height: 1.3; }
        .motor-info-name { font-size: 12px; font-weight: 700; color: rgba(255,255,255,0.9); }
        .motor-info-unit { font-size: 10px; color: rgba(255,255,255,0.5); font-family: var(--font-mono); }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(232,184,0,0.2);
            margin-top: auto;
        }
        .user-card {
            background: rgba(232,184,0,0.1);
            border: 1px solid rgba(232,184,0,0.2);
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 10px;
            display: flex; align-items: center; gap: 10px;
        }
        .user-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #e8b800, #f5c518);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; font-weight: 800; color: #1a1200;
            flex-shrink: 0;
        }
        .user-name { font-size: 13px; font-weight: 700; color: #fff; }
        .user-role { font-size: 10px; color: rgba(255,255,255,0.45); font-family: var(--font-mono); }

        .logout-btn {
            display: flex; align-items: center; gap: 8px;
            padding: 10px 14px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 10px;
            color: rgba(255,255,255,0.75);
            font-size: 13px; font-weight: 600;
            text-decoration: none;
            transition: all 0.2s; width: 100%;
            justify-content: center; cursor: pointer;
            font-family: var(--font-main);
        }
        .logout-btn:hover {
            background: rgba(239,68,68,0.3);
            border-color: rgba(239,68,68,0.5);
            color: #fff;
        }

        /* ===== MAIN ===== */
        .main-content {
            margin-left: var(--sidebar-w);
            flex: 1; min-height: 100vh;
            display: flex; flex-direction: column;
        }

        .topbar {
            height: 64px;
            background: var(--bg-topbar);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center;
            padding: 0 28px; gap: 16px;
            position: sticky; top: 0; z-index: 100;
            box-shadow: var(--shadow-sm);
        }
        .topbar-title { font-size: 16px; font-weight: 700; color: var(--text-primary); }
        .topbar-right { margin-left: auto; display: flex; align-items: center; gap: 12px; }
        .topbar-date {
            background: #fffbeb;
            border: 1px solid var(--border-light);
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 12px; font-weight: 600;
            color: #c9a000;
            font-family: var(--font-mono);
        }

        .page-body {
            flex: 1; padding: 28px;
            animation: fadeIn 0.25s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ===== CARDS ===== */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border);
            padding: 16px 20px;
            border-radius: 16px 16px 0 0;
        }
        .card-body { padding: 20px; }
        .card-title { font-size: 14px; font-weight: 700; color: var(--text-primary); margin: 0; }

        /* ===== STAT CARDS ===== */
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s;
            overflow: hidden;
            position: relative;
        }
        .stat-card::before {
            content: '';
            position: absolute; top: 0; right: 0;
            width: 80px; height: 80px;
            border-radius: 50%; opacity: 0.07;
            transform: translate(20px, -20px);
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); }
        .stat-card.blue::before  { background: #e8b800; }
        .stat-card.green::before { background: var(--accent-green); }
        .stat-card.orange::before{ background: var(--accent-orange); }
        .stat-card.purple::before{ background: var(--accent-purple); }

        .stat-icon {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; margin-bottom: 14px;
        }
        .stat-icon.blue   { background: #fffbeb; color: #c9a000; }
        .stat-icon.green  { background: linear-gradient(135deg,#d1fae5,#a7f3d0); color: var(--accent-green); }
        .stat-icon.red    { background: linear-gradient(135deg,#fee2e2,#fecaca); color: var(--accent-red); }
        .stat-icon.yellow { background: linear-gradient(135deg,#fef3c7,#fde68a); color: var(--accent-yellow); }
        .stat-icon.purple { background: linear-gradient(135deg,#ede9fe,#ddd6fe); color: var(--accent-purple); }
        .stat-icon.orange { background: linear-gradient(135deg,#ffedd5,#fed7aa); color: var(--accent-orange); }
        .stat-icon.teal   { background: linear-gradient(135deg,#ccfbf1,#99f6e4); color: var(--accent-teal); }
        .stat-icon.pink   { background: linear-gradient(135deg,#fce7f3,#fbcfe8); color: var(--accent-pink); }

        .stat-value { font-size: 30px; font-weight: 800; color: var(--text-primary); line-height: 1; }
        .stat-label { font-size: 12px; color: var(--text-muted); margin-top: 6px; font-weight: 500; }

        /* ===== ALERTS ===== */
        .alert {
            border-radius: 12px; border: 1px solid;
            padding: 12px 16px; font-size: 14px;
            display: flex; align-items: center; gap: 10px; font-weight: 500;
        }
        .alert-success { background: #f0fdf4; border-color: #bbf7d0; color: #15803d; }
        .alert-danger  { background: #fef2f2; border-color: #fecaca; color: #dc2626; }
        .alert-warning { background: #fffbeb; border-color: #fde68a; color: #d97706; }
        .alert-info    { background: #fffbeb; border-color: #fde68a; color: #c9a000; }

        /* ===== FORMS ===== */
        .form-label { font-size: 13px; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; }
        .form-control, .form-select {
            background: #fffdf0;
            border: 1.5px solid var(--border);
            border-radius: 10px; color: var(--text-primary);
            font-family: var(--font-main); font-size: 14px; font-weight: 500;
            padding: 10px 14px; transition: all 0.2s;
        }
        .form-control:focus, .form-select:focus {
            background: #fff; border-color: #e8b800;
            color: var(--text-primary);
            box-shadow: 0 0 0 3px rgba(232,184,0,0.15); outline: none;
        }
        .form-control::placeholder { color: var(--text-dim); }
        .form-select option { background: #fff; color: var(--text-primary); }
        .invalid-feedback { font-size: 12px; color: var(--accent-red); }
        .is-invalid { border-color: var(--accent-red) !important; }

        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(0.4) sepia(1) saturate(5) hue-rotate(10deg);
            cursor: pointer;
        }

        /* ===== BUTTONS ===== */
        .btn {
            font-family: var(--font-main); font-weight: 600; font-size: 13px;
            border-radius: 10px; padding: 9px 18px; transition: all 0.2s;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #e8b800, #f5c518);
            border: none; color: #1a1200;
            box-shadow: 0 2px 8px rgba(232,184,0,0.35);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #c9a000, #e8b800);
            color: #1a1200; box-shadow: 0 4px 14px rgba(232,184,0,0.45);
            transform: translateY(-1px);
        }
        .btn-success { background: var(--grad-green); border: none; color: #fff; box-shadow: 0 2px 8px rgba(16,185,129,0.35); }
        .btn-success:hover { background: linear-gradient(135deg,#059669,#0d9488); color:#fff; transform:translateY(-1px); }
        .btn-danger  { background:#fef2f2; border:1.5px solid #fecaca; color:var(--accent-red); }
        .btn-danger:hover { background:#fee2e2; color:var(--accent-red); }
        .btn-warning { background:var(--grad-orange); border:none; color:#fff; box-shadow:0 2px 8px rgba(249,115,22,0.35); }
        .btn-warning:hover { color:#fff; transform:translateY(-1px); }
        .btn-secondary { background:#f5f0e0; border:1.5px solid var(--border); color:var(--text-muted); }
        .btn-secondary:hover { background:#ede8d0; color:var(--text-primary); }
        .btn-outline-secondary { background:transparent; border:1.5px solid var(--border); color:var(--text-muted); }
        .btn-outline-secondary:hover { background:#fffbeb; color:var(--text-primary); }

        /* ===== TABLES ===== */
        .table { color:var(--text-primary); border-color:var(--border); font-size:13px; }
        .table thead th { background:#fffbeb; color:var(--text-muted); font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; border-color:var(--border); padding:12px 14px; }
        .table tbody td { border-color:var(--border); padding:12px 14px; vertical-align:middle; }
        .table tbody tr:hover td { background:#fffdf5; }

        /* ===== BADGES ===== */
        .badge-method { padding:5px 12px; border-radius:20px; font-size:11px; font-weight:700; font-family:var(--font-mono); }
        .badge-ls    { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }
        .badge-des   { background:#eff6ff; color:#2563eb; border:1px solid #bfdbfe; }
        .badge-small { background:rgba(232,184,0,0.15); color:#92400e; border:1px solid #fde68a; }
        .badge-auto  { background:rgba(249,115,22,0.12); color:#c2410c; border:1px solid #fed7aa; }
        .badge-big   { background:rgba(202,138,4,0.15); color:#78350f; border:1px solid #fde047; }

        /* ===== ACCURACY CARDS ===== */
        .accuracy-card { border-radius:12px; padding:16px; text-align:center; }
        .accuracy-card.red-theme    { background:#fef2f2; border:1.5px solid #fecaca; }
        .accuracy-card.yellow-theme { background:#fffbeb; border:1.5px solid #fde68a; }
        .accuracy-value { font-size:22px; font-weight:800; font-family:var(--font-mono); }
        .red-theme    .accuracy-value { color:#dc2626; }
        .yellow-theme .accuracy-value { color:#c9a000; }
        .accuracy-label { font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; color:var(--text-dim); margin-top:4px; }

        /* ===== PREDICTION GRID ===== */
        .pred-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(100px,1fr)); gap:8px; }
        .pred-cell { border-radius:10px; padding:10px 8px; text-align:center; }
        .pred-cell.red-cell    { background:#fef2f2; border:1.5px solid #fecaca; }
        .pred-cell.yellow-cell { background:#fffbeb; border:1.5px solid #fde68a; }
        .pred-cell .period { font-size:10px; color:var(--text-dim); font-family:var(--font-mono); }
        .pred-cell .value  { font-size:16px; font-weight:800; margin-top:2px; }
        .red-cell    .value { color:#dc2626; }
        .yellow-cell .value { color:#c9a000; }

        /* ===== FILE UPLOAD ===== */
        .upload-zone { border:2px dashed #fde68a; border-radius:14px; padding:40px; text-align:center; transition:all 0.2s; cursor:pointer; background:#fffdf0; }
        .upload-zone:hover,.upload-zone.dragover { border-color:#e8b800; background:#fffbeb; }
        .upload-zone i { font-size:40px; color:#c9a000; }

        /* ===== PAGINATION ===== */
        .pagination { gap:4px; }
        .page-link { background:var(--bg-card); border-color:var(--border); color:var(--text-muted); border-radius:8px !important; font-size:13px; font-weight:600; padding:6px 12px; transition:all 0.15s; }
        .page-link:hover { background:#fffbeb; color:#c9a000; border-color:#fde68a; }
        .page-item.active .page-link { background:linear-gradient(135deg,#e8b800,#f5c518); border-color:transparent; color:#1a1200; }
        .page-item.disabled .page-link { opacity:0.4; }

        /* ===== MOTOR DOT ===== */
        .motor-dot { display:inline-block; width:8px; height:8px; border-radius:50%; }

        /* ===== MOBILE ===== */
        .hamburger { display:none; }
        @media (max-width:768px) {
            .sidebar { transform:translateX(-100%); transition:transform 0.25s ease; }
            .sidebar.open { transform:translateX(0); }
            .main-content { margin-left:0; }
            .hamburger { display:flex; }
            .page-body { padding:16px; }
        }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar { width:6px; height:6px; }
        ::-webkit-scrollbar-track { background:transparent; }
        ::-webkit-scrollbar-thumb { background:#fde68a; border-radius:3px; }
        ::-webkit-scrollbar-thumb:hover { background:#e8b800; }

        /* ===== BACKGROUND DECORATION ===== */
        .page-body::before {
            content: '';
            position: fixed; top: -200px; right: -200px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(232,184,0,0.06) 0%, transparent 70%);
            border-radius: 50%; pointer-events: none; z-index: 0;
        }
        .page-body > * { position: relative; z-index: 1; }

        /* ===== LOGO LIGHTBOX ===== */
        @keyframes zoomIn {
            from { transform: scale(0.4); opacity: 0; }
            to   { transform: scale(1);   opacity: 1; }
        }
        @keyframes fadeInBg {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
        #logoLightbox { animation: fadeInBg 0.2s ease; }
        #logoLightbox .lb-img-wrap { animation: zoomIn 0.25s cubic-bezier(0.34,1.56,0.64,1); }
    </style>
    @stack('styles')
</head>
<body>

<!-- ===== SIDEBAR ===== -->
<nav class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-logo">
            <div class="brand-icon" onclick="bukaLogo(event)" title="Klik untuk memperbesar">
                <img src="{{ asset('images/motors/logofalsud.png') }}" alt="UD FALSUD">
            </div>
            <div>
                <div class="brand-name">Rental FALSUD</div>
                <div class="brand-sub">Rental Motor Malang</div>
            </div>
        </a>
    </div>

    <div class="sidebar-nav">
        <div class="nav-section-label">Menu Utama</div>
        <div class="nav-item">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('upload.index') }}" class="{{ request()->routeIs('upload.*') ? 'active' : '' }}">
                <i class="bi bi-cloud-arrow-up"></i> Upload Data
            </a>
        </div>
        <div class="nav-item">
            <a href="{{ route('calculation.index') }}"
               class="{{ request()->routeIs('calculation.*') || request()->routeIs('result.*') ? 'active' : '' }}">
                <i class="bi bi-calculator"></i> Perhitungan
            </a>
        </div>

        <div class="nav-section-label" style="margin-top:8px">Laporan</div>
        <div class="nav-item">
            <a href="{{ route('history.index') }}" class="{{ request()->routeIs('history.*') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat
            </a>
        </div>
    </div>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
            <div>
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">ADMIN</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</nav>

<div id="overlay"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.35);backdrop-filter:blur(2px);z-index:999"
     onclick="toggleSidebar()"></div>

<!-- ===== MAIN CONTENT ===== -->
<div class="main-content">
    <div class="topbar">
        <button class="hamburger btn btn-secondary p-2 me-1" onclick="toggleSidebar()" style="border:none">
            <i class="bi bi-list" style="font-size:18px"></i>
        </button>
        <div>
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        </div>
        <div class="topbar-right">
            <div class="topbar-date"><i class="bi bi-calendar3 me-1"></i>{{ now()->format('d M Y') }}</div>
        </div>
    </div>

    <div class="page-body">
        @if(session('success'))
        <div class="alert alert-success mb-4">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger mb-4">
            <i class="bi bi-x-circle-fill"></i> {{ session('error') }}
        </div>
        @endif
        @yield('content')
    </div>
</div>

<!-- ===== LOGO LIGHTBOX ===== -->
<div id="logoLightbox"
     onclick="tutupLogo()"
     style="display:none;position:fixed;inset:0;
            background:rgba(0,0,0,0.88);
            z-index:99999;
            align-items:center;
            justify-content:center;
            backdrop-filter:blur(10px);
            cursor:pointer;">

    <div class="lb-img-wrap" style="position:relative;" onclick="event.stopPropagation()">

        {{-- Gambar logo --}}
        <img id="logoLightboxImg"
             src="{{ asset('images/motors/logofalsud.png') }}"
             style="width:260px;height:260px;
                    border-radius:50%;
                    border:4px solid #e8b800;
                    box-shadow:0 0 60px rgba(232,184,0,0.6),
                               0 0 120px rgba(232,184,0,0.2);
                    object-fit:cover;
                    display:block;">

        {{-- Nama di bawah logo --}}
        <div style="text-align:center;margin-top:16px;">
            <div style="font-size:18px;font-weight:800;color:#fff;letter-spacing:0.5px;">
                Rental <span style="color:#e8b800;">FALSUD</span>
            </div>
            <div style="font-size:11px;color:rgba(255,255,255,0.5);
                        font-family:'JetBrains Mono',monospace;
                        margin-top:4px;text-transform:uppercase;letter-spacing:2px;">
                Rental Motor Malang
            </div>
        </div>

        {{-- Tombol tutup --}}
        <button onclick="tutupLogo()"
                style="position:absolute;top:-10px;right:-10px;
                       width:30px;height:30px;border-radius:50%;
                       background:#e8b800;border:none;cursor:pointer;
                       font-size:14px;font-weight:700;color:#1a1200;
                       display:flex;align-items:center;justify-content:center;
                       box-shadow:0 2px 8px rgba(0,0,0,0.4);">
            ✕
        </button>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    Chart.defaults.color = '#a08c3a';
    Chart.defaults.borderColor = '#f0e6c0';
    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

    function toggleSidebar() {
        const s = document.getElementById('sidebar');
        const o = document.getElementById('overlay');
        s.classList.toggle('open');
        o.style.display = s.classList.contains('open') ? 'block' : 'none';
    }

    /* ── Logo Lightbox ── */
    function bukaLogo(e) {
        e.preventDefault();
        e.stopPropagation();
        const lb = document.getElementById('logoLightbox');
        lb.style.display = 'flex';
    }
    function tutupLogo() {
        document.getElementById('logoLightbox').style.display = 'none';
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') tutupLogo();
    });

    setTimeout(() => {
    // Hanya hide alert success dan error, BUKAN warning
    document.querySelectorAll('.alert-success, .alert-danger').forEach(el => {
        el.style.transition = 'opacity 0.4s';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 400);
    });
}, 4000);
</script>
@stack('scripts')
</body>
</html>