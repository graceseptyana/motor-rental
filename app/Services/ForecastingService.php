<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ForecastingService {

    private string $apiUrl;

    public function __construct() {
        $this->apiUrl = env('FLASK_API_URL', 'http://127.0.0.1:5000/predict');
    }

    public function leastSquare(array $data, int $futureperiods): array {
        $result = $this->callPythonApi($data, $futureperiods);
        return $result['ls'];
    }

    public function doubleExponentialSmoothing(array $data, int $futureperiods, float $alpha = 0.3): array {
        $result = $this->callPythonApi($data, $futureperiods);
        return $result['des'];
    }

    private function callPythonApi(array $data, int $periods): array {
        try {
            $response = Http::timeout(30)
                ->retry(3, 1000)
                ->post($this->apiUrl, [
                    'data'    => $data,
                    'periods' => $periods,
                ]);

            if (!$response->successful()) {
                Log::error('Python API HTTP error: ' . $response->status() . ' - ' . $response->body());
                throw new \Exception('Python API tidak dapat diakses. Status: ' . $response->status());
            }

            $result = $response->json();

            if (!$result || !isset($result['ls']) || !isset($result['des'])) {
                Log::error('Python API response tidak valid: ' . $response->body());
                throw new \Exception('Respons Python API tidak valid.');
            }

            return $result;

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Python API connection error: ' . $e->getMessage());
            throw new \Exception('Tidak dapat terhubung ke Python API. Pastikan Flask server berjalan.');
        } catch (\Exception $e) {
            Log::error('Python API error: ' . $e->getMessage());
            throw $e;
        }
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