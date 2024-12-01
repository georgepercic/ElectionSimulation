<?php

declare(strict_types=1);

namespace ElectionSimulation\Domain\Election\Exception;

use DomainException;
use ElectionSimulation\Domain\Election\Enum\VoteStatus;

class InvalidVoteTransitionException extends DomainException
{
    private VoteStatus $fromStatus;
    private VoteStatus $toStatus;

    public function __construct(
        string $message, 
        VoteStatus $fromStatus, 
        VoteStatus $toStatus
    ) {
        parent::__construct($message);
        $this->fromStatus = $fromStatus;
        $this->toStatus = $toStatus;
    }

    public function getFromStatus(): VoteStatus
    {
        return $this->fromStatus;
    }

    public function getToStatus(): VoteStatus
    {
        return $this->toStatus;
    }
}