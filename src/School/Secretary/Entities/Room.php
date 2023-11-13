<?php

namespace App\School\Secretary\Entities;

use App\School\Secretary\Exeptions\RoomException;
use Symfony\Component\Uid\Uuid;

class Room
{
    private Uuid $id;
    private string $code;
    private int $capacity;
    private string $description = '';

    private function __construct()
    {
        $this->id = Uuid::v4();
    }

    public static function create(string $code, int $capacity, string $description = ''): self
    {
        $room = new self();
        $room->setCapacity($capacity);
        $room->setCode($code);
        $room->setDescription($description);

        return $room;
    }

    public function setCode(string $code): void
    {
        if (empty($code)) {
            throw new RoomException("code provided is invalid");
        }

        $this->code = $code;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setCapacity(int $capacity): void
    {
        if ($capacity < 1) {
            throw new RoomException("invalid capacity provided");
        }

        $this->capacity = $capacity;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function setId(string $id): void
    {
        $this->id = Uuid::fromString($id);
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public static function load(array $data): self
    {
        $room = self::create($data['code'], $data['capacity'], $data['description']);
        $room->setId($data['id']);

        return $room;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->__toString(),
            'code' => $this->code,
            'capacity' => $this->capacity,
            'description' => $this->description,
        ];
    }
}
