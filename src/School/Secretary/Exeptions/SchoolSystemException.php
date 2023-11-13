<?php

namespace App\School\Secretary\Exeptions;

use Exception;

class SchoolSystemException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
