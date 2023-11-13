<?php

namespace App\School\Secretary\Dto;

use App\School\Secretary\Collections\ScheduleCollection;

class SchedulePaginatorResult
{
    public int $total;
    public ScheduleCollection $schedules;

    public function toArray(): array
    {
        return [
            'total' => $this->total,
            'rooms' => $this->schedules->toArray(),
        ];
    }
}
