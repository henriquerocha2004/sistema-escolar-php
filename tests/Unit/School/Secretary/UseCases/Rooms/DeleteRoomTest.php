<?php

namespace App\Tests\Unit\School\Secretary\UseCases\Rooms;

use App\Repository\Secretary\RoomRepository;
use App\School\Secretary\UseCases\Room\DeleteRoom;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class DeleteRoomTest extends TestCase
{
    public function testShouldDeleteWithSucess(): void
    {
        $roomRepository = $this->createMock(RoomRepository::class);
        $roomRepository->expects($this->once())
            ->method('delete');

        $deleteRoom = new DeleteRoom($roomRepository);
        $deleteRoom->execute(Uuid::v4()->__toString());
    }
}
