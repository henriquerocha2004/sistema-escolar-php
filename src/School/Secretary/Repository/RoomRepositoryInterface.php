<?php

namespace App\School\Secretary\Repository;

use App\School\DomainService\Paginator;
use App\School\Secretary\Dto\RoomPaginatorResult;
use App\School\Secretary\Entities\Room;
use Symfony\Component\Uid\Uuid;

interface RoomRepositoryInterface
{
    public function create(Room $room): void;
    public function update(Room $room): void;
    public function delete(Uuid $roomId): void;
    public function findOneById(Uuid $roomId): Room|null;
    public function findByCode(string $code): Room|null;
    public function findBy(Paginator $paginator): RoomPaginatorResult;
}
