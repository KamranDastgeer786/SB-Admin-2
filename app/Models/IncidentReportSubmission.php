<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class IncidentReportSubmission extends Model
{
    use HasFactory;
    protected $fillable = [
        // Incident Details
        'incident_date_time',
        'location',
        'description',
        // Involved Parties
        'names_individuals_involved',
        'roles_in_incident',
        'contact_information',
        // Attachments
        'attachments',
        'witness_statements',
        // Submission Details
        'submitted_by',
        'submission_date',
        'status',
    ];

    protected $casts = [
        'incident_date_time' => 'datetime',
        'submission_date' => 'date',
    ];

    /**
    * Get the user that submitted the incident report.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }
}
