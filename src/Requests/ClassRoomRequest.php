<?php

namespace App\Requests;

use App\Requests\AbstractJsonResponse;
use App\School\Secretary\Dto\ClassRoomDto;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Uuid;

class ClassRoomRequest extends AbstractJsonResponse
{
    #[NotBlank(message: 'Informe a quantidade de vagas da classe'), Type('int')]
    private int $vacanciesQuantity;
    #[NotBlank(message: 'Informe o turno da classe'), Type('string')]
    private string $shift;
    #[NotBlank(message: 'informe a serie da turma'), Type('string')]
    private string $level;
    #[NotBlank(message: 'Informe a identificação da classe')]
    private string $identification;
    #[NotBlank(message: 'Informe id do ano letivo'), Uuid(message: 'informe um UUID')]
    private string $schoolYearId;
    private string $roomId;
    #[NotBlank(message: 'Informe id do ano letivo'), Uuid(message: 'informe um UUID')]
    private string $scheduleId;
    private string $localization;
    #[NotBlank(message: 'Informe o tipo da turma'), Type('string')]
    private string $type;

    public function getDto(): ClassRoomDto
    {
        $dto = new ClassRoomDto();
        $dto->roomId = $this->roomId;
        $dto->type = $this->type;
        $dto->localization = $this->localization;
        $dto->level = $this->level;
        $dto->shift = $this->shift;
        $dto->scheduleId = $this->scheduleId;
        $dto->schoolYearId = $this->schoolYearId;
        $dto->vacanciesQuantity = $this->vacanciesQuantity;
        $dto->identification = $this->identification;

        return $dto;
    }
}
