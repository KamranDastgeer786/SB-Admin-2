<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClosureDetail extends Model
{
    use HasFactory;

    // Define the fillable fields
    protected $fillable = [
        'incident_view_id',
        'closing_date',
        'final_report',
        'resolution_summary',
    ];

    /**
    * Get the incident view associated with this closure detail.
    */
    public function incidentView()
    {
        return $this->belongsTo(IncidentView::class, 'incident_view_id');
    }
}
