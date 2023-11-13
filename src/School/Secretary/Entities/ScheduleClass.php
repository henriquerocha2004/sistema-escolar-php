<?php

namespace App\School\Secretary\Entities;

use App\School\Secretary\ValueObjects\Period;
use Symfony\Component\Uid\Uuid;

class ScheduleClass
{
    private Uuid $id;
    private string $description;
    private Period $period;
    private Uuid $schoolYearId;

    private function __construct(string $description)
    {
        $this->id = Uuid::v4();
        $this->description = $description;
        $this->period = new Period();
    }

    public static function create(
        string $description,
        string $initialTime,
        string $finalTime,
        string $schoolYearId
    ): self {
        $schedule = new self($description);
        $schedule->setPeriod($initialTime, $finalTime);
        $schedule->setShcoolYear($schoolYearId);

        return $schedule;
    }

    public function getSchedule(): string
    {
        return sprintf(
            "%s-%s",
            $this->period->getStart(true, 'H:i'),
            $this->period->getEnd(true, 'H:i')
        );
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setPeriod(string $initialTime, string $finaTime): void
    {
        $this->period->setStart($initialTime);
        $this->period->setEnd($finaTime);
        $this->period->checkPeriod();
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setId(string $id): void
    {
        $this->id = Uuid::fromString($id);
    }

    public function setShcoolYear(string $schoolYearId): void
    {
        $this->schoolYearId = Uuid::fromString($schoolYearId);
    }

    public function getSchoolYearId(): Uuid
    {
        return $this->schoolYearId;
    }

    public static function load(array $data): self
    {
        list($initialTime, $finalTime) = self::extractPeriod($data['schedule']);

        $schedule = self::create(
            $data['description'],
            $initialTime,
            $finalTime,
            $data['school_year_id']
        );
        $schedule->setId($data['id']);

        return $schedule;
    }

    private static function extractPeriod(string $schedule): array
    {
        return explode("-", $schedule);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->__toString(),
            'description' => $this->description,
            'schedule' => $this->getSchedule(),
            'school_year_id' => $this->schoolYearId,
        ];
    }
}
