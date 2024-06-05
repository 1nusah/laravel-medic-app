<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diagnosis extends Model
{
    use HasFactory, HasUuids, SoftDeletes;


    protected $keyType = 'string';

    /**
     * fillable col
     */
    protected $fillable = [
        'symptoms',
        'prescription',
        'notes',
        'appointment_id'
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'id');
    }

    public function labtests(): HasMany
    {
        return $this->hasMany(LabTest::class,'diagnosis_id','id');
    }


}
