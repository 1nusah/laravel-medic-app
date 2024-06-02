<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diagnoses extends Model
{
    use HasFactory, HasUuids, SoftDeletes;


    protected $keyType = 'string';

    /**
     * fillable col
     */
    protected $fillable = [
        'symptoms',
        'tests',
        'prescription',
        'notes'
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }


}
