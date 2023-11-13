<?php

namespace App\Tests\Unit\School\Secretary\UseCases\ClassRoom;

use App\School\Secretary\Dto\ClassRoomDto;
use App\School\Secretary\Exeptions\ClassRoomException;
use App\School\Secretary\Repository\ClassRoomRepositoryInterface;
use App\School\Secretary\UseCases\ClassRoom\CreateClassRoom;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class CreateClassRoomTest extends TestCase
{
    /**
     * @throws ClassRoomException
     */
    public function testShouldCreateClassRoomWithSuccess(): void
    {
        $repository = $this->createMock(ClassRoomRepositoryInterface::class);
        $repository->expects($this->once())
            ->method('create');

        $classRoomDto = new ClassRoomDto();
        $classRoomDto->identification = 'TN-001';
        $classRoomDto->vacanciesQuantity = 30;
        $classRoomDto->schoolYearId = Uuid::v4()->__toString();
        $classRoomDto->shift = 'morning';
        $classRoomDto->scheduleId = Uuid::v4()->__toString();
        $classRoomDto->level = '2 Ano';
        $classRoomDto->type = 'in_person';
        $classRoomDto->roomId = Uuid::v4()->__toString();

        $createClassRoom = new CreateClassRoom($repository);
        $createClassRoom->execute($classRoomDto);
    }
}
