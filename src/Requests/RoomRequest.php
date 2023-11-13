<?php

namespace App\Requests;

use App\School\Secretary\Dto\RoomDto;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class RoomRequest extends AbstractJsonResponse
{
    #[NotBlank(message: "Informe o código da sala"), Type('string')]
    public string $code;
    #[Type('string')]
    public string $description;
    #[NotBlank(message: "Informe a capacidade da sala"), Type('int')]
    public int $capacity;

    public function getDto(): RoomDto
    {
        return new RoomDto(
            capacity: $this->capacity,
            code: $this->code,
            description: $this->description
        );
    }
}
