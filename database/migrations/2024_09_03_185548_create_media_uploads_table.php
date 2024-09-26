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
        Schema::create('media_uploads', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('file_name'); // Store the name of the file
            $table->string('file_type'); // Store the type of the file (image, video, document)
            $table->bigInteger('file_size'); // Store the size of the file in bytes
            $table->timestamp('upload_date')->useCurrent();
            $table->timestamps(); // Include created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_uploads');
    }
};
