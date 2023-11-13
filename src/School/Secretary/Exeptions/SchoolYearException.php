<?php

namespace App\School\Secretary\Exeptions;

class SchoolYearException extends SchoolSystemException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
