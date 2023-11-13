<?php

namespace App\School\Secretary\UseCases\ClassRoom;

use App\School\DomainService\Paginator;
use App\School\Secretary\Dto\ClassRoomPaginatorResult;
use App\School\Secretary\Dto\PaginatorRequestDto;
use App\School\Secretary\Entities\ClassRoom;
use App\School\Secretary\Repository\ClassRoomRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class ReadClassRoom
{
    public function __construct(
        private readonly ClassRoomRepositoryInterface $classRoomRepository
    ) {
    }

    public function findByOne(string $id): ?ClassRoom
    {
        $uuid = Uuid::fromString($id);
        return $this->classRoomRepository->findOneById($uuid);
    }

    public function findBy(PaginatorRequestDto $dto): ClassRoomPaginatorResult
    {
        $paginator = Paginator::create($dto);
        return $this->classRoomRepository->findBy($paginator);
    }
}