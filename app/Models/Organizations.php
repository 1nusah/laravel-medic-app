<?php

namespace App\Models;

 use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
 use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



class Organizations extends Model
{
    use HasFactory, Notifiable,HasApiTokens, HasUuids,SoftDeletes;


        /***
     * @var string
     */
    protected $keyType ='string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'ghanaPostAddress',
        'phoneNumber'
    ];

/**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }
}
