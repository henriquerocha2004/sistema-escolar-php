<?php

namespace App\School\Secretary\Dto;

use App\School\Secretary\Collections\SchoolYearCollection;

class SchoolYearPaginationResult
{
    public int $total;
    public SchoolYearCollection $schoolYear;

    public function toArray(): array
    {
        return [
            'total' => $this->total,
            'school_years' => $this->schoolYear->toArray(),
        ];
    }
}
