<?php

namespace App\School\Secretary\UseCases\Room;

use App\School\DomainService\Paginator;
use App\School\Secretary\Dto\PaginatorRequestDto;
use App\School\Secretary\Dto\RoomPaginatorResult;
use App\School\Secretary\Entities\Room;
use App\School\Secretary\Repository\RoomRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class ReadRoom
{
    public function __construct(
        private readonly RoomRepositoryInterface $roomRepository
    ) {
    }

    public function findOneById(string $id): ?Room
    {
        $uuid = Uuid::fromString($id);
        return $this->roomRepository->findOneById($uuid);
    }

    public function findByCriteria(PaginatorRequestDto $dto): RoomPaginatorResult
    {
        $paginator = Paginator::create($dto);

        return $this->roomRepository->findBy($paginator);
    }
}
