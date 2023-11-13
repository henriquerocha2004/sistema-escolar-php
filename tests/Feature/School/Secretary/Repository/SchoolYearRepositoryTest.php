<?php

namespace App\Tests\Feature\School\Secretary\Repository;

use App\Repository\Secretary\SchoolYearRepository;
use App\School\Secretary\Entities\SchoolYear;
use App\Tests\Feature\BaseFeatureTest;

class SchoolYearRepositoryTest extends BaseFeatureTest
{
    public function testShouldSaveSchoolYearWithSuccess(): void
    {
        $schoolYear = SchoolYear::Create('2024', '2023-01-01', '2023-12-10');
        $repository = new SchoolYearRepository($this->entityManager);
        $repository->create($schoolYear);
        $schoolYearDb = $repository->findOneById($schoolYear->getId());

        $this->assertEquals($schoolYear->getYear(), $schoolYearDb->getYear());
    }

    public function testShouldUpdateSchoolYearWithSuccess(): void
    {
        $schoolYear = SchoolYear::Create('2024', '2023-01-01', '2023-12-10');
        $repository = new SchoolYearRepository($this->entityManager);
        $repository->create($schoolYear);

        $schoolYear->setYear('2025');
        $repository->update($schoolYear);

        $schoolYearDb = $repository->findOneById($schoolYear->getId());
        $this->assertEquals($schoolYear->getYear(), $schoolYearDb->getYear());
    }

    public function testShouldDeleteSchooYearWithSuccess(): void
    {
        $schoolYear = SchoolYear::Create('2024', '2023-01-01', '2023-12-10');
        $repository = new SchoolYearRepository($this->entityManager);
        $repository->create($schoolYear);

        $repository->delete($schoolYear->getId());

        $schoolYearDb = $repository->findOneById($schoolYear->getId());

        $this->assertEmpty($schoolYearDb);
    }
}
