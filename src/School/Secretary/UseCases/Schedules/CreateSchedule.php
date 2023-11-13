<?php

namespace App\School\Secretary\UseCases\Schedules;

use App\School\Secretary\Dto\ScheduleDto;
use App\School\Secretary\Entities\ScheduleClass;
use App\School\Secretary\Exeptions\ScheduleException;
use App\School\Secretary\Repository\ScheduleRepositoryInterface;
use App\School\Secretary\Repository\SchoolYearRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class CreateSchedule
{
    public function __construct(
        private readonly ScheduleRepositoryInterface $scheduleRepository,
        private readonly SchoolYearRepositoryInterface $schoolYearRepository
    ) {
    }

    public function execute(ScheduleDto $dto): void
    {
        $schoolYear = $this->schoolYearRepository->findOneById(Uuid::fromString($dto->schoolYearId));
        if (is_null($schoolYear)) {
            throw new ScheduleException("schoolYear not found.");
        }

        $schedule = ScheduleClass::create(
            $dto->description,
            $dto->startTime,
            $dto->endTime,
            $dto->schoolYearId
        );

        $this->scheduleRepository->create($schedule);
    }
}
