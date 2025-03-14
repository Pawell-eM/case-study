<?php

namespace App\Machine\Exception;

use Exception;

class MachineLogicException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct(sprintf('Error: %s', $message));
    }
}