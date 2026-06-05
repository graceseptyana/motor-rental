<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prediction extends Model {
    public $timestamps = false;
    protected $fillable = [
        'motor_type_id','periods','calculation_date','historical_data',
        'ls_predictions','ls_mad','ls_mse','ls_mape',
        'des_predictions','des_mad','des_mse','des_mape','best_method',
    ];
    protected $casts = [
        'historical_data'  => 'array',
        'ls_predictions'   => 'array',
        'des_predictions'  => 'array',
        'calculation_date' => 'datetime',
    ];
    public function motorType(): BelongsTo {
        return $this->belongsTo(MotorType::class);
    }
}