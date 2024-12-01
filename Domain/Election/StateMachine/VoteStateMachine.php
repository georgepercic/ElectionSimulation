<?php

declare(strict_types=1);

namespace ElectionSimulation\Domain\Election\StateMachine;

use ElectionSimulation\Domain\Election\Enum\VoteStatus;
use ElectionSimulation\Domain\Election\Exception\InvalidVoteTransitionException;

class VoteStateMachine
{
    /**
     * Allowed state transitions
     */
    private const ALLOWED_TRANSITIONS = [
        VoteStatus::PENDING => [
            VoteStatus::VALID,
            VoteStatus::INVALID
        ],
        VoteStatus::VALID => [
            VoteStatus::INVALID // In case of post-validation issues
        ],
        VoteStatus::INVALID => [] // Terminal state
    ];

    /**
     * Transition the vote between states
     *
     * @throws InvalidVoteTransitionException If transition is not allowed
     */
    public function transitionTo(VoteStatus $currentStatus, VoteStatus $newStatus): VoteStatus
    {
        // Check if transition is allowed
        if (!$this->isTransitionAllowed($currentStatus, $newStatus)) {
            throw new InvalidVoteTransitionException(
                sprintf(
                    "Invalid vote state transition from %s to %s", 
                    $currentStatus->value, 
                    $newStatus->value
                ),
                $currentStatus, 
                $newStatus
            );
        }

        return $newStatus;
    }

    /**
     * Check if a state transition is allowed
     */
    public function isTransitionAllowed(VoteStatus $currentStatus, VoteStatus $newStatus): bool
    {
        // If current status is not in allowed transitions, no transitions are allowed
        if (!isset(self::ALLOWED_TRANSITIONS[$currentStatus->value])) {
            return false;
        }

        // Check if new status is in allowed transitions for current status
        return in_array($newStatus, self::ALLOWED_TRANSITIONS[$currentStatus]);
    }
}
