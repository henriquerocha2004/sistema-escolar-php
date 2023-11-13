<?php

namespace App\Tests\Unit\School\Secretary\UseCases\Schedules;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use App\School\Secretary\Dto\ScheduleDto;
use App\School\Secretary\Entities\SchoolYear;
use App\Repository\Secretary\SchoolYearRepository;
use App\School\Secretary\UseCases\Schedules\UpdateSchedule;
use App\School\Secretary\Repository\ScheduleRepositoryInterface;

class UpdateScheduleClassTest extends TestCase
{
    public function testShouldUpdateScheduleWithSuccess(): void
    {
        $repository = $this->createMock(ScheduleRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('update');
        $schoolYearRepository = $this->createMock(SchoolYearRepository::class);
        $schoolYearRepository->expects($this->once())
            ->method('findOneById')
            ->willReturn($this->getSchoolYear());

        $updateSchedule = new UpdateSchedule($repository, $schoolYearRepository);
        $dto = new ScheduleDto();
        $dto->description = 'any description';
        $dto->startTime = '08:00:00';
        $dto->endTime = '09:00:00';
        $dto->schoolYearId = Uuid::v4()->__toString();
        $updateSchedule->execute($dto, Uuid::v4()->__toString());
    }

    private function getSchoolYear(): SchoolYear
    {
        return SchoolYear::Create('2023', '2023-01-01', '2023-12-01');
    }
}
