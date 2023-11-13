<?php

namespace App\School\Secretary\UseCases\SchoolYear;

use App\School\Secretary\Dto\SchoolYearPaginationResult;
use App\School\Secretary\Entities\SchoolYear;
use App\School\Secretary\Repository\SchoolYearRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class ReadSchoolYear
{
    public function __construct(
        private SchoolYearRepositoryInterface $schoolYearRepository
    ) {
    }


    public function byId(string $id): ?SchoolYear
    {
        $uuid = Uuid::fromString($id);

        return $this->schoolYearRepository->findOneById($uuid);
    }

    public function findAll(): SchoolYearPaginationResult
    {
        return $this->schoolYearRepository->findAll();
    }
}
