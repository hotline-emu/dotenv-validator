<?php

namespace HotlineEmu\DotenvValidator;

use RuntimeException;

class InvalidEnvironmentException extends RuntimeException
{
    public function __construct(array $invalidKeys)
    {
        $message = "Environment file failed validation\nViolations:\n";
        foreach ($invalidKeys as $key => $reason) {
            $message .= "{$key}: {$reason}\n";
        }

        parent::__construct($message);
    }
}
