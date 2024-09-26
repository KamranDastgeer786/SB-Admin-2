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
        Schema::create('closure_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incident_view_id')->constrained('incidents_view')->onDelete('cascade');
            $table->date('closing_date')->nullable(); // Closing Date
            $table->text('final_report')->nullable(); // Final Report
            $table->text('resolution_summary')->nullable(); // Resolution Summary
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('closure_details');
    }
};
