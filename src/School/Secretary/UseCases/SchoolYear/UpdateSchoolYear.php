<?php

namespace App\School\Secretary\UseCases\SchoolYear;

use App\School\Secretary\Dto\SchoolYearDto;
use App\School\Secretary\Entities\SchoolYear;
use App\School\Secretary\Repository\SchoolYearRepositoryInterface;

class UpdateSchoolYear
{
    public function __construct(
        private SchoolYearRepositoryInterface $schoolYearRepository
    ) {
    }

    public function execute(SchoolYearDto $dto, string $id): void
    {
        $schoolYear = SchoolYear::Create($dto->year, $dto->startAt, $dto->endAt);
        $schoolYear->checkPeriod();
        $schoolYear->setId($id);

        $this->schoolYearRepository->update($schoolYear);
    }
}
