<?php

namespace Tests\Unit\School\Secretary\UseCases\SchoolYear;

use Mockery;
use PHPUnit\Framework\TestCase;
use App\School\Secretary\Dto\SchoolYearDto;
use App\School\Secretary\Entities\SchoolYear;
use App\School\Secretary\Exeptions\SchoolYearException;
use App\School\Secretary\UseCases\SchoolYear\CreateSchoolYear;
use App\School\Secretary\Repository\SchoolYearRepositoryInterface;

class CreateSchoolYearTest extends TestCase
{
    public function testShouldCreateSchoolYear(): void
    {
        $schoolYearRepository = Mockery::mock(SchoolYearRepositoryInterface::class);
        $schoolYearRepository->shouldReceive('create')->andReturn(null);
        $schoolYearRepository->shouldReceive('findOneByYear')->andReturn(null);
        $createSchoolyear = new CreateSchoolYear($schoolYearRepository);

        $dto = new SchoolYearDto('2023', '2023-01-01', '2023-12-30');
        $createSchoolyear->execute($dto);
        $this->expectNotToPerformAssertions();
    }

    public function testShouldReturnErrorIfSchoolYearAlreadyExists(): void
    {
        $this->expectException(SchoolYearException::class);
        $this->expectExceptionMessage('the school year provided already exists');

        $schoolYearRepository = Mockery::mock(SchoolYearRepositoryInterface::class);
        $schoolYearRepository->shouldReceive('create')->andReturn(null);
        $schooYear = SchoolYear::Create('2011', '2011-02-01', '2011-12-30');
        $schoolYearRepository->shouldReceive('findOneByYear')->andReturn($schooYear);
        $createSchoolyear = new CreateSchoolYear($schoolYearRepository);
        $dto = new SchoolYearDto('2011', '2011-02-01', '2011-12-30');
        $createSchoolyear->execute($dto);
    }
}
