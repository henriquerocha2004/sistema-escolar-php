<?php

namespace App\School\Secretary\UseCases\Room;

use App\School\Secretary\Dto\RoomDto;
use App\School\Secretary\Entities\Room;
use App\School\Secretary\Repository\RoomRepositoryInterface;

class UpdateRoom
{
    public function __construct(
        private readonly RoomRepositoryInterface $roomRepository
    ) {
    }

    public function execute(RoomDto $dto, string $id): void
    {
        $room = Room::create($dto->code, $dto->capacity, $dto->description);
        $room->setId($id);
        $this->roomRepository->update($room);
    }
}
