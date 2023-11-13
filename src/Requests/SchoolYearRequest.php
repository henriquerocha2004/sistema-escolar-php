<?php

namespace App\Requests;

use App\School\Secretary\Dto\SchoolYearDto;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class SchoolYearRequest extends AbstractJsonResponse
{
    #[NotBlank(message: "Informe o ano letivo"), Type('string')]
    public string $year;

    #[NotBlank(message: "Informe a data de inicio do ano letivo"), Type('string')]
    public string $startAt;

    #[NotBlank(message: "Informe o final do ano letivo"), Type('string')]
    public string $endAt;

    public function getDto(): SchoolYearDto
    {
        return new SchoolYearDto(
            $this->year,
            $this->startAt,
            $this->endAt
        );
    }
}
