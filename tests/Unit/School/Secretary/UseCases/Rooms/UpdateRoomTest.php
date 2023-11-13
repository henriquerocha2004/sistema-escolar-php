<?php

namespace App\Tests\Unit\School\Secretary\UseCases\Rooms;

use App\Repository\Secretary\RoomRepository;
use App\School\Secretary\Dto\RoomDto;
use App\School\Secretary\UseCases\Room\UpdateRoom;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class UpdateRoomTest extends TestCase
{
    public function testShouldUpdateRoomWithSuccess(): void
    {
        $roomRepository = $this->createMock(RoomRepository::class);
        $roomRepository->expects($this->once())
            ->method('update');

        $updateRoom = new UpdateRoom($roomRepository);
        $roomDto = new RoomDto(20, '123456', 'any description');
        $updateRoom->execute($roomDto, Uuid::v4());
    }
}
