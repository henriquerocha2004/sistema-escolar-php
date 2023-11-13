<?php

namespace App\Repository\Secretary;

use App\School\Secretary\Collections\SchoolYearCollection;
use App\School\Secretary\Dto\SchoolYearPaginationResult;
use App\School\Secretary\Entities\SchoolYear;
use App\School\Secretary\Repository\SchoolYearRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class SchoolYearRepository implements SchoolYearRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function create(SchoolYear $schoolYear): void
    {
        $sql = 'INSERT INTO school_year 
                (id, year, start_at, end_at, created_at, updated_at) 
                VALUES
                (:id, :year, :start_at, :end_at, :created_at, :updated_at);';

        $data = $schoolYear->toArray();
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['created_at'] = date('Y-m-d H:i:s');

        $this->entityManager->getConnection()->executeQuery($sql, $data);
    }

    public function update(SchoolYear $schoolYear): void
    {
        $sql = '
            UPDATE school_year 
                SET year = :year, 
                    start_at = :start_at, 
                    end_at = :end_at, 
                    updated_at = :updated_at
             WHERE id = :id;        
        ';

        $data = $schoolYear->toArray();
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->entityManager->getConnection()->executeQuery($sql, $data);
    }

    public function delete(Uuid $schoolYearId): void
    {
        $sql = 'UPDATE school_year SET deleted_at = :deleted_at WHERE id = :id';
        $this->entityManager->getConnection()->executeQuery($sql, [
            'deleted_at' => date('Y-m-d H:i:s'),
            'id' => $schoolYearId->__toString()
        ]);
    }

    public function findOneById(Uuid $schoolYearId): SchoolYear|null
    {
        $sql = 'SELECT * FROM school_year WHERE id = :id AND deleted_at IS NULL';
        $data = $this->entityManager->getConnection()->fetchAssociative($sql, ['id' => $schoolYearId->__toString()]);
        if (!$data) {
            return null;
        }


        $schoolYear = SchoolYear::load($data);

        return $schoolYear;
    }

    public function findOneByYear(string $year): ?SchoolYear
    {
        $sql = 'SELECT * FROM school_year WHERE year = :year LIMIT 1';
        $data = $this->entityManager->getConnection()->fetchAssociative($sql, [
            'year' => $year,
        ]);
        if (!$data) {
            return null;
        }


        $schoolYear = SchoolYear::load($data);

        return $schoolYear;
    }

    public function findAll(): SchoolYearPaginationResult
    {
        $sql = 'SELECT *, COUNT(*) OVER() as total FROM school_year';

        $data = $this->entityManager->getConnection()->fetchAllAssociative($sql);

        $result = new SchoolYearPaginationResult();

        if (empty($data)) {
            $result->total = 0;
            $result->schoolYear = SchoolYearCollection::create([]);

            return $result;
        }

        $result->total = $data[0]['total'];
        $result->schoolYear = SchoolYearCollection::load($data);

        return $result;
    }
}
