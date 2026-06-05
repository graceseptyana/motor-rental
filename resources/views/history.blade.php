@extends('layouts.app')
@section('title','Riwayat')
@section('page-title','Riwayat Prediksi')
@section('breadcrumb','rental / riwayat')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
/* ── FLATPICKR CUSTOM THEME ── */
.flatpickr-calendar {
    background: #ffffff !important;
    border: 1.5px solid #fde68a !important;
    border-radius: 14px !important;
    box-shadow: 0 8px 32px rgba(232,184,0,0.18) !important;
    font-family: var(--font-main) !important;
    overflow: hidden;
}
.flatpickr-months {
    background: #1a1200 !important;
    border-radius: 12px 12px 0 0 !important;
    padding: 6px 0 !important;
}
.flatpickr-month {
    color: #e8b800 !important;
    fill: #e8b800 !important;
}
.flatpickr-current-month {
    color: #e8b800 !important;
    font-size: 14px !important;
    font-weight: 700 !important;
}
.flatpickr-current-month select,
.flatpickr-current-month input {
    color: #e8b800 !important;
    font-weight: 700 !important;
}
.flatpickr-prev-month,
.flatpickr-next-month {
    color: #e8b800 !important;
    fill: #e8b800 !important;
}
.flatpickr-prev-month:hover,
.flatpickr-next-month:hover {
    background: rgba(232,184,0,0.2) !important;
    border-radius: 50% !important;
}
.flatpickr-weekdays {
    background: #2d1e00 !important;
}
.flatpickr-weekday {
    color: #e8b800 !important;
    font-size: 11px !important;
    font-weight: 700 !important;
}
.flatpickr-day {
    color: #1a1200 !important;
    border-radius: 8px !important;
    font-size: 12px !important;
    font-weight: 500 !important;
}
.flatpickr-day:hover {
    background: #fef3c7 !important;
    border-color: #fde68a !important;
    color: #1a1200 !important;
}
.flatpickr-day.selected,
.flatpickr-day.selected:hover {
    background: #e8b800 !important;
    border-color: #e8b800 !important;
    color: #1a1200 !important;
    font-weight: 700 !important;
}
.flatpickr-day.today {
    border-color: #e8b800 !important;
    color: #b45309 !important;
    font-weight: 700 !important;
}
.flatpickr-day.today:hover {
    background: #fef3c7 !important;
}
.flatpickr-day.flatpickr-disabled {
    color: #d1d5db !important;
}

/* Input kalender custom */
.date-input-wrap {
    position: relative;
}
.date-input-wrap .form-control {
    padding-right: 36px;
    cursor: pointer;
}
.date-input-wrap .cal-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #e8b800;
    font-size: 15px;
    pointer-events: none;
}

/* Pagination */
.pagination .page-link {
    background: var(--bg-card, #fff);
    border: 1px solid #fde68a;
    color: #a08c3a;
    font-size: 12px;
    font-weight: 600;
    padding: 5px 11px;
    transition: all 0.15s;
}
.pagination .page-link:hover {
    background: #e8b800;
    border-color: #e8b800;
    color: #1a1200;
}
.pagination .page-item.active .page-link {
    background: #e8b800;
    border-color: #e8b800;
    color: #1a1200;
}
.pagination .page-item.disabled .page-link {
    background: transparent;
    border-color: #fde68a;
    color: #d1b86a;
    cursor: not-allowed;
}

/* MAPE DES biru */
.mape-des { color: #2563eb; font-weight: 600; }
</style>
@endpush

@section('content')

<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('history.index') }}" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label" style="font-size:11px">Filter Jenis Motor</label>
                <select name="motor_type_id" class="form-select form-select-sm">
                    <option value="">Semua Motor</option>
                    @foreach($motorTypes as $mt)
                    <option value="{{ $mt->id }}" {{ request('motor_type_id')==$mt->id?'selected':'' }}>
                        {{ $mt->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label" style="font-size:11px">Filter Tanggal</label>
                <div class="date-input-wrap">
                    <input type="text"
                           id="datePicker"
                           name="date"
                           class="form-control form-control-sm"
                           placeholder="dd/mm/yyyy"
                           value="{{ request('date') ? \Carbon\Carbon::parse(request('date'))->format('d/m/Y') : '' }}"
                           readonly>
                    <i class="bi bi-calendar3 cal-icon"></i>
                </div>
                {{-- Hidden input untuk nilai asli (format Y-m-d) --}}
                <input type="hidden" id="dateValue" name="date_raw" value="{{ request('date') }}">
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-funnel"></i> Filter
                </button>
            </div>

            @if(request()->hasAny(['motor_type_id','date']))
            <div class="col-md-2">
                <a href="{{ route('history.index') }}"
                   class="btn btn-secondary btn-sm w-100">
                    <i class="bi bi-x"></i> Reset
                </a>
            </div>
            @endif
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title">
            <i class="bi bi-table me-2" style="color:var(--accent-blue)"></i>
            Semua Prediksi
        </h5>
        <div class="d-flex align-items-center gap-3">
            <span style="font-size:12px;color:var(--text-dim);font-family:var(--font-mono)">
                {{ $predictions->total() }} total
            </span>
            @if(!$predictions->isEmpty())
            <button type="button"
                    class="btn btn-danger btn-sm"
                    onclick="bukaModal('{{ route('history.destroyAll') }}', true)">
                <i class="bi bi-trash3"></i> Hapus Semua
            </button>
            @endif
        </div>
    </div>

    <div class="card-body p-0">

        @if($predictions->isEmpty())
        <div class="text-center py-5">
            <i class="bi bi-inbox" style="font-size:48px;color:var(--text-dim)"></i>
            <div style="color:var(--text-muted);margin-top:12px;font-size:15px;font-weight:600">
                Belum ada riwayat
            </div>
            <a href="{{ route('calculation.index') }}" class="btn btn-primary mt-3">
                <i class="bi bi-calculator"></i> Hitung Prediksi
            </a>
        </div>
        @else

        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal &amp; Waktu</th>
                        <th>Jenis Motor</th>
                        <th>Periode</th>
                        <th>Metode Terbaik</th>
                        <th>MAPE LS</th>
                        <th>MAPE DES</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($predictions as $i=>$pred)
                    <tr>
                        <td>{{ $predictions->firstItem()+$i }}</td>

                        <td style="font-size:12px">
                            {{ $pred->calculation_date->format('d M Y') }}<br>
                            <span style="color:var(--text-dim)">
                                {{ $pred->calculation_date->format('H:i:s') }}
                            </span>
                        </td>

                        <td>
                            <span class="badge-method">
                                {{ $pred->motorType->name }}
                            </span>
                        </td>

                        <td>{{ $pred->periods }}</td>

                        <td>
                            <span class="badge-method {{ $pred->best_method==='Least Square'?'badge-ls':'badge-des' }}">
                                {{ $pred->best_method==='Least Square'?'LS':'DES' }}
                            </span>
                        </td>

                        <td style="color:var(--accent-red);font-weight:600">
                            {{ $pred->ls_mape }}%
                        </td>

                        <td class="mape-des">
                            {{ $pred->des_mape }}%
                        </td>

                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('result.show',$pred->id) }}"
                                   class="btn btn-secondary btn-sm py-1 px-2">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('result.pdf',$pred->id) }}"
                                   class="btn btn-primary btn-sm py-1 px-2"
                                   target="_blank">
                                    <i class="bi bi-file-pdf"></i>
                                </a>
                                <button type="button"
                                        class="btn btn-danger btn-sm py-1 px-2"
                                        onclick="bukaModal('{{ route('history.destroy',$pred->id) }}', false)">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($predictions->hasPages())
        <div class="d-flex align-items-center justify-content-between px-4 py-3"
             style="border-top:1px solid var(--border-color);">
            <span style="font-size:12px;color:var(--text-dim);font-family:var(--font-mono)">
                Menampilkan {{ $predictions->firstItem() }}–{{ $predictions->lastItem() }}
                dari {{ $predictions->total() }} hasil
            </span>
            <nav>
                <ul class="pagination pagination-sm mb-0 gap-1">
                    <li class="page-item {{ $predictions->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link"
                           href="{{ $predictions->onFirstPage() ? '#' : $predictions->previousPageUrl() }}"
                           style="border-radius:8px;">
                            <i class="bi bi-chevron-left" style="font-size:11px;"></i> Prev
                        </a>
                    </li>

                    @php
                        $current = $predictions->currentPage();
                        $last    = $predictions->lastPage();
                        $from    = max(1, $current - 2);
                        $to      = min($last, $current + 2);
                    @endphp

                    @if($from > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $predictions->url(1) }}" style="border-radius:8px;">1</a>
                        </li>
                        @if($from > 2)
                        <li class="page-item disabled">
                            <span class="page-link" style="border-radius:8px;">…</span>
                        </li>
                        @endif
                    @endif

                    @for($pg = $from; $pg <= $to; $pg++)
                    <li class="page-item {{ $pg == $current ? 'active' : '' }}">
                        <a class="page-link" href="{{ $predictions->url($pg) }}" style="border-radius:8px;">{{ $pg }}</a>
                    </li>
                    @endfor

                    @if($to < $last)
                        @if($to < $last - 1)
                        <li class="page-item disabled">
                            <span class="page-link" style="border-radius:8px;">…</span>
                        </li>
                        @endif
                        <li class="page-item">
                            <a class="page-link" href="{{ $predictions->url($last) }}" style="border-radius:8px;">{{ $last }}</a>
                        </li>
                    @endif

                    <li class="page-item {{ !$predictions->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link"
                           href="{{ $predictions->hasMorePages() ? $predictions->nextPageUrl() : '#' }}"
                           style="border-radius:8px;">
                            Next <i class="bi bi-chevron-right" style="font-size:11px;"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        @endif

        @endif
    </div>
</div>

<!-- UNIVERSAL DELETE MODAL -->
<div id="modalOverlay"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:9999;align-items:center;justify-content:center">
    <div style="background:#161b22;border:1px solid #30363d;border-radius:16px;padding:32px;max-width:380px;width:90%;text-align:center;box-shadow:0 24px 64px rgba(0,0,0,0.5)">
        <div style="font-size:44px;margin-bottom:16px">🗑️</div>
        <div id="modalTitle" style="font-size:17px;font-weight:700;color:#e6edf3;margin-bottom:8px">
            Konfirmasi Penghapusan
        </div>
        <div id="modalText" style="font-size:13px;color:#8b949e;margin-bottom:28px;line-height:1.6">
            Data akan dihapus permanen.<br>
            Tindakan ini <strong style="color:#f85149">tidak dapat dibatalkan</strong>.
        </div>
        <form id="modalDeleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="d-flex gap-2 justify-content-center">
                <button type="button" onclick="tutupModal()"
                        style="padding:9px 24px;background:#21262d;border:1px solid #30363d;border-radius:8px;color:#8b949e;font-size:13px;font-weight:600;cursor:pointer">
                    Batal
                </button>
                <button type="submit"
                        style="padding:9px 24px;background:rgba(248,81,73,0.15);border:1px solid rgba(248,81,73,0.4);border-radius:8px;color:#f85149;font-size:13px;font-weight:600;cursor:pointer">
                    <i class="bi bi-trash3"></i> Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script>
/* ── Flatpickr Kalender ── */
flatpickr("#datePicker", {
    locale: "id",
    dateFormat: "d/m/Y",
    allowInput: false,
    disableMobile: true,
    onChange: function(selectedDates, dateStr) {
        if (selectedDates.length > 0) {
            const d = selectedDates[0];
            const y = d.getFullYear();
            const m = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            document.getElementById('dateValue').value = `${y}-${m}-${day}`;
            document.querySelector('input[name="date"]').value = `${y}-${m}-${day}`;
        }
    },
    onReady: function(selectedDates, dateStr, instance) {
        instance.calendarContainer.style.zIndex = '99999';
    }
});

/* ── Pastikan form mengirim format Y-m-d ── */
document.querySelector('form').addEventListener('submit', function() {
    const raw = document.getElementById('dateValue').value;
    document.getElementById('datePicker').name = '';
    if (raw) {
        const hiddenInput = document.createElement('input');
        hiddenInput.type  = 'hidden';
        hiddenInput.name  = 'date';
        hiddenInput.value = raw;
        this.appendChild(hiddenInput);
    }
});

/* ── Modal ── */
function bukaModal(actionUrl, isDeleteAll = false) {
    const modal = document.getElementById('modalOverlay');
    const form  = document.getElementById('modalDeleteForm');
    const title = document.getElementById('modalTitle');
    const text  = document.getElementById('modalText');

    form.action = actionUrl;

    if (isDeleteAll) {
        title.innerText = "Hapus Semua Riwayat?";
        text.innerHTML  = "Semua data prediksi akan dihapus permanen.<br><strong style='color:#f85149'>Tidak dapat dibatalkan</strong>.";
    } else {
        title.innerText = "Hapus Riwayat Ini?";
        text.innerHTML  = "Data riwayat ini akan dihapus permanen.<br><strong style='color:#f85149'>Tidak dapat dibatalkan</strong>.";
    }

    modal.style.display = 'flex';
}

function tutupModal() {
    document.getElementById('modalOverlay').style.display = 'none';
}

document.getElementById('modalOverlay').addEventListener('click', function(e) {
    if (e.target === this) tutupModal();
});
</script>
@endpush

@endsection