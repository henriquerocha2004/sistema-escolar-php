<?php

namespace App\School\Secretary\ValueObjects;

use App\School\Secretary\Exeptions\PeriodException;
use DateTimeImmutable;

class Period
{
    private const DATE_VALID_FORMAT = '/(\d{4})[-.\/](\d{2})[-.\/](\d{2})/';
    private const TIME_VALID_FORMAT = '/(?:[01]\d|2[0-3]):(?:[0-5]\d)/';
    private const DATETIME_VALID_FORMAT = '/^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01]) (00|[0-9]|1[0-9]|2[0-3]):([0-9]|[0-5][0-9]):([0-9]|[0-5][0-9])$/';

    private DateTimeImmutable $start;
    private DateTimeImmutable $end;

    public function setStart(string $start): void
    {
        $this->validate($start);
        $this->start = new DateTimeImmutable($start);
    }

    public function getStart(bool $formatted, string $format = 'Y-m-d'): DateTimeImmutable|string
    {
        if (!$formatted) {
            return $this->start;
        }

        return $this->start->format($format);
    }

    public function setEnd(string $end): void
    {
        $this->validate($end);
        $this->end = new DateTimeImmutable($end);
    }

    public function getEnd(bool $formatted, string $format = 'Y-m-d'): DateTimeImmutable|string
    {
        if (!$formatted) {
            return $this->end;
        }

        return $this->end->format($format);
    }

    public function checkPeriod(): void
    {
        if ($this->end < $this->start) {
            throw new PeriodException('invalid period provided. EndAt cannot be before that StartedAt');
        }
    }

    private function validate(string $date): void
    {
        if (
            preg_match(self::DATE_VALID_FORMAT, $date)
            || preg_match(self::TIME_VALID_FORMAT, $date)
            || preg_match(self::DATETIME_VALID_FORMAT, $date)
        ) {
            return;
        }

        throw new PeriodException('invalid format date');
    }
}
