<?php

namespace App\School\Secretary\Collections;

use App\School\Secretary\Entities\SchoolYear;
use ArrayAccess;
use Countable;
use InvalidArgumentException;
use Iterator;

class SchoolYearCollection implements Countable, Iterator, ArrayAccess
{
    /**
     * @var SchoolYear[]
     */
    private array $schoolYears = [];
    private int $position = 0;

    private function __construct()
    {
    }

    public static function create(array $data): self
    {
        $collection = new self();

        foreach ($data as $item) {
            $schoolYear = SchoolYear::create(
                $item['year'],
                $item['start_at'],
                $item['end_at'],
            );
            $collection->offsetSet(null, $schoolYear);
        }

        return $collection;
    }

    public static function load(array $data): self
    {
        $collection = new self();

        foreach ($data as $item) {
            $room = SchoolYear::load($item);
            $collection->offsetSet(null, $room);
        }

        return $collection;
    }

    public function count(): int
    {
        return count($this->schoolYears);
    }

    public function current(): mixed
    {
        return $this->schoolYears[$this->position];
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
        return isset($this->schoolYears[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->schoolYears[$offset]);
    }

    public function offsetGet(mixed $offset): SchoolYear
    {
        return $this->schoolYears[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$value instanceof SchoolYear) {
            throw new InvalidArgumentException("value provided is not scheduleClass instance");
        }

        if (empty($offset)) {
            $this->schoolYears[] = $value;
            return;
        }

        $this->schoolYears[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->schoolYears[$offset]);
    }

    public function toArray(): array
    {
        $schoolYears = [];

        foreach ($this->schoolYears as $schoolYear) {
            $schoolYears[] = $schoolYear->toArray();
        }

        return $schoolYears;
    }
}
