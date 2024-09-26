<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'ppe_equipment_id',
        'assigned_to',
        'date_of_assignment',
        'ppe_condition',
        'maintenance_due_date',
    ];

     /**
     * Relationship with PPEEquipment.
     */
    public function ppeEquipment()
    {
        return $this->belongsTo(PpeEquipment::class);
    }

    /**
     * Relationship with User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
