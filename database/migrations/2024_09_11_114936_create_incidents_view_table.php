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
        Schema::create('incidents_view', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date_time')->nullable(); // Date and Time
            $table->enum('status', ['Pending', 'Reviewed', 'Closed'])->default('Pending'); // Status
            $table->foreignId('assigned_reviewer')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents_view');
    }
};
