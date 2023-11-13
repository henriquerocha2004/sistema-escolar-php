<?php

namespace App\Tests\Feature\School\Secretary\Repository;

use App\Repository\Secretary\ClassRoomRepository;
use App\Repository\Secretary\RoomRepository;
use App\Repository\Secretary\ScheduleRepository;
use App\Repository\Secretary\SchoolYearRepository;
use App\School\Secretary\Entities\ClassRoom;
use App\School\Secretary\Entities\Room;
use App\School\Secretary\Entities\ScheduleClass;
use App\School\Secretary\Entities\SchoolYear;
use App\Tests\Feature\BaseFeatureTest;

class ClassRoomRepositoryTest extends BaseFeatureTest
{
    private ClassRoomRepository $repository;
    private SchoolYearRepository $schoolYearRepository;
    private ScheduleRepository $scheduleRepository;
    private RoomRepository $roomRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new ClassRoomRepository($this->entityManager);
        $this->schoolYearRepository = new SchoolYearRepository($this->entityManager);
        $this->scheduleRepository = new ScheduleRepository($this->entityManager);
        $this->roomRepository = new RoomRepository($this->entityManager);
    }

    public function testShouldCreateClassRoom(): void
    {
        $classRoom = $this->getClassRoom();
        $this->repository->create($classRoom);

        $classRoomDB = $this->repository->findOneById($classRoom->getId());

        $this->assertEquals($classRoom->getIdentification(), $classRoomDB->getIdentification());
        $this->assertEquals($classRoom->getVacanciesQuantity(), $classRoomDB->getVacanciesQuantity());
    }

    private function getClassRoom(): ClassRoom
    {
        $schoolYear = SchoolYear::create('2002', '2002-01-01', '2002-12-01');
        $this->schoolYearRepository->create($schoolYear);
        $room = Room::create('001', 30);
        $this->roomRepository->create($room);
        $schedule = ScheduleClass::create('description', '09:00', '10:00', $schoolYear->getId()->__toString());
        $this->scheduleRepository->create($schedule);

        return ClassRoom::create(
            'TN-01',
            30,
            'morning',
            '2 ano',
            $schoolYear->getId()->__toString(),
            $schedule->getId()->__toString(),
            'in_person',
            $room->getId()->__toString(),
            'any Location'
        );
    }
}
