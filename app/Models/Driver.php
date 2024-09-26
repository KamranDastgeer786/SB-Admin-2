<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'drivers';

    // Specify the primary key for the table
    protected $primaryKey = 'id';

    // Indicate if the IDs are auto-incrementing
    public $incrementing = true;

    // Define the data type of the primary key
    protected $keyType = 'int';

    // Specify if the model should be timestamped
    public $timestamps = true;

    // Define which attributes are mass assignable
    protected $fillable = [
        'name',
        'date_of_birth',
        'contact_number',
        'email',
        'license_number',
        'license_issuing_state',
        'license_expiry_date',
        'vehicle_make_model',
        'vehicle_registration_number',
        'insurance_details',
        'emergency_contact_name',
        'emergency_contact_number',
        'emergency_contact_relationship',
    ];

    // Define any casting for the attributes
    protected $casts = [
        'license_expiry_date' => 'datetime',
    ];

    // If you want to hide attributes from arrays or JSON responses
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
