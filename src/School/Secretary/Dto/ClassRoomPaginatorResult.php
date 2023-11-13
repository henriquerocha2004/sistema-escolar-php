<?php

namespace App\School\Secretary\Dto;

use App\School\Secretary\Collections\ClassRoomCollection;

class ClassRoomPaginatorResult
{
    public int $total;
    public ClassRoomCollection $classRooms;

    public function toArray(): array
    {
        return [
            'total' => $this->total,
            'classRooms' => $this->classRooms->toArray(),
        ];
    }
}
