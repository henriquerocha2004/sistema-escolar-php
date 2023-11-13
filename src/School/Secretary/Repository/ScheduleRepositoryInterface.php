<?php

namespace App\School\Secretary\Repository;

use App\School\DomainService\Paginator;
use App\School\Secretary\Dto\SchedulePaginatorResult;
use App\School\Secretary\Entities\ScheduleClass;
use Symfony\Component\Uid\Uuid;

interface ScheduleRepositoryInterface
{
    public function create(ScheduleClass $scheduleClass): void;
    public function update(ScheduleClass $scheduleClass): void;
    public function delete(Uuid $scheduleId): void;
    public function findOneById(Uuid $scheduleId): ScheduleClass|null;
    public function findBy(Paginator $paginator): SchedulePaginatorResult;
}
