<?php

declare(strict_types=1);

namespace ElectionSystem\Domain\Election\Exception;

use Throwable;

class InvalidVoteException extends \DomainException
{
    public function __construct(
        string $message = "Invalid vote", 
        int $code = 0, 
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
