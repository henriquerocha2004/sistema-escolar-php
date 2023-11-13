<?php

namespace App\School\Secretary\Exeptions;

use Exception;

class ScheduleException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
