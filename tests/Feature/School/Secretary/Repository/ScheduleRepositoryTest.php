<?php

namespace App\Tests\Feature\School\Secretary\Repository;

use App\Repository\Secretary\ScheduleRepository;
use App\Repository\Secretary\SchoolYearRepository;
use App\School\Secretary\Entities\ScheduleClass;
use App\School\Secretary\Entities\SchoolYear;
use App\Tests\Feature\BaseFeatureTest;

class ScheduleRepositoryTest extends BaseFeatureTest
{
    private ScheduleRepository $repository;
    private SchoolYearRepository $schoolYearRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new ScheduleRepository($this->entityManager);
        $this->schoolYearRepository = new SchoolYearRepository($this->entityManager);
    }

    public function testShouldSaveSchedule(): void
    {
        $schedule = ScheduleClass::create(
            'any description',
            '09:00',
            '10:00',
            $this->getSchoolYear()
        );

        $this->repository->create($schedule);

        $scheduleDb = $this->repository->findOneById($schedule->getId());
        $this->assertEquals($schedule->getDescription(), $scheduleDb->getDescription());
        $this->assertEquals($schedule->getSchedule(), $scheduleDb->getSchedule());
    }

    public function testShouldUpdateScheduleWithSuccess(): void
    {
        $schedule = ScheduleClass::create(
            'any description',
            '09:00',
            '10:00',
            $this->getSchoolYear()
        );

        $this->repository->create($schedule);

        $schedule->setDescription('another description');
        $this->repository->update($schedule);

        $scheduleDB = $this->repository->findOneById($schedule->getId());

        $this->assertEquals($schedule->getDescription(), $scheduleDB->getDescription());
    }

    public function testShouldDeleteScheduleWithSuccess(): void
    {
        $schedule = ScheduleClass::create(
            'any description',
            '09:00',
            '10:00',
            $this->getSchoolYear()
        );

        $this->repository->create($schedule);

        $this->repository->delete($schedule->getId());
        $sceduleDb = $this->repository->findOneById($schedule->getId());

        $this->assertNull($sceduleDb);
    }

    private function getSchoolYear(): string
    {
        $schoolYear = SchoolYear::create('2023', '2023-01-01', '2023-12-12');
        $this->schoolYearRepository->create($schoolYear);

        return $schoolYear->getId()->__toString();
    }
}
