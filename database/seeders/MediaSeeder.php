<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MediaUpload;
use Illuminate\Support\Facades\Storage;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create dummy media records
        $mediaRecords = [
            [
                'file_name' => 'example1.png',
                'file_type' => 'png',
                'file_size' => 204800, // Example size in bytes
                'upload_date' => now(),
                // 'file_path' => 'storage/uploads/example1.png',
            ],
            [
                'file_name' => 'document.pdf',
                'file_type' => 'pdf',
                'file_size' => 102400, // Example size in bytes
                'upload_date' => now(),
                // 'file_path' => 'storage/uploads/document.pdf',
            ],
            [
                'file_name' => 'example_video.mp4',
                'file_type' => 'mp4',
                'file_size' => 5242880, // Example size in bytes
                'upload_date' => now(),
                // 'file_path' => 'storage/uploads/example_video.mp4',
            ],
        ];

        foreach ($mediaRecords as $media) {
            MediaUpload::create($media);
        }
    }
}
