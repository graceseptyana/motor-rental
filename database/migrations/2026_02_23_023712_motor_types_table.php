<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('motor_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->integer('total_units');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('motor_types'); }
};