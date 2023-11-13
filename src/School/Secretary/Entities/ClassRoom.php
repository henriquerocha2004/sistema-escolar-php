<?php

namespace App\School\Secretary\Entities;

use App\School\Secretary\Enums\ClassRoomStatusEnum;
use App\School\Secretary\Enums\ShiftEnum;
use App\School\Secretary\Enums\TypeClassEnum;
use App\School\Secretary\Exeptions\ClassRoomException;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class ClassRoom
{
    private Uuid $id;
    private int $vacancies;
    private ShiftEnum $shift;
    private DateTimeImmutable $openDate;
    private int $vacanciesOccupied;
    private ClassRoomStatusEnum $status;
    private string $level;
    private string $identification;
    private Uuid $schoolYearId;
    private Uuid $roomId;
    private Uuid $scheduleId;
    private string $localization;
    private TypeClassEnum $type;


    private function __construct()
    {
        $this->id = Uuid::v4();
        $this->openDate = new DateTimeImmutable();
        $this->status = ClassRoomStatusEnum::OPEN;
        $this->vacanciesOccupied = 0;
    }

    /**
     * @throws ClassRoomException
     */
    public static function create(
        string $identification,
        int $vacancies,
        string $shift,
        string $level,
        string $schoolYearId,
        string $scheduleId,
        string $type,
        string $roomId = '',
        string $localization = ''
    ): self {

        $classRoom = new self();
        $classRoom->setIdentification($identification);
        $classRoom->setVacancy($vacancies);
        $classRoom->setShift($shift);
        $classRoom->setLevel($level);
        $classRoom->setSchoolYearId($schoolYearId);
        $classRoom->setScheduleId($scheduleId);
        $classRoom->setRoomId($roomId);
        $classRoom->setType($type);
        $classRoom->setLocalization($localization);

        return $classRoom;
    }

    /**
     * @throws ClassRoomException
     */
    public static function load(array $item): self
    {
        $classRoom = self::create(
            $item['identification'],
            $item['vacancies'],
            $item['shift'],
            $item['level'],
            $item['school_year_id'],
            $item['schedule_id'],
            $item['type'],
            $item['room_id'],
            $item['localization']
        );

        $classRoom->setStatus($item['status']);
        $classRoom->setId($item['id']);
        $classRoom->setOccupiedVacancy($item['vacancies_occupied']);

        return $classRoom;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getVacanciesQuantity(): int
    {
        return $this->vacancies;
    }

    public function getShift(): ShiftEnum
    {
        return $this->shift;
    }

    public function getOpenDate(): DateTimeImmutable
    {
        return $this->openDate;
    }

    public function getOccupiedVacancy(): int
    {
        return $this->vacanciesOccupied;
    }

    public function getStatus(): ClassRoomStatusEnum
    {
        return $this->status;
    }

    public function getLevel(): string
    {
        return $this->level;
    }

    public function getIdentification(): string
    {
        return $this->identification;
    }

    public function getSchoolYearId(): Uuid
    {
        return $this->schoolYearId;
    }

    public function getRoomId(): Uuid
    {
        return $this->roomId;
    }

    public function getScheduleId(): Uuid
    {
        return $this->scheduleId;
    }

    public function getLocalization(): string
    {
        return $this->localization;
    }

    public function getType(): TypeClassEnum
    {
        return $this->type;
    }

    /**
     * @throws ClassRoomException
     */
    public function setIdentification(string $identification): void
    {
        if (empty($identification)) {
            throw new ClassRoomException('provide identification class');
        }

        $this->identification = $identification;
    }

    /**
     * @throws ClassRoomException
     */
    public function setVacancy(int $quantity): void
    {
        if (empty($quantity)) {
            throw new ClassRoomException('provide vacancy quantity');
        }

        if ($quantity < $this->vacanciesOccupied) {
            throw new ClassRoomException('vacancy quantity cannot be less than occupied vacancy');
        }

        $this->vacancies = $quantity;
    }

    /**
     * @throws ClassRoomException
     */
    public function setOccupiedVacancy(int $quantity): void
    {
        if ($quantity <= 0) {
            return;
        }

        $this->checkStatus();

        $remainingVacancies = $this->vacancies - $this->vacanciesOccupied;

        if ($quantity > $remainingVacancies) {
            throw new ClassRoomException(
                'number of available vacancies is less than the number of vacancies requested'
            );
        }

        if ($quantity > $this->vacancies) {
            throw new ClassRoomException(
                'number of vacancies for this class is less than the number of vacancies requested'
            );
        }

        $this->vacanciesOccupied += $quantity;
    }

    /**
     * @throws ClassRoomException
     */
    public function setShift(string $shift): void
    {
        if (empty($shift)) {
            throw new ClassRoomException('provide shift');
        }

        $this->shift = ShiftEnum::from($shift);
    }

    /**
     * @throws ClassRoomException
     */
    public function setLevel(string $level): void
    {
        if (empty($level)) {
            throw new ClassRoomException('provide level');
        }

        $this->level = $level;
    }

    /**
     * @throws ClassRoomException
     */
    public function setSchoolYearId(string $schoolYearId): void
    {
        if (empty($schoolYearId)) {
            throw new ClassRoomException('provide school_year_id');
        }

        if (!Uuid::isValid($schoolYearId)) {
            throw new ClassRoomException('invalid schoolyear id');
        }

        $this->schoolYearId = Uuid::fromString($schoolYearId);
    }

    /**
     * @throws ClassRoomException
     */
    public function setScheduleId(string $scheduleId): void
    {
        if (empty($scheduleId)) {
            throw new ClassRoomException('provide schedule id');
        }

        if (!Uuid::isValid($scheduleId)) {
            throw new ClassRoomException('invalid schedule id');
        }

        $this->scheduleId = Uuid::fromString($scheduleId);
    }

    /**
     * @throws ClassRoomException
     */
    public function setRoomId(string $roomId): void
    {
        if (empty($roomId)) {
            return;
        }

        if (!Uuid::isValid($roomId)) {
            throw new ClassRoomException('invalid Room id');
        }

        $this->roomId = Uuid::fromString($roomId);
    }

    /**
     * @throws ClassRoomException
     */
    public function setType(string $type): void
    {
        if (empty($type)) {
            throw new ClassRoomException('provide type class');
        }

        $this->type = TypeClassEnum::from($type);
    }

    public function setLocalization(string $localization): void
    {
        if (empty($localization)) {
            return;
        }

        $this->localization = $localization;
    }

    /**
     * @throws ClassRoomException
     */
    public function setId(string $id): void
    {
        if (!Uuid::isValid($id)) {
            throw new ClassRoomException('invalid id provided');
        }

        $this->id = Uuid::fromString($id);
    }

    /**
     * @throws ClassRoomException
     */
    public function setStatus(string $status): void
    {
        if (empty($status)) {
            throw new ClassRoomException('provide status');
        }

        $this->status = ClassRoomStatusEnum::from($status);
    }

    /**
     * @throws ClassRoomException
     */
    private function checkStatus(): void
    {
        if ($this->status === ClassRoomStatusEnum::CLOSED) {
            throw new ClassRoomException('classroom is closed');
        }
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->__toString(),
            'vacancies' => $this->vacancies,
            'shift' => $this->shift->name,
            'open_date' => $this->openDate->format('Y-m-d'),
            'vacancies_occupied' => $this->vacanciesOccupied,
            'status' => $this->status->value,
            'level' => $this->level,
            'identification' => $this->identification,
            'school_year_id' => $this->schoolYearId,
            'schedule_id' => $this->scheduleId,
            'room_id' => $this->roomId,
            'localization' => $this->localization,
            'type' => $this->type->name,
        ];
    }
}
