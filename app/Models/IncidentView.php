<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncidentView extends Model
{
    use HasFactory;
    protected $table = 'incidents_view';

    protected $fillable = [
        'date_time',
        'status',
        'assigned_reviewer'
    ];

    protected $casts = [
        'date_time' => 'datetime',
    ];

    /**
     * Get the assigned reviewer for the incident.
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'assigned_reviewer');
    }

    /**
     * Get the follow-up actions associated with this incident.
     */
    public function followUpActions()
    {
        return $this->hasMany(FollowUpAction::class, 'incident_view_id');
    }

    /**
     * Get the closure detail associated with this incident.
     */
    public function closureDetail()
    {
        return $this->hasOne(ClosureDetail::class, 'incident_view_id');
    }

}
