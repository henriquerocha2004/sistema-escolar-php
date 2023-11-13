<?php

namespace App\School\Secretary\Collections;

use App\School\Secretary\Entities\ScheduleClass;
use InvalidArgumentException;

class ScheduleCollection
{
    /**
     * @var ScheduleClass[]
     */
    private array $schedules = [];
    private int $position = 0;

    private function __construct()
    {
    }

    public static function create(array $data): self
    {
        $collection = new self();

        foreach ($data as $item) {
            $room = ScheduleClass::create(
                $item['description'],
                $item['initial_time'],
                $item['final_time'],
                $item['school_year_id']
            );
            $collection->offsetSet(null, $room);
        }

        return $collection;
    }

    public static function load(array $data): self
    {
        $collection = new self();

        foreach ($data as $item) {
            $room = ScheduleClass::load($item);
            $collection->offsetSet(null, $room);
        }

        return $collection;
    }

    public function count(): int
    {
        return count($this->schedules);
    }

    public function current(): mixed
    {
        return $this->schedules[$this->position];
    }

    public function next(): void
    {
        $this->position++;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->schedules[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->schedules[$offset]);
    }

    public function offsetGet(mixed $offset): ScheduleClass
    {
        return $this->schedules[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$value instanceof ScheduleClass) {
            throw new InvalidArgumentException("value provided is not scheduleClass instance");
        }

        if (empty($offset)) {
            $this->schedules[] = $value;
            return;
        }

        $this->schedules[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->schedules[$offset]);
    }

    public function toArray(): array
    {
        $schedules = [];

        foreach ($this->schedules as $schedule) {
            $schedules[] = $schedule->toArray();
        }

        return $schedules;
    }
}
