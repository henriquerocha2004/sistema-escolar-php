<?php

namespace Tests\Unit\School\Secretary\Entities;

use App\School\Secretary\Entities\SchoolYear;
use App\School\Secretary\Exeptions\PeriodException;
use App\School\Secretary\Exeptions\SchoolYearException;
use PHPUnit\Framework\TestCase;

class SchoolYearTest extends TestCase
{
    public function testShouldCreateSchoolYearWithSuccess(): void
    {
        $schoolYear = SchoolYear::Create('2023', '2023-01-10', '2023-12-20');
        $this->assertEquals('2023', $schoolYear->getYear());
    }

    public function testShouldReturnErrorWhenCreateSchoolYearWithoutYearProvided(): void
    {
        $this->expectException(SchoolYearException::class);
        $this->expectExceptionMessage('year not provided');
        SchoolYear::Create('', '2023-01-10', '2023-12-20');
    }

    public function testShouldReturnErrorWhenCreateSchoolYearWithoutStartDateProvided(): void
    {
        $this->expectException(SchoolYearException::class);
        $this->expectExceptionMessage('startAt not provided');
        SchoolYear::Create('2023', '', '2023-12-20');
    }

    public function testShouldReturnErrorWhenCreateSchoolYearWithoutEndAtProvided(): void
    {
        $this->expectException(SchoolYearException::class);
        $this->expectExceptionMessage('endAt not provided');
        SchoolYear::Create('2023', '2023-12-20', '');
    }

    public function testShouldReturnErrorIfProvidedStartDateWithInvalidFormatDate(): void
    {
        $this->expectException(PeriodException::class);
        $this->expectExceptionMessage('invalid format date');
        SchoolYear::Create('2023', '10-12-20', '2023-12-23');
    }

    public function testShouldReturnErrorIfProvidedEndAtWithInvalidFormatDate(): void
    {
        $this->expectException(PeriodException::class);
        $this->expectExceptionMessage('invalid format date');
        SchoolYear::Create('2023', '2023-12-23', '23-12-23');
    }

    public function testShouldReturnErrorIfEndAtLessThanStartedAt(): void
    {
        $this->expectException(PeriodException::class);
        $this->expectExceptionMessage('invalid period provided. EndAt cannot be before that StartedAt');
        $schoolYear = SchoolYear::Create('2023', '2023-01-10', '2022-12-20');
        $schoolYear->checkPeriod();
    }
}
