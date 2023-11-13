<?php

namespace App\School\Secretary\Dto;

class RoomDto
{
    public function __construct(
        public int $capacity,
        public string $code,
        public string $description = '',
    ) {
    }
}
