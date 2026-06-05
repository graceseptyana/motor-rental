<?php
namespace App\Http\Controllers;

use App\Models\Prediction;
use Barryvdh\DomPDF\Facade\Pdf;

class ResultController extends Controller {
    public function show(int $id) {
        $prediction = Prediction::with('motorType')->findOrFail($id);
        return view('result', compact('prediction'));
    }

    public function exportPdf(int $id) {
        $prediction = Prediction::with('motorType')->findOrFail($id);
        $pdf = Pdf::loadView('pdf.result', compact('prediction'))->setPaper('a4', 'portrait');
        $filename = 'prediksi-' . strtolower($prediction->motorType->name)
                    . '-' . $prediction->calculation_date->format('Ymd-His') . '.pdf';
        return $pdf->download($filename);
    }
}