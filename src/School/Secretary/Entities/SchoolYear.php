<?php

namespace App\School\Secretary\Entities;

use App\School\Secretary\Exeptions\SchoolYearException;
use App\School\Secretary\ValueObjects\Period;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class SchoolYear
{
    private Uuid $id;

    private function __construct(
        private string $year,
        private Period $period
    ) {
        $this->id = Uuid::v4();
    }

    public static function create(string $year, string $startedAt, string $endAt): self
    {
        self::validate($year, $startedAt, $endAt);
        $period = new Period();
        $period->setStart($startedAt);
        $period->setEnd($endAt);

        return new self($year, $period);
    }

    public function getYear(): string
    {
        return $this->year;
    }

    public function getStatedAt(): DateTimeImmutable
    {
        return $this->period->getStart(false);
    }

    public function getEndAt(): DateTimeImmutable
    {
        return $this->period->getEnd(false);
    }

    public function setId(string $id): void
    {
        $this->id = Uuid::fromString($id);
    }

    public function setYear(string $year): void
    {
        $this->year = $year;
    }

    private static function validate(string $year, string $startedAt, string $endAt): void
    {
        if (empty($year)) {
            throw new SchoolYearException('year not provided');
        }

        if (empty($startedAt)) {
            throw new SchoolYearException('startAt not provided');
        }

        if (empty($endAt)) {
            throw new SchoolYearException('endAt not provided');
        }
    }

    public function checkPeriod(): void
    {
        $this->period->checkPeriod();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public static function load(array $data): self
    {
        $schoolYear = self::Create($data['year'], $data['start_at'], $data['end_at']);
        $schoolYear->setId($data['id']);

        return $schoolYear;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->__toString(),
            'year' => $this->year,
            'start_at' => $this->period->getStart(true),
            'end_at' => $this->period->getEnd(true),
        ];
    }
}
