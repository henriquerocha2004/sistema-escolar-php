<?php

namespace App\Repository\Secretary;

use App\Repository\BaseRepository;
use App\School\DomainService\Paginator;
use App\School\Secretary\Collections\RoomCollection;
use App\School\Secretary\Dto\RoomPaginatorResult;
use App\School\Secretary\Entities\Room;
use App\School\Secretary\Repository\RoomRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class RoomRepository extends BaseRepository implements RoomRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function findByCode(string $code): ?Room
    {
        $sql = 'SELECT * FROM rooms WHERE code = :code';
        $room = $this->entityManager->getConnection()->fetchAssociative($sql, [
            'code' => $code,
        ]);

        if (!$room) {
            return null;
        }

        return Room::load($room);
    }

    public function create(Room $room): void
    {
        $sql = 'INSERT INTO rooms (id, code, capacity, description, created_at, updated_at) 
                VALUES (:id, :code, :capacity, :description, :created_at, :updated_at);';
        $data = $room->toArray();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->entityManager->getConnection()->executeQuery($sql, $data);
    }

    public function update(Room $room): void
    {
        $sql = 'UPDATE rooms SET 
                code = :code, 
                capacity = :capacity,
                description = :description, 
                updated_at = :updated_at 
                WHERE id = :id;';

        $data = $room->toArray();
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->entityManager->getConnection()->executeQuery($sql, $data);
    }

    public function delete(Uuid $roomId): void
    {
        $sql = 'UPDATE rooms SET deleted_at = :deleted_at WHERE id = :id';
        $this->entityManager->getConnection()->executeQuery($sql, [
            'deleted_at' => date('Y-m-d H:i:s'),
            'id' => $roomId->__toString(),
        ]);
    }

    public function findOneById(Uuid $roomId): ?Room
    {
        $sql = 'SELECT * FROM rooms WHERE id = :id AND deleted_at IS NULL';
        $room = $this->entityManager->getConnection()->fetchAssociative($sql, [
            'id' => $roomId->__toString(),
        ]);

        if (!$room) {
            return null;
        }

        return Room::load($room);
    }

    public function findBy(Paginator $paginator): RoomPaginatorResult
    {
        $sql = "SELECT *, COUNT(*) OVER() as total FROM rooms 
                WHERE (code like :search OR description like :search) AND deleted_at IS NULL";

        $filteredSql = $this->mountSql($paginator);
        $sql = $sql . $filteredSql;

        $rooms = $this->entityManager->getConnection()->fetchAllAssociative($sql, [
            'search' => "%{$paginator->search}%",
        ]);

        $result = new RoomPaginatorResult();

        if (!$rooms) {
            $result->total = 0;
            $result->rooms = RoomCollection::create([]);

            return $result;
        }

        $result->rooms = RoomCollection::load($rooms);
        $result->total = $rooms[0]['total'];

        return $result;
    }
}
