<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('historical_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motor_type_id')->constrained('motor_types')->onDelete('cascade');
            $table->integer('periode');
            $table->integer('value');
            $table->timestamp('uploaded_at')->useCurrent();
        });
    }
    public function down(): void { Schema::dropIfExists('historical_data'); }
};