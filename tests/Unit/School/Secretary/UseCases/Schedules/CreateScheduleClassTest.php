<?php

namespace App\Tests\Unit\School\Secretary\UseCases\Schedules;

use App\Repository\Secretary\SchoolYearRepository;
use App\School\Secretary\Dto\ScheduleDto;
use App\School\Secretary\Entities\SchoolYear;
use App\School\Secretary\Exeptions\ScheduleException;
use App\School\Secretary\Repository\ScheduleRepositoryInterface;
use App\School\Secretary\UseCases\Schedules\CreateSchedule;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class CreateScheduleClassTest extends TestCase
{
    public function testShouldCreateScheduleWithSuccess(): void
    {
        $schoolYear = $this->getSchoolYear();

        $schoolYearRepository = $this->createMock(SchoolYearRepository::class);
        $schoolYearRepository->expects($this->once())
            ->method('findOneById')
            ->willReturn($schoolYear);

        $scheduleRepository = $this->createMock(ScheduleRepositoryInterface::class);
        $scheduleRepository->expects($this->once())
            ->method('create');

        $createSchedule = new CreateSchedule($scheduleRepository, $schoolYearRepository);

        $dto = new ScheduleDto();
        $dto->description = 'any description';
        $dto->startTime = '08:00:00';
        $dto->endTime = '09:00:00';
        $dto->schoolYearId = $schoolYear->getId()->__toString();

        $createSchedule->execute($dto);
    }

    public function testShouldReturnErrorIfSchoolYearIdNotFound(): void
    {
        $this->expectException(ScheduleException::class);
        $this->expectExceptionMessage('schoolYear not found');

        $schoolYearRepository = $this->createMock(SchoolYearRepository::class);
        $schoolYearRepository->expects($this->once())
            ->method('findOneById')
            ->willReturn(null);

        $scheduleRepository = $this->createMock(ScheduleRepositoryInterface::class);
        $scheduleRepository->expects($this->never())
            ->method('create');

        $createSchedule = new CreateSchedule($scheduleRepository, $schoolYearRepository);

        $dto = new ScheduleDto();
        $dto->description = 'any description';
        $dto->startTime = '08:00:00';
        $dto->endTime = '09:00:00';
        $dto->schoolYearId = Uuid::v4()->__toString();

        $createSchedule->execute($dto);
    }

    private function getSchoolYear(): SchoolYear
    {
        return SchoolYear::Create('2023', '2023-01-01', '2023-12-01');
    }
}
