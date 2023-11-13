<?php

namespace App\School\Secretary\Enums;

enum ClassRoomStatusEnum: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case CANCELLED = 'cancelled';
}
