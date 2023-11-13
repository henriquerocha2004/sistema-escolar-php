<?php

namespace App\School\Secretary\Collections;

use App\School\Secretary\Entities\ClassRoom;
use App\School\Secretary\Exeptions\ClassRoomException;
use InvalidArgumentException;

class ClassRoomCollection
{
    /**
     * @var ClassRoom[]
     */
    private array $classRooms = [];
    private int $position = 0;

    private function __construct()
    {
    }

    /**
     * @throws ClassRoomException
     */
    public static function create(array $data): self
    {
        $collection = new self();

        foreach ($data as $item) {
            $room = ClassRoom::create(
                $item['identification'],
                $item['vacancy_quantity'],
                $item['shift'],
                $item['level'],
                $item['school_year_id'],
                $item['schedule_id'],
                $item['type'],
                $item['room_id'],
                $item['localization'],
            );
            $collection->offsetSet(null, $room);
        }

        return $collection;
    }

    /**
     * @throws ClassRoomException
     */
    public static function load(array $data): self
    {
        $collection = new self();

        foreach ($data as $item) {
            $room = ClassRoom::load($item);
            $collection->offsetSet(null, $room);
        }

        return $collection;
    }

    public function count(): int
    {
        return count($this->classRooms);
    }

    public function current(): mixed
    {
        return $this->classRooms[$this->position];
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
        return isset($this->classRooms[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->classRooms[$offset]);
    }

    public function offsetGet(mixed $offset): ClassRoom
    {
        return $this->classRooms[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$value instanceof ClassRoom) {
            throw new InvalidArgumentException("value provided is not classRoom instance");
        }

        if (empty($offset)) {
            $this->classRooms[] = $value;
            return;
        }

        $this->classRooms[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->classRooms[$offset]);
    }

    public function toArray(): array
    {
        $rooms = [];

        foreach ($this->classRooms as $classRoom) {
            $rooms[] = $classRoom->toArray();
        }

        return $rooms;
    }
}