<?php

namespace App\Enums;

enum Roles: string
{
    case ADMIN = "ADMIN";
    case DOCTOR = "DOCTOR";
    CASE PATIENT = "PATIENT";
}
