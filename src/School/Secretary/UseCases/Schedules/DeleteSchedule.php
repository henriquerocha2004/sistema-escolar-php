<?php

namespace App\School\Secretary\UseCases\Schedules;

use App\School\Secretary\Repository\ScheduleRepositoryInterface;
use App\School\Secretary\Repository\SchoolYearRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class DeleteSchedule
{
    public function __construct(
        private readonly ScheduleRepositoryInterface $scheduleRepository,
    ) {
    }

    public function execute(string $id): void
    {
        $uuid = Uuid::fromString($id);
        $this->scheduleRepository->delete($uuid);
    }
}
