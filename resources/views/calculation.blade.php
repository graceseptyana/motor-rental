@extends('layouts.app')
@section('title','Perhitungan')
@section('page-title','Hitung Prediksi')
@section('breadcrumb','rental / perhitungan')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header"><h5 class="card-title"><i class="bi bi-calculator me-2" style="color:var(--accent-blue)"></i>Parameter Prediksi</h5></div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger mb-3"><i class="bi bi-exclamation-circle-fill"></i> {{ $errors->first() }}</div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger mb-3"><i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('calculation.calculate') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Jenis Motor</label>
                        <select name="motor_type_id" class="form-select @error('motor_type_id') is-invalid @enderror" required>
                            <option value="">— Pilih jenis motor —</option>
                            @foreach($motorTypes as $mt)
                            @php $count=\App\Models\HistoricalData::where('motor_type_id',$mt->id)->count(); @endphp
                            <option value="{{ $mt->id }}" {{ old('motor_type_id')==$mt->id?'selected':'' }}>{{ $mt->name }}</option>
                            @endforeach
                        </select>
                        @error('motor_type_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Jumlah Periode Prediksi</label>
                        <input type="number" name="periods" class="form-control @error('periods') is-invalid @enderror"
                            placeholder="Contoh: 3" value="{{ old('periods') }}" min="1" required>
                        @error('periods')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100" style="padding:13px">
                        <i class="bi bi-cpu"></i> Hitung Prediksi Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection