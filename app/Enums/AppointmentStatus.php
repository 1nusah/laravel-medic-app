<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case PENDING_ASSIGNMENT = 'PENDING_ASSIGNMENT';
    case SCHEDULED = "SCHEDULED";
    case ONGOING = "ONGOING";
    case CANCELLED = "CANCELLED";

    case COMPLETED = "COMPLETED";

}
