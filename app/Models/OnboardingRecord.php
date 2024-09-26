<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnboardingRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'ppe_training_completion_date',
        'ppe_fit_testing',
    ];

     // Relationship with User
     public function user()
     {
        return $this->belongsTo(User::class);
     }
}
