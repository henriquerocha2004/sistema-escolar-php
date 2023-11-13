<?php

namespace App\School\Secretary\UseCases\Room;

use App\School\Secretary\Dto\RoomDto;
use App\School\Secretary\Entities\Room;
use App\School\Secretary\Exeptions\RoomException;
use App\School\Secretary\Repository\RoomRepositoryInterface;

class CreateRoom
{
    public function __construct(
        private readonly RoomRepositoryInterface $roomRepository
    ) {
    }

    public function execute(RoomDto $dto): void
    {
        if ($this->roomAlreadyExists($dto->code)) {
            throw new RoomException('room code already exists');
        }

        $room = Room::create($dto->code, $dto->capacity, $dto->description);
        $this->roomRepository->create($room);
    }

    private function roomAlreadyExists(string $code): bool
    {
        $room = $this->roomRepository->findByCode($code);

        return !is_null($room);
    }
}
