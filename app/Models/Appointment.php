<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, HasUuids, SoftDeletes;


    protected $keyType = 'string';

    /**
     * fillable columns
     * @var string[]
     */
    protected $fillable = [
        'name',
        'doctor_id',
        'patient_id',
        'appointment_date',
    ];

    /**
     * model default values
     */

    protected $attributes = [
        'status' => AppointmentStatus::SCHEDULED
    ];

    public function patient(): BelongsTo
    {

        return $this->belongsTo(User::class, 'patient_id', 'id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

    public function diagnoses(): HasMany
    {
        return $this->hasMany(Diagnosis::class, 'appointment_id', 'id');
    }

}
