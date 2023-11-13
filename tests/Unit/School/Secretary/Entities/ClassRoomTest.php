<?php

namespace App\Tests\Unit\School\Secretary\Entities;

use App\School\Secretary\Entities\ClassRoom;
use App\School\Secretary\Enums\ShiftEnum;
use App\School\Secretary\Enums\TypeClassEnum;
use App\School\Secretary\Exeptions\ClassRoomException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use ValueError;

class ClassRoomTest extends TestCase
{
    public function testShouldReturnErrorIfTryCreateClassRoomWithoutIdentification(): void
    {
        $this->expectException(ClassRoomException::class);
        $this->expectExceptionMessage('provide identification class');

        ClassRoom::create(
            '',
            10,
            ShiftEnum::MORNING->value,
            '2 ano',
            Uuid::v4()->__toString(),
            Uuid::v4()->__toString(),
            TypeClassEnum::IN_PERSON->value,
        );
    }

    public function testShouldReturnErrorIfTryCreateClassRoomWithoutVacancyQuantity(): void
    {
        $this->expectException(ClassRoomException::class);
        $this->expectExceptionMessage('provide vacancy quantity');

        ClassRoom::create(
            'CL-001',
            0,
            ShiftEnum::MORNING->value,
            '2 ano',
            Uuid::v4()->__toString(),
            Uuid::v4()->__toString(),
            TypeClassEnum::IN_PERSON->value,
        );
    }

    public function testShouldReturnErrorIfTrySetVacancyQuantityLessThanOccupiedVacancies(): void
    {
        $this->expectException(ClassRoomException::class);
        $this->expectExceptionMessage('vacancy quantity cannot be less than occupied vacancy');

        $classRoom = ClassRoom::create(
            'CL-001',
            10,
            ShiftEnum::MORNING->value,
            '2 ano',
            Uuid::v4()->__toString(),
            Uuid::v4()->__toString(),
            TypeClassEnum::IN_PERSON->value,
        );
        $classRoom->setOccupiedVacancy(5);
        $classRoom->setVacancyQuantity(3);
    }

    public function testShouldReturnErrorIfTryCreateClassWithoutShift(): void
    {
        $this->expectException(ClassRoomException::class);
        $this->expectExceptionMessage('provide shift');

        ClassRoom::create(
            'CL-001',
            10,
            '',
            '2 ano',
            Uuid::v4()->__toString(),
            Uuid::v4()->__toString(),
            TypeClassEnum::IN_PERSON->value,
        );
    }

    /**
     * @throws ClassRoomException
     */
    public function testShouldReturnErrorIfTryCreateClassWithInvalidShift(): void
    {
        $this->expectException(ValueError::class);
        $this->expectExceptionMessage(
            '"any" is not a valid backing value for enum App\School\Secretary\Enums\ShiftEnum'
        );

        ClassRoom::create(
            'CL-001',
            10,
            'any',
            '2 ano',
            Uuid::v4()->__toString(),
            Uuid::v4()->__toString(),
            TypeClassEnum::IN_PERSON->value,
        );
    }

    public function testShouldReturnErrorIfTryCreateClassWithoutLevel(): void
    {
        $this->expectException(ClassRoomException::class);
        $this->expectExceptionMessage('provide level');

        ClassRoom::create(
            'CL-001',
            10,
            ShiftEnum::MORNING->value,
            '',
            Uuid::v4()->__toString(),
            Uuid::v4()->__toString(),
            TypeClassEnum::IN_PERSON->value,
        );
    }

    public function testShouldReturnErrorIfTryCreateClassWithoutSchoolYearId(): void
    {
        $this->expectException(ClassRoomException::class);
        $this->expectExceptionMessage('provide school_year_id');

        ClassRoom::create(
            'CL-001',
            10,
            ShiftEnum::MORNING->value,
            '2 ano',
            '',
            Uuid::v4()->__toString(),
            TypeClassEnum::IN_PERSON->value
        );
    }

    public function testShouldReturnErrorIfTryCreateClassWithoutScheduleId(): void
    {
        $this->expectException(ClassRoomException::class);
        $this->expectExceptionMessage('provide schedule id');

        ClassRoom::create(
            'CL-001',
            10,
            ShiftEnum::MORNING->value,
            '2 ano',
            Uuid::v4()->__toString(),
            '',
            TypeClassEnum::IN_PERSON->value
        );
    }

    public function testShouldReturnErrorIfTryCreateClassWithoutTypeClass(): void
    {
        $this->expectException(ClassRoomException::class);
        $this->expectExceptionMessage('provide type class');

        ClassRoom::create(
            'CL-001',
            10,
            ShiftEnum::MORNING->value,
            '2 ano',
            Uuid::v4()->__toString(),
            Uuid::v4()->__toString(),
            ''
        );
    }
}
