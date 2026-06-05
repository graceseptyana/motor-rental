@extends('layouts.app')
@section('title','Upload Data')
@section('page-title','Upload Data Historis')
@section('breadcrumb','rental / upload')

@section('content')
<style>
.upload-wrapper { max-width: 720px; margin: 0 auto; }

.excel-drop-zone {
    border: 2px dashed rgba(232,184,0,0.35); border-radius: 16px; padding: 52px 24px;
    text-align: center; cursor: pointer; transition: all 0.25s; background: rgba(232,184,0,0.03);
}
.excel-drop-zone:hover, .excel-drop-zone.dragover { border-color: #e8b800; background: rgba(232,184,0,0.07); }
.excel-drop-zone.has-file { border-color: rgba(22,163,74,0.5); background: rgba(22,163,74,0.04); }
.dz-icon { font-size: 48px; color: rgba(232,184,0,0.5); display: block; margin-bottom: 14px; transition: color 0.2s; }
.excel-drop-zone.has-file .dz-icon { color: #16a34a; }
.dz-title { font-size: 15px; font-weight: 600; color: var(--text-primary,#1a1200); margin-bottom: 6px; }
.dz-sub   { font-size: 12px; color: var(--text-dim,#a08c3a); }
.dz-filename {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(22,163,74,0.1); color: #16a34a; border-radius: 8px;
    padding: 6px 16px; font-size: 13px; font-weight: 600; margin-top: 12px;
    max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}

.btn-upload {
    width: 100%; padding: 14px; font-size: 15px; font-weight: 700; border-radius: 12px; border: none;
    background: linear-gradient(135deg, #e8b800, #f5c518); color: #1a1200; cursor: pointer;
    transition: opacity 0.2s, transform 0.15s;
    display: flex; align-items: center; justify-content: center; gap: 8px; margin-top: 20px;
    box-shadow: 0 4px 16px rgba(232,184,0,0.35);
}
.btn-upload:hover:not(:disabled) { opacity: 0.9; transform: translateY(-1px); }
.btn-upload:disabled { opacity: 0.4; cursor: not-allowed; }

.alert-ok  { background:rgba(22,163,74,0.08);  border:1px solid rgba(22,163,74,0.25);  border-radius:12px; padding:14px 18px; display:flex; align-items:center; gap:10px; color:#16a34a; font-size:14px; font-weight:500; margin-bottom:20px; }
.alert-err { background:rgba(220,38,38,0.08);  border:1px solid rgba(220,38,38,0.25);  border-radius:12px; padding:14px 18px; display:flex; align-items:center; gap:10px; color:#dc2626; font-size:14px; font-weight:500; margin-bottom:20px; }

.data-result-card { border-radius:16px; background:#fff; border:1px solid #f0e6c0; overflow:hidden; box-shadow:0 4px 20px rgba(232,184,0,0.08); }
.data-result-header { padding:16px 20px; border-bottom:1px solid #f0e6c0; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; background:#fffbeb; }
.data-result-header h5 { font-size:14px; font-weight:700; color:#1a1200; margin:0; display:flex; align-items:center; gap:8px; }

.summary-bar { display:flex; gap:8px; padding:14px 20px; border-bottom:1px solid #f0e6c0; flex-wrap:wrap; align-items:center; background:#fffdf0; }
.sum-pill { font-size:12px; padding:4px 12px; border-radius:20px; font-weight:600; }
.sum-pill-small { background:rgba(232,184,0,0.15);  color:#b45309; }
.sum-pill-auto  { background:rgba(249,115,22,0.12); color:#c2410c; }
.sum-pill-big   { background:rgba(202,138,4,0.15);  color:#854d0e; }
.sum-pill-del {
    margin-left:auto; background:rgba(220,38,38,0.07); border:1px solid rgba(220,38,38,0.2);
    color:#dc2626; border-radius:7px; padding:4px 14px; font-size:12px;
    font-weight:600; cursor:pointer; transition:all 0.2s; display:flex; align-items:center; gap:6px;
    font-family:var(--font-main,'Plus Jakarta Sans',sans-serif);
}
.sum-pill-del:hover { background:rgba(220,38,38,0.15); }

.data-table-wrap { max-height: 340px; overflow-y: auto; }
.data-table-wrap::-webkit-scrollbar { width: 4px; }
.data-table-wrap::-webkit-scrollbar-thumb { background:#fde68a; border-radius:4px; }
.data-table { width:100%; border-collapse:collapse; font-size:13px; font-family:var(--font-mono,monospace); }
.data-table thead th {
    position:sticky; top:0; z-index:1; background:#fffbeb;
    padding:11px 20px; font-size:11px; font-weight:700; letter-spacing:0.8px;
    text-transform:uppercase; border-bottom:1px solid #fde68a; text-align:center;
}
.data-table thead th:first-child { text-align:left; color:#a08c3a; }
.data-table thead th.th-small { color:#b45309; }
.data-table thead th.th-auto  { color:#c2410c; }
.data-table thead th.th-big   { color:#854d0e; }
.data-table tbody tr { border-bottom:1px solid #f5f0e0; transition:background 0.12s; }
.data-table tbody tr:last-child { border-bottom:none; }
.data-table tbody tr:hover { background:#fffbeb; }
.data-table tbody td { padding:9px 20px; text-align:center; }
.data-table tbody td:first-child { text-align:left; color:#a08c3a; font-size:12px; font-weight:600; }
.data-table tbody td.td-small { color:#b45309; font-weight:700; }
.data-table tbody td.td-auto  { color:#c2410c; font-weight:700; }
.data-table tbody td.td-big   { color:#854d0e; font-weight:700; }
.data-table tbody td.td-empty { color:#d1c080; font-size:11px; }

.action-bar { display:grid; grid-template-columns:1fr 1fr; gap:12px; padding:16px 20px; border-top:1px solid #f0e6c0; background:#fffdf0; }
.btn-act { padding:12px 18px; border-radius:12px; font-size:14px; font-weight:600; display:flex; align-items:center; justify-content:center; gap:8px; cursor:pointer; transition:all 0.2s; text-decoration:none; border:none; }
.btn-act-calc { background:linear-gradient(135deg,#e8b800,#f5c518); color:#1a1200; box-shadow:0 4px 12px rgba(232,184,0,0.35); }
.btn-act-calc:hover { opacity:0.9; color:#1a1200; transform:translateY(-1px); }
.btn-act-reupload { background:#f5f0e0; border:1.5px solid #f0e6c0; color:#6b5c00; }
.btn-act-reupload:hover { background:#ede8d0; color:#1a1200; transform:translateY(-1px); }
</style>

<div class="upload-wrapper">

    @if(session('success'))
    <div class="alert-ok"><i class="bi bi-check-circle-fill"></i>{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert-err"><i class="bi bi-exclamation-triangle-fill"></i>{{ session('error') }}</div>
    @endif

    @php $showForm = $existingData->isEmpty() || session('show_form', false); @endphp

    @if($showForm)
    {{-- UPLOAD FORM --}}
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <i class="bi bi-cloud-upload me-2" style="color:#e8b800"></i>
                Upload File Excel
            </h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('upload.store') }}" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <div class="excel-drop-zone" id="dropZone" onclick="document.getElementById('fileInput').click()">
                    <i class="bi bi-file-earmark-excel dz-icon"></i>
                    <div class="dz-title" id="dzTitle">Klik atau drag & drop file Excel</div>
                    <div class="dz-sub" id="dzSub">.xlsx atau .xls · Maks 2MB</div>
                    <div class="dz-filename d-none" id="dzFilename">
                        <i class="bi bi-file-earmark-check"></i>
                        <span id="dzFilenameText"></span>
                    </div>
                </div>
                <input type="file" id="fileInput" name="file" accept=".xlsx,.xls" style="display:none">
                @error('file')
                <div style="color:#dc2626;font-size:12px;margin-top:8px">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                </div>
                @enderror
                <button type="submit" class="btn-upload" id="uploadBtn" disabled>
                    <i class="bi bi-cloud-upload"></i> Upload & Import
                </button>
            </form>
        </div>
    </div>

    @else
    {{-- DATA TERSIMPAN --}}
    @php
        $tableData   = [];
        $allPeriodes = collect();
        foreach ($existingData as $mtId => $rows) {
            $mtName = strtolower($rows->first()->motorType->name);
            foreach ($rows as $row) {
                $tableData[$mtName][$row->periode] = $row->value;
                $allPeriodes->push($row->periode);
            }
        }
        $allPeriodes = $allPeriodes->unique()->sort()->values();
        $motorCols   = ['small', 'auto', 'big'];
    @endphp

    <div class="data-result-card">
        <div class="data-result-header">
            <h5>
                <i class="bi bi-database-fill" style="color:#e8b800"></i>
                Data Historis Tersimpan
            </h5>
            <span style="font-size:12px;color:#a08c3a">
                {{ $allPeriodes->count() }} periode &middot; {{ $existingData->sum(fn($d) => $d->count()) }} record
            </span>
        </div>

        <div class="summary-bar">
            @foreach($existingData as $mtId => $rows)
            @php $mt = $rows->first()->motorType; $slug = strtolower($mt->name); @endphp
            <span class="sum-pill sum-pill-{{ $slug }}">
                Motor {{ $mt->name }} &middot; {{ $rows->count() }} data
            </span>
            @endforeach
            <button type="button" class="sum-pill-del" onclick="bukaModalUpload()">
                <i class="bi bi-trash"></i> Hapus Semua
            </button>
        </div>

        <div class="data-table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Periode</th>
                        @foreach($motorCols as $col)
                        @if(isset($tableData[$col]))
                        <th class="th-{{ $col }}">Motor {{ ucfirst($col) }}</th>
                        @endif
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($allPeriodes as $p)
                    <tr>
                        <td>{{ $p }}</td>
                        @foreach($motorCols as $col)
                        @if(isset($tableData[$col]))
                        <td class="{{ isset($tableData[$col][$p]) ? 'td-'.$col : 'td-empty' }}">
                            {{ $tableData[$col][$p] ?? '—' }}
                        </td>
                        @endif
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="action-bar">
            <a href="{{ route('calculation.index') }}" class="btn-act btn-act-calc">
                <i class="bi bi-calculator-fill"></i> Hitung Prediksi
            </a>
            <a href="{{ route('upload.reupload') }}" class="btn-act btn-act-reupload">
                <i class="bi bi-arrow-repeat"></i> Upload Ulang
            </a>
        </div>
    </div>
    @endif

</div>

{{-- MODAL HAPUS SEMUA --}}
<div id="modalOverlayUpload"
     style="display:none;position:fixed;inset:0;background:rgba(26,18,0,0.5);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center">

    <div style="background:#fff;border:1.5px solid #fde68a;border-radius:20px;padding:36px 32px;max-width:380px;width:90%;text-align:center;box-shadow:0 20px 60px rgba(232,184,0,0.15),0 4px 16px rgba(0,0,0,0.08);animation:modalIn 0.2s ease">

        <div style="font-size:48px;margin-bottom:16px">🗑️</div>

        <div style="font-size:18px;font-weight:700;color:#1a1200;margin-bottom:8px">
            Hapus Semua Data Historis?
        </div>

        <div style="font-size:13px;color:#6b5c00;margin-bottom:28px;line-height:1.7">
            Semua data historis akan dihapus permanen.<br>
            Tindakan ini <strong style="color:#dc2626">tidak dapat dibatalkan</strong>.
        </div>

        <form method="POST" action="{{ route('upload.destroyAll') }}">
            @csrf
            @method('DELETE')
            <div style="display:flex;gap:10px;justify-content:center">
                <button type="button"
                        onclick="tutupModalUpload()"
                        style="flex:1;padding:11px;background:#f5f0e0;border:1.5px solid #f0e6c0;border-radius:10px;color:#6b5c00;font-family:var(--font-main);font-size:13px;font-weight:600;cursor:pointer;transition:all 0.15s"
                        onmouseover="this.style.background='#ede8d0'"
                        onmouseout="this.style.background='#f5f0e0'">
                    Batal
                </button>
                <button type="submit"
                        style="flex:1;padding:11px;background:rgba(220,38,38,0.08);border:1.5px solid rgba(220,38,38,0.3);border-radius:10px;color:#dc2626;font-family:var(--font-main);font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;transition:all 0.15s"
                        onmouseover="this.style.background='rgba(220,38,38,0.15)'"
                        onmouseout="this.style.background='rgba(220,38,38,0.08)'">
                    <i class="bi bi-trash3"></i> Ya, Hapus Semua
                </button>
            </div>
        </form>
    </div>
</div>

<style>
@keyframes modalIn {
    from { opacity:0; transform:scale(0.92) translateY(10px); }
    to   { opacity:1; transform:scale(1) translateY(0); }
}
</style>

@endsection

@push('scripts')
<script>
const dropZone  = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');
const uploadBtn = document.getElementById('uploadBtn');

if (dropZone && fileInput) {
    dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('dragover'); });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));
    dropZone.addEventListener('drop', e => {
        e.preventDefault(); dropZone.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file) {
            const dt = new DataTransfer(); dt.items.add(file); fileInput.files = dt.files;
            setFile(file.name);
        }
    });
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length) setFile(fileInput.files[0].name);
    });
}

function setFile(name) {
    document.getElementById('dzTitle').textContent = 'File siap diupload';
    document.getElementById('dzSub').classList.add('d-none');
    document.getElementById('dzFilenameText').textContent = name;
    document.getElementById('dzFilename').classList.remove('d-none');
    dropZone.classList.add('has-file');
    if (uploadBtn) uploadBtn.disabled = false;
}

function bukaModalUpload() {
    document.getElementById('modalOverlayUpload').style.display = 'flex';
}

function tutupModalUpload() {
    document.getElementById('modalOverlayUpload').style.display = 'none';
}

document.getElementById('modalOverlayUpload').addEventListener('click', function(e) {
    if (e.target === this) tutupModalUpload();
});
</script>
@endpush