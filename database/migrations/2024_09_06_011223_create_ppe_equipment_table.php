<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ppe_equipment', function (Blueprint $table) {
            $table->id();
            $table->string('equipment_name');
            $table->string('equipment_type');
            $table->string('serial_number')->unique();
            $table->date('date_of_purchase');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppe_equipment');
    }
};
