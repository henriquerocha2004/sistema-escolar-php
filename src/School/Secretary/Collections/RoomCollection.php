<?php

namespace App\School\Secretary\Collections;

use App\School\Secretary\Entities\Room;
use ArrayAccess;
use Countable;
use InvalidArgumentException;
use Iterator;

class RoomCollection implements Countable, Iterator, ArrayAccess
{
    /**
     * @var Room[]
     */
    private array $rooms = [];
    private int $position = 0;

    private function __construct()
    {
    }

    public static function create(array $data): self
    {
        $collection = new self();

        foreach ($data as $item) {
            $room = Room::create($item['code'], $item['capacity'], $item['description']);
            $collection->offsetSet(null, $room);
        }

        return $collection;
    }

    public static function load(array $data): self
    {
        $collection = new self();

        foreach ($data as $item) {
            $room = Room::load($item);
            $collection->offsetSet(null, $room);
        }

        return $collection;
    }

    public function count(): int
    {
        return count($this->rooms);
    }

    public function current(): mixed
    {
        return $this->rooms[$this->position];
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
        return isset($this->rooms[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->rooms[$offset]);
    }

    public function offsetGet(mixed $offset): Room
    {
        return $this->rooms[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$value instanceof Room) {
            throw new InvalidArgumentException("value provided is not room instance");
        }

        if (empty($offset)) {
            $this->rooms[] = $value;
            return;
        }

        $this->rooms[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->rooms[$offset]);
    }

    public function toArray(): array
    {
        $rooms = [];

        foreach ($this->rooms as $room) {
            $rooms[] = $room->toArray();
        }

        return $rooms;
    }
}
