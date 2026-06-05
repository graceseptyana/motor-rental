<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoricalData extends Model {
    public $timestamps = false;
    protected $fillable = ['motor_type_id', 'periode', 'value', 'uploaded_at'];
    protected $casts = ['uploaded_at' => 'datetime'];

    public function motorType(): BelongsTo {
        return $this->belongsTo(MotorType::class);
    }
}