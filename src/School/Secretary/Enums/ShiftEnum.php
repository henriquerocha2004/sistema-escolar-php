<?php

namespace App\School\Secretary\Enums;

enum ShiftEnum: string
{
    case MORNING = 'morning';
    case AFTERNOON = 'afternoon';
    case NOCTURNAL = 'nocturnal';
    case FULL_TIME = 'full_time';
}
