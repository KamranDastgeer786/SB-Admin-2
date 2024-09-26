<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaUpload extends Model
{
    use HasFactory;
    protected $table = 'media_uploads';
    protected $casts = [
        'upload_date' => 'datetime',
    ];
    protected $fillable = [
        'file_name',
        'file_type',
        'file_size',
        'upload_date',
    ];
}
