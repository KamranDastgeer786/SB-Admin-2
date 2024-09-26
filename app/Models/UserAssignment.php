<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pp_assigned',
        'assignment_date',
    ];

    /**
     * This PPE assignment belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * This PPE assignment belongs to PPE equipment.
     */
    public function ppeEquipment()
{
    return $this->belongsTo(PpeEquipment::class, 'pp_assigned');
}
}
