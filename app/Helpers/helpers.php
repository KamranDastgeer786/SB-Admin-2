<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

function uploadFile($file, $folderName, $fileExistsIndicator)
{
    $year = date('Y');
    $month = date('m');

    $fileType = 'other';
    if (Str::startsWith($file->getMimeType(), 'image')) {
        $fileType = 'images';
    } elseif (Str::startsWith($file->getMimeType(), 'video')) {
        $fileType = 'videos';
    }

    if ($fileExistsIndicator) {
        $counter = 1;
        do {
            $newFolderName = $folderName . '-' . $counter;
            $directory = "uploads/{$year}/{$month}/{$fileType}/{$newFolderName}";
            $directoryExists = Storage::exists($directory);
            $counter++;
        } while ($directoryExists);

        $folderName = $newFolderName;
    }

    $fileName = $file->getClientOriginalName();
    $folderName = $folderName ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    $directory = "uploads/{$year}/{$month}/{$fileType}/{$folderName}";
    $path = $file->storeAs($directory, $fileName);
    return $path;
}

function deleteFiles($file)
{
    if (File::exists(public_path('storage/' . $file->url))) {
        $folderPath = dirname($file->url);
        File::deleteDirectory(public_path('storage/' . $folderPath));
    }
}

if(!function_exists('checkPermission')){

    function checkPermission($permissions, $operation)
    {
        foreach ($permissions as $permission) {
            if (strpos($permission->name, $operation) !== false) {
                return true;
            }
        }
        return false;
    }
}


