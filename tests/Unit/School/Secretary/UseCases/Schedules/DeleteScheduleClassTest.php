<?php

namespace App\Tests\Unit\School\Secretary\UseCases\Schedules;

use App\Repository\Secretary\SchoolYearRepository;
use App\School\Secretary\Entities\SchoolYear;
use App\School\Secretary\Repository\ScheduleRepositoryInterface;
use App\School\Secretary\UseCases\Schedules\DeleteSchedule;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class DeleteScheduleClassTest extends TestCase
{
    public function testShouldDeleteScheduleWithSuccess(): void
    {
        $repository = $this->createMock(ScheduleRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('delete');

        $deleteSchedule = new DeleteSchedule($repository);
        $deleteSchedule->execute(Uuid::v4()->__toString());
    }

    private function getSchoolYear(): SchoolYear
    {
        return SchoolYear::Create('2023', '2023-01-01', '2023-12-01');
    }
}
