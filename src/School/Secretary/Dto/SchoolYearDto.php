<?php

namespace App\School\Secretary\Dto;

class SchoolYearDto
{
    public function __construct(
        public string $year,
        public string $startAt,
        public string $endAt
    ) {
    }
}
