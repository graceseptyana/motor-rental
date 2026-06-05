<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use App\Models\MotorType;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $motorTypes = MotorType::all();

        $query = Prediction::with('motorType')
            ->orderByDesc('calculation_date');

        if ($request->filled('motor_type_id')) {
            $query->where('motor_type_id', $request->motor_type_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('calculation_date', $request->date);
        }

        $predictions = $query->paginate(10)->withQueryString();

        return view('history', compact('predictions', 'motorTypes'));
    }

    public function destroy(int $id)
    {
        Prediction::findOrFail($id)->delete();

        return back()->with('success', 'Riwayat berhasil dihapus.');
    }

    // ✅ TAMBAHKAN METHOD INI
    public function destroyAll()
    {
        Prediction::query()->delete(); 
        // kalau mau reset auto increment pakai: Prediction::truncate();

        return back()->with('success', 'Semua riwayat berhasil dihapus.');
    }
}   