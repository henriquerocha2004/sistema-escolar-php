<?php

namespace App\Tests\Unit\School\Secretary\UseCases\ClassRoom;

use App\School\Secretary\Dto\ClassRoomDto;
use App\School\Secretary\Repository\ClassRoomRepositoryInterface;
use App\School\Secretary\UseCases\ClassRoom\UpdateClassRoom;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class UpdateClassRoomTest extends TestCase
{
    public function testShouldUpdateClassRoomWithSuccess(): void
    {
        $repository = $this->createMock(ClassRoomRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('update');

        $classRoomDto = new ClassRoomDto();
        $classRoomDto->identification = 'TN-001';
        $classRoomDto->vacanciesQuantity = 30;
        $classRoomDto->schoolYearId = Uuid::v4()->__toString();
        $classRoomDto->shift = 'morning';
        $classRoomDto->scheduleId = Uuid::v4()->__toString();
        $classRoomDto->level = '2 Ano';
        $classRoomDto->type = 'in_person';
        $classRoomDto->roomId = Uuid::v4()->__toString();

        $updateClassRoom = new UpdateClassRoom($repository);
        $updateClassRoom->execute($classRoomDto, Uuid::v4()->__toString());
    }
}
