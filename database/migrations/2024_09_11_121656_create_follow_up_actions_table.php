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
        Schema::create('follow_up_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incident_view_id')->constrained('incidents_view')->onDelete('cascade');
            $table->date('follow_up_date')->nullable(); // Follow-up Date
            $table->foreignId('assigned_user')->constrained('users')->onDelete('cascade');
            $table->text('notes')->nullable(); // Notes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_up_actions');
    }
};
