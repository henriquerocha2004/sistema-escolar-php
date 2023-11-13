<?php

namespace App\School\Secretary\UseCases\SchoolYear;

use App\School\Secretary\Repository\SchoolYearRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class DeleteSchoolYear
{
    public function __construct(
        private SchoolYearRepositoryInterface $schoolYearRepository
    ) {
    }

    public function execute(string $id): void
    {
        $uuid = Uuid::fromString($id);
        $this->schoolYearRepository->delete($uuid);
    }
}
