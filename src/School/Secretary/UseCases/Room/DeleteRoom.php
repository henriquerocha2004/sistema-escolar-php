<?php

namespace App\School\Secretary\UseCases\Room;

use App\School\Secretary\Repository\RoomRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class DeleteRoom
{
    public function __construct(
        private readonly RoomRepositoryInterface $roomRepository
    ) {
    }

    public function execute(string $id): void
    {
        $uuid = Uuid::fromString($id);
        $this->roomRepository->delete($uuid);
    }
}
