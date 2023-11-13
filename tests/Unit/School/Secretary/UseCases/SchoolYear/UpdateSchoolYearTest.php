<?php

namespace Tests\Unit\School\Secretary\UseCases\SchoolYear;

use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use App\School\Secretary\Dto\SchoolYearDto;
use App\Repository\Secretary\SchoolYearRepository;
use App\School\Secretary\UseCases\SchoolYear\UpdateSchoolYear;

class UpdateSchoolYearTest extends TestCase
{
    public function testShouldUpdateSchoolYearWithSuccess(): void
    {
        $schoolYearRepository = Mockery::mock(SchoolYearRepository::class);
        $schoolYearRepository->shouldReceive('update')->andReturn(null);

        $updateSchoolYear = new UpdateSchoolYear($schoolYearRepository);
        $dto = new SchoolYearDto('2003', '2003-01-01', '2003-12-15');
        $updateSchoolYear->execute($dto, Uuid::v4());
        $this->expectNotToPerformAssertions();
    }
}
