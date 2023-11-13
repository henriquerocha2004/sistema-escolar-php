<?php

namespace App\Tests\Unit\School\Secretary\Entities;

use App\School\Secretary\Entities\ScheduleClass;
use App\School\Secretary\Exeptions\PeriodException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

class ScheduleTest extends TestCase
{
    public function testShouldCreateSchedule(): void
    {
        $schedule = ScheduleClass::create('any description', '08:00', '09:00', $this->getSchoolYear());
        $this->assertEquals('any description', $schedule->getDescription());
        $this->assertNotNull($schedule->getId());
        $this->assertEquals('08:00-09:00', $schedule->getSchedule());
    }

    public function testShouldReturnErrorIfProvidedWrongFormatPeriod(): void
    {
        $this->expectException(PeriodException::class);
        $this->expectExceptionMessage('invalid format date');

        ScheduleClass::create('any description', '72:00', '25:00', $this->getSchoolYear());
    }

    public function testShouldReturnErrorIfEndTimeIsLessThanStartTime(): void
    {
        $this->expectException(PeriodException::class);
        $this->expectExceptionMessage('invalid period provided. EndAt cannot be before that StartedAt');

        ScheduleClass::create('any description', '08:00', '07:00', $this->getSchoolYear());
    }

    private function getSchoolYear(): string
    {
        return Uuid::v4()->__toString();
    }
}
