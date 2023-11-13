<?php

namespace App\Tests\Unit\School\Secretary\UseCases\SchoolYear;

use App\Repository\Secretary\SchoolYearRepository;
use App\School\Secretary\UseCases\SchoolYear\DeleteSchoolYear;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class DeleteSchoolYearTest extends TestCase
{
    public function testShouldDeleteSchoolYearWithSuccess(): void
    {
        $schoolYearRepository = Mockery::mock(SchoolYearRepository::class);
        $schoolYearRepository->shouldReceive('delete')->andReturn(null);

        $updateSchoolYear = new DeleteSchoolYear($schoolYearRepository);
        $updateSchoolYear->execute(Uuid::v4());
        $this->expectNotToPerformAssertions();
    }
}
