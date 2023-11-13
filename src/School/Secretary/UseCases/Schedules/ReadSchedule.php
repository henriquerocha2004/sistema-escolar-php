<?php

namespace App\School\Secretary\UseCases\Schedules;

use App\School\DomainService\Paginator;
use App\School\Secretary\Dto\PaginatorRequestDto;
use App\School\Secretary\Dto\SchedulePaginatorResult;
use App\School\Secretary\Entities\ScheduleClass;
use App\School\Secretary\Repository\ScheduleRepositoryInterface;
use App\School\Secretary\Repository\SchoolYearRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class ReadSchedule
{
    public function __construct(
        private readonly ScheduleRepositoryInterface $scheduleRepository,
        private readonly SchoolYearRepositoryInterface $schoolYearRepository
    ) {
    }

    public function findOneById(string $id): ?ScheduleClass
    {
        $uuid = Uuid::fromString($id);
        return $this->scheduleRepository->findOneById($uuid);
    }

    public function findBy(PaginatorRequestDto $dto): SchedulePaginatorResult
    {
        $paginator = Paginator::create($dto);

        return $this->scheduleRepository->findBy($paginator);
    }
}
