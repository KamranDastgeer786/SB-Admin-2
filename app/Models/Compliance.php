<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compliance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'training_completion',
        'inspection_logs',
        'fit_testing',
    ];

    /**
    * Compliance belongs to a user.
    */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
