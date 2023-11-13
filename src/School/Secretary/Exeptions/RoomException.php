<?php

namespace App\School\Secretary\Exeptions;


class RoomException extends SchoolSystemException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
