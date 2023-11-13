<?php

namespace App\Repository\Secretary;

use App\Repository\BaseRepository;
use App\School\Secretary\Entities\ClassRoom;
use App\School\DomainService\Paginator;
use App\School\Secretary\Collections\ClassRoomCollection;
use App\School\Secretary\Dto\ClassRoomPaginatorResult;
use App\School\Secretary\Repository\ClassRoomRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class ClassRoomRepository extends BaseRepository implements ClassRoomRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function create(ClassRoom $classRoom): void
    {
        $sql = 'INSERT INTO class_room 
         (id, vacancies, shift, open_date, vacancies_occupied, 
          status, level, identification, school_year_id, room_id,
          schedule_id, localization, type, created_at, updated_at)
        VALUES
        (:id, :vacancies, :shift, :open_date, :vacancies_occupied,
         :status, :level, :identification, :school_year_id, :room_id,
         :schedule_id, :localization, :type, :created_at, :updated_at)';

        $data = $classRoom->toArray();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->entityManager->getConnection()->executeQuery($sql, $data);
    }

    public function update(ClassRoom $classRoom): void
    {
        $sql = 'UPDATE class_room SET 
            vacancies_quantity = :vacancies_quantity,
            shift = :shift,
            open_date = :open_date,
            vacancies_occupied = :vacancies_occupied,
            status = :status,
            level = :level,
            identification = :identification,
            school_year_id = :school_year_id,
            room_id = :room_id,
            schedule_id = :schedule_id,
            localization = :localization,
            type = :type,
            updated_at = :updated_at
          WHERE id = :id   
        ';
        $data = $classRoom->toArray();
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->entityManager->getConnection()->executeQuery($sql, $data);
    }

    public function delete(Uuid $id): void
    {
        $sql = 'UPDATE class_room SET deleted_at = :deleted_at WHERE id = :id';
        $this->entityManager->getConnection()->executeQuery($sql, [
            'deleted_at' => date('Y-m-d H:i:s'),
            'id' => $id->__toString(),
        ]);
    }

    public function findOneById(Uuid $id): ?ClassRoom
    {
        $sql = 'SELECT * FROM class_room WHERE id = :id';
        $data = $this->entityManager->getConnection()->fetchAssociative($sql, [
            'id' => $id->__toString(),
        ]);

        if (!$data) {
            return null;
        }

        return ClassRoom::load($data);
    }

    public function findBy(Paginator $paginator): ClassRoomPaginatorResult
    {
        $sql = "SELECT *, COUNT(*) OVER() as total FROM class_room 
        WHERE (
            shift like :search 
            OR level like :search
            OR identification like :search
            OR localization like :search
            OR type like :search
        ) 
        AND deleted_at IS NULL";

        $filteredSql = $this->mountSql($paginator);
        $sql = $sql . $filteredSql;

        $classRooms = $this->entityManager->getConnection()->fetchAllAssociative($sql, [
            'search' => "%{$paginator->search}%",
        ]);

        $result = new ClassRoomPaginatorResult();

        if (!$classRooms) {
            $result->total = 0;
            $result->classRooms = ClassRoomCollection::create([]);

            return $result;
        }

        $result->classRooms = ClassRoomCollection::load($classRooms);
        $result->total = $classRooms[0]['total'];

        return $result;
    }
}
