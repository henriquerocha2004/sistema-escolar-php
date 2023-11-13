<?php

namespace App\Helpers;

use App\School\Secretary\Exeptions\SchoolSystemException;
use Exception;

class MountErrorMessage
{
    public static function getMessage(Exception $exception, string $defaultMessage): string
    {
        return $exception instanceof SchoolSystemException
            ? $exception->getMessage()
            : $defaultMessage;
    }
}
