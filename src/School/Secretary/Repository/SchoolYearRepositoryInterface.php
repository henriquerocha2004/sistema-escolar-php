<?php

namespace App\School\Secretary\Repository;

use App\School\Secretary\Dto\SchoolYearPaginationResult;
use App\School\Secretary\Entities\SchoolYear;
use Symfony\Component\Uid\Uuid;

interface SchoolYearRepositoryInterface
{
    public function create(SchoolYear $schoolYear): void;
    public function update(SchoolYear $schoolYear): void;
    public function delete(Uuid $schoolYearId): void;
    public function findOneById(Uuid $schoolYearId): SchoolYear|null;
    public function findOneByYear(string $year): SchoolYear|null;
    public function findAll(): SchoolYearPaginationResult;
}
