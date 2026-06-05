<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class ForecastingService {

    private string $apiUrl = 'http://127.0.0.1:5000/predict';

    public function leastSquare(array $data, int $futureperiods): array {
        $result = $this->callPythonApi($data, $futureperiods);
        return $result['ls'];
    }

    public function doubleExponentialSmoothing(array $data, int $futureperiods, float $alpha = 0.3): array {
        $result = $this->callPythonApi($data, $futureperiods);
        return $result['des'];
    }

    private function callPythonApi(array $data, int $periods): array {
        $response = Http::post($this->apiUrl, [
            'data'    => $data,
            'periods' => $periods,
        ]);

        return $response->json();
    }

    public function calculateAccuracy(array $actual, array $forecast): array {
        $n = count($actual);
        $sumAbs = $sumSq = $sumPct = 0;
        $validN = 0;

        for ($i = 0; $i < $n; $i++) {
            $error   = $actual[$i] - $forecast[$i];
            $sumAbs += abs($error);
            $sumSq  += $error ** 2;
            if ($actual[$i] != 0) {
                $sumPct += abs($error / $actual[$i]);
                $validN++;
            }
        }

        return [
            'mad'  => round($sumAbs / $n, 4),
            'mse'  => round($sumSq  / $n, 4),
            'mape' => $validN > 0 ? round(($sumPct / $validN) * 100, 4) : 0,
        ];
    }
}