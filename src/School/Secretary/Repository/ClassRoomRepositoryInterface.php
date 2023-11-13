<?php

namespace App\School\Secretary\Repository;

use App\School\DomainService\Paginator;
use App\School\Secretary\Dto\ClassRoomPaginatorResult;
use App\School\Secretary\Entities\ClassRoom;
use Symfony\Component\Uid\Uuid;

interface ClassRoomRepositoryInterface
{
    public function create(ClassRoom $classRoom): void;
    public function update(ClassRoom $classRoom): void;
    public function delete(Uuid $id): void;
    public function findOneById(Uuid $id): ?ClassRoom;
    public function findBy(Paginator $paginator): ClassRoomPaginatorResult;
}
