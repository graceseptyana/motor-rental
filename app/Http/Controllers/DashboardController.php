<?php
namespace App\Http\Controllers;

use App\Models\MotorType;
use App\Models\HistoricalData;
use App\Models\Prediction;

class DashboardController extends Controller {
    public function index() {
        $motorTypes        = MotorType::all();
        $totalPredictions  = Prediction::count();
        $totalData         = HistoricalData::count();
        $latestPrediction  = Prediction::with('motorType')->latest('calculation_date')->first();
        $latestPredictions = Prediction::with('motorType')->latest('calculation_date')->take(5)->get();

        return view('dashboard', compact(
            'motorTypes',
            'totalPredictions',
            'totalData',
            'latestPrediction',
            'latestPredictions'
        ));
    }
}