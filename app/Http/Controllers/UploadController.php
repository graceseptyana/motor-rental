<?php

namespace App\Http\Controllers;

use App\Imports\HistoricalDataImport;
use App\Models\HistoricalData;
use App\Models\MotorType;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{
    public function index()
    {
        $motorTypes = MotorType::all();

        $existingData = HistoricalData::with('motorType')
            ->orderBy('motor_type_id')
            ->orderBy('periode')
            ->get()
            ->groupBy('motor_type_id');

        return view('upload', compact('motorTypes', 'existingData'));
    }

    public function reupload()
    {
        return redirect()->route('upload.index')->with('show_form', true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:2048',
        ]);

        try {
            Excel::import(new HistoricalDataImport(), $request->file('file'));

            $count = HistoricalData::count();

            if ($count === 0) {
                return back()->with('error',
                    'File terbaca tapi tidak ada data tersimpan. Pastikan header kolom: periode | small | auto | big'
                );
            }

            return redirect()->route('upload.index')
                ->with('success', "Data berhasil diupload! {$count} record tersimpan.");

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    // ✅ Hapus per motor type
    public function destroy(int $motorTypeId)
    {
        HistoricalData::where('motor_type_id', $motorTypeId)->delete();

        return back()->with('success', 'Data historis berhasil dihapus.');
    }

    // ✅ Hapus semua data
    public function destroyAll()
    {
        HistoricalData::truncate();

        return back()->with('success', 'Semua data historis berhasil dihapus.');
    }
}