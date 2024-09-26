<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUpAction extends Model
{
    use HasFactory;

    // Define which fields can be mass-assigned
    protected $fillable = [
        'incident_view_id',
        'follow_up_date',
        'assigned_user',
        'notes',
    ];

    /**
     * Get the user assigned to this follow-up action.
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user');
    }

    /**
     * Get the incident view associated with this follow-up action.
     */
    public function incidentView()
    {
        return $this->belongsTo(IncidentView::class, 'incident_view_id');
    }
}
