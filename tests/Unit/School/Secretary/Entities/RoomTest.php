<?php

namespace App\Tests\Unit\School\Secretary\Entities;

use App\School\Secretary\Entities\Room;
use App\School\Secretary\Exeptions\RoomException;
use PHPUnit\Framework\TestCase;

class RoomTest extends TestCase
{
    public function testShouldCreateRoom(): void
    {
        $room = Room::Create('TN-01', 20, 'sala ao lado da cozinha');
        $this->assertEquals('TN-01', $room->getCode());
    }

    public function testShouldReturnErrorIfCodeRoomIsNotProvided(): void
    {
        $this->expectException(RoomException::class);
        $this->expectExceptionMessage('code provided is invalid');
        Room::Create('', 10);
    }

    public function testShouldReturnErrorIfCapacityProvidedIsInvalid(): void
    {
        $this->expectException(RoomException::class);
        $this->expectExceptionMessage('invalid capacity provided');
        Room::Create('TN001', -32);
    }
}
