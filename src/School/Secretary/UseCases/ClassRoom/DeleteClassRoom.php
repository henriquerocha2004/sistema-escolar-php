<?php

namespace App\School\Secretary\UseCases\ClassRoom;

use App\School\Secretary\Repository\ClassRoomRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class DeleteClassRoom
{
    public function __construct(
        private readonly ClassRoomRepositoryInterface $classRoomRepository
    ) {
    }

    public function execute(string $id): void
    {
        $uuid = Uuid::fromString($id);
        $this->classRoomRepository->delete($uuid);
    }
}