<?php

namespace App\Tests\Unit\School\Secretary\UseCases\Rooms;

use App\Repository\Secretary\RoomRepository;
use App\School\Secretary\Dto\RoomDto;
use App\School\Secretary\Entities\Room;
use App\School\Secretary\Exeptions\RoomException;
use App\School\Secretary\UseCases\Room\CreateRoom;
use PHPUnit\Framework\TestCase;

class CreateRoomTest extends TestCase
{
    /**
     * @throws RoomException
     */
    public function testShouldCreateRoomWithSuccess(): void
    {
        $roomRepository = $this->createMock(RoomRepository::class);
        $roomRepository->expects($this->once())
            ->method('create');

        $createRoom = new CreateRoom($roomRepository);
        $roomDto = new RoomDto(10, '1234', 'any description');
        $createRoom->execute($roomDto);
    }

    public function testShouldReturnErrorIfTrySaveRoomWithCodeAlreadySaved(): void
    {
        $this->expectException(RoomException::class);
        $this->expectExceptionMessage('room code already exists');

        $roomRepository = $this->createMock(RoomRepository::class);
        $roomRepository->expects($this->once())
            ->method('findByCode')
            ->willReturn($this->getRoom());

        $createRoom = new CreateRoom($roomRepository);
        $roomDto = new RoomDto(10, '1234', 'any description');
        $createRoom->execute($roomDto);
    }

    private function getRoom(): Room
    {
        return Room::create('TN-001', 60);
    }
}
