<?php
namespace App\Http\Controllers;

use App\Models\HistoricalData;
use App\Models\MotorType;
use App\Models\Prediction;
use App\Services\ForecastingService;
use Illuminate\Http\Request;

class CalculationController extends Controller {
    public function __construct(protected ForecastingService $forecasting) {}

    public function index() {
        $motorTypes = MotorType::all();
        return view('calculation', compact('motorTypes'));
    }

    public function calculate(Request $request) {
        $request->validate([
            'motor_type_id' => 'required|exists:motor_types,id',
            'periods'       => 'required|integer|min:1',
        ]);

        $motorTypeId = (int) $request->motor_type_id;
        $periods     = (int) $request->periods;

        $rawData = HistoricalData::where('motor_type_id', $motorTypeId)
                     ->orderBy('periode')->pluck('value')->toArray();

        $dataCount = count($rawData);

        if ($dataCount < 3) {
            return back()->with('error', 'Data historis minimal 3 periode. Silakan upload data terlebih dahulu.');
        }

        // Logika warning akurasi
        $warning = null;
        if ($periods > $dataCount) {
            $warning = "Periode prediksi ({$periods} bulan) melebihi jumlah data historis ({$dataCount} bulan). Hasil prediksi kemungkinan kurang akurat.";
        } elseif ($periods > ($dataCount / 2)) {
            $warning = "Periode prediksi ({$periods} bulan) melebihi 50% dari data historis ({$dataCount} bulan). Disarankan prediksi maksimal " . floor($dataCount / 2) . " bulan untuk hasil yang lebih akurat.";
        }

        $ls  = $this->forecasting->leastSquare($rawData, $periods);
        $des = $this->forecasting->doubleExponentialSmoothing($rawData, $periods);
        $bestMethod = $ls['mape'] <= $des['mape'] ? 'Least Square' : 'Double Exponential Smoothing';

        $prediction = Prediction::create([
            'motor_type_id'    => $motorTypeId,
            'periods'          => $periods,
            'calculation_date' => now(),
            'historical_data'  => $rawData,
            'ls_predictions'   => $ls['predictions'],
            'ls_mad'           => $ls['mad'],
            'ls_mse'           => $ls['mse'],
            'ls_mape'          => $ls['mape'],
            'des_predictions'  => $des['predictions'],
            'des_mad'          => $des['mad'],
            'des_mse'          => $des['mse'],
            'des_mape'         => $des['mape'],
            'best_method'      => $bestMethod,
        ]);

        return redirect()->route('result.show', $prediction->id)
            ->with('warning', $warning);
    }
}