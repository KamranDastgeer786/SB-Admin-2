<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpeEquipment extends Model
{
    use HasFactory;
    protected $fillable = [
        'equipment_name',
        'equipment_type',
        'serial_number',
        'date_of_purchase',
    ];

    

    // If there is a relationship with AssignmentRecord, you can define it here
    public function assignmentRecords()
    {
        return $this->hasMany(AssignmentRecord::class);
    }

    /**
     * A piece of PPE equipment can have many user assignments.
     */
    public function userAssignments()
    {
        return $this->hasMany(UserAssignment::class, 'ppe_assigned');
    }
}
