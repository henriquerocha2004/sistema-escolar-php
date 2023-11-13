<?php

namespace App\School\Secretary\Dto;

use App\School\Secretary\Collections\RoomCollection;

class RoomPaginatorResult
{
    public int $total;
    public RoomCollection $rooms;

    public function toArray(): array
    {
        return [
            'total' => $this->total,
            'rooms' => $this->rooms->toArray(),
        ];
    }
}
