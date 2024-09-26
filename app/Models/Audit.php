<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;
    protected $fillable = [
        'action_type',
        'resource_affected',
        'previous_state',
        'new_state',
        'user_id',
        'user_role',
    ];
}
