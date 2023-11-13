<?php

namespace App\School\Secretary\UseCases\SchoolYear;

use App\Requests\SchoolYearRequest;
use App\School\Secretary\Dto\SchoolYearDto;
use App\School\Secretary\Entities\SchoolYear;
use App\School\Secretary\Exeptions\SchoolYearException;
use App\School\Secretary\Repository\SchoolYearRepositoryInterface;

class CreateSchoolYear
{
    public function __construct(
        private SchoolYearRepositoryInterface $schoolYearRepository
    ) {
    }

    public function execute(SchoolYearDto $dto): void
    {
        if ($this->schoolYearAlreadyExists($dto->year)) {
            throw new SchoolYearException("the school year provided already exists");
        }

        $schoolYear = SchoolYear::Create($dto->year, $dto->startAt, $dto->endAt);
        $schoolYear->checkPeriod();

        $this->schoolYearRepository->create($schoolYear);
    }

    private function schoolYearAlreadyExists(string $year): bool
    {
        $schoolYear = $this->schoolYearRepository->findOneByYear($year);

        return !is_null($schoolYear);
    }
}
