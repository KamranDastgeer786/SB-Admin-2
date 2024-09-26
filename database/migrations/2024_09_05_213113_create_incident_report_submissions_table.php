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
        Schema::create('incident_report_submissions', function (Blueprint $table) {
            $table->id();
            // Incident Details
            $table->dateTime('incident_date_time');
            $table->string('location', 255);
            $table->text('description');
            // Involved Parties
            $table->text('names_individuals_involved');
            $table->string('roles_in_incident');
            $table->string('contact_information');
            // Attachments
            $table->string('attachments')->nullable();
            $table->text('witness_statements')->nullable();
            // Submission Details
            $table->foreignId('submitted_by')->constrained('users')->onDelete('cascade');
            $table->date('submission_date');
            $table->enum('status', ['Pending', 'Reviewed', 'Closed'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_report_submissions');
    }
};
