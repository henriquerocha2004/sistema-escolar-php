<?php

namespace App\Repository\Secretary;

use Symfony\Component\Uid\Uuid;
use App\Repository\BaseRepository;
use App\School\DomainService\Paginator;
use Doctrine\ORM\EntityManagerInterface;
use App\School\Secretary\Entities\ScheduleClass;
use App\School\Secretary\Collections\RoomCollection;
use App\School\Secretary\Dto\SchedulePaginatorResult;
use App\School\Secretary\Collections\ScheduleCollection;
use App\School\Secretary\Repository\ScheduleRepositoryInterface;

class ScheduleRepository extends BaseRepository implements ScheduleRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function create(ScheduleClass $scheduleClass): void
    {
        $sql = 'INSERT INTO class_schedule 
                (id, schedule, description, school_year_id, created_at, updated_at)
                VALUES
                (:id, :schedule, :description, :school_year_id, :created_at, :updated_at)';

        $schedule = $scheduleClass->toArray();
        $schedule['created_at'] = date('Y-m-d H:i:s');
        $schedule['updated_at'] = date('Y-m-d H:i:s');

        $this->entityManager->getConnection()->executeQuery($sql, $schedule);
    }

    public function update(ScheduleClass $scheduleClass): void
    {
        $sql = 'UPDATE class_schedule SET 
                    schedule = :schedule, 
                    description = :description,
                    school_year_id = :school_year_id,
                    updated_at = :updated_at
                WHERE id = :id';
        $schedule = $scheduleClass->toArray();
        $schedule['updated_at'] = date('Y-m-d H:i:s');

        $this->entityManager->getConnection()->executeQuery($sql, $schedule);
    }

    public function delete(Uuid $scheduleId): void
    {
        $sql = 'UPDATE class_schedule SET deleted_at = :deleted_at WHERE id = :id';
        $this->entityManager->getConnection()->executeQuery($sql, [
            'deleted_at' => date('Y-m-d H:i:s'),
            'id' => $scheduleId->__toString(),
        ]);
    }

    public function findOneById(Uuid $scheduleId): ?ScheduleClass
    {
        $sql = 'SELECT * FROM class_schedule WHERE id = :id AND deleted_at IS NULL';
        $schedule = $this->entityManager->getConnection()->fetchAssociative($sql, [
            'id' => $scheduleId->__toString(),
        ]);

        if (empty($schedule)) {
            return null;
        }

        return ScheduleClass::load($schedule);
    }

    public function findBy(Paginator $paginator): SchedulePaginatorResult
    {
        $sql = 'SELECT *, COUNT(*) OVER() as total FROM class_schedule
            WHERE (schedule LIKE :search OR description LIKE :search) AND deleted_at IS NULL';

        $filteredSql = $this->mountSql($paginator);
        $sql = $sql . $filteredSql;

        $schedules = $this->entityManager->getConnection()->fetchAllAssociative($sql, [
            'search' => "%{$paginator->search}%",
        ]);

        $result = new SchedulePaginatorResult();

        if (!$schedules) {
            $result->total = 0;
            $result->schedules = RoomCollection::create([]);

            return $result;
        }

        $result->schedules = ScheduleCollection::load($schedules);
        $result->total = $schedules[0]['total'];

        return $result;
    }
}
