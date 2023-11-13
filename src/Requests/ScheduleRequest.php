<?php

namespace App\Requests;

use App\School\Secretary\Dto\ScheduleDto;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class ScheduleRequest extends AbstractJsonResponse
{
    #[NotBlank(message: "Informe o horário inicial"), Type('string')]
    public string $startTime;
    #[NotBlank(message: "Informe o horário final"), Type('string')]
    public string $endTime;
    #[NotBlank(message: "Informe o id do ano letivo"), Type('string')]
    public string $schoolYearId;
    public string $description;

    public function getDto(): ScheduleDto
    {
        $scheduleDto = new ScheduleDto();
        $scheduleDto->description = $this->description;
        $scheduleDto->startTime = $this->startTime;
        $scheduleDto->endTime = $this->endTime;
        $scheduleDto->schoolYearId = $this->schoolYearId;

        return $scheduleDto;
    }
}
