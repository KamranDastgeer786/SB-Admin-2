<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'provider',
        'provider_id',
        'password',
        'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // public function currentRole(): BelongsTo
    // {
    // return $this->belongsTo(Role::class, 'current_role_id');
    // }
    
    public function notificationPreferences(): HasMany
    {
        return $this->hasMany(NotificationPreference::class);
    }

    // Define the relationship with the IncidentReportSubmission model
    public function incidentReports(): HasMany
    {
        return $this->hasMany(IncidentReportSubmission::class, 'submitted_by');
    }

    // Relationship with AssignmentRecord
    public function assignmentRecords()
    {
        return $this->hasMany(AssignmentRecord::class, 'assigned_to');
    }

    // Relationship with Onboarding
    public function OnboardingRecord()
    {
        return $this->hasOne(OnboardingRecord::class);
    }


     // If you want to get the PPE Inventory associated with this user through Assignment Records
    public function PpeEquipment()
    {
        return $this->hasManyThrough(
            PpeEquipment::class,
            AssignmentRecord::class,
            'assigned_to', // Foreign key on AssignmentRecord
            'id',          // Foreign key on PPEInventory
            'id',          // Local key on User
            'ppe_equipment_id' // Local key on AssignmentRecord
        );
    }

    /**
    * A user can have many PPE assignments.
    */
    public function userAssignments()
    {
        return $this->hasMany(UserAssignment::class);
    }

    /**
     * A user can have many compliance records.
     */
    public function compliances()
    {
        return $this->hasMany(Compliance::class);
    }
   

}
