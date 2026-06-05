<?php
namespace App\Imports;

use App\Models\HistoricalData;
use App\Models\MotorType;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class HistoricalDataImport implements ToCollection, WithHeadingRow {

    public function collection(Collection $rows): void {
        // Ambil semua motor type sekali query
        $motorTypes = MotorType::all()->keyBy(fn($mt) => strtolower($mt->name));
        // Kolom yang mungkin ada di Excel: small, auto, big
        $columns = ['small', 'auto', 'big'];

        // Hapus data lama untuk motor type yang ada di file ini
        foreach ($columns as $col) {
            if ($motorTypes->has($col) && $rows->first() && isset($rows->first()[$col])) {
                HistoricalData::where('motor_type_id', $motorTypes[$col]->id)->delete();
            }
        }

        foreach ($rows as $row) {
            $periode = $row['periode'] ?? $row['period'] ?? null;
            if ($periode === null) continue;

            foreach ($columns as $col) {
                $value = $row[$col] ?? null;
                if ($value === null || !$motorTypes->has($col)) continue;

                HistoricalData::create([
                    'motor_type_id' => $motorTypes[$col]->id,
                    'periode'       => (int) $periode,
                    'value'         => (int) $value,
                    'uploaded_at'   => now(),
                ]);
            }
        }
    }
}