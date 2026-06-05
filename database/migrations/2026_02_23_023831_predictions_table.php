<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motor_type_id')->constrained('motor_types')->onDelete('cascade');
            $table->integer('periods');
            $table->timestamp('calculation_date')->useCurrent();
            $table->json('historical_data');
            $table->json('ls_predictions');
            $table->decimal('ls_mad', 10, 4);
            $table->decimal('ls_mse', 10, 4);
            $table->decimal('ls_mape', 10, 4);
            $table->json('des_predictions');
            $table->decimal('des_mad', 10, 4);
            $table->decimal('des_mse', 10, 4);
            $table->decimal('des_mape', 10, 4);
            $table->string('best_method', 50);
        });
    }
    public function down(): void { Schema::dropIfExists('predictions'); }
};