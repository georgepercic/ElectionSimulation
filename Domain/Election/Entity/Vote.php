<?php

declare(strict_types=1);

namespace ElectionSimulation\Domain\Election\Entity;

use ElectionSimulation\Domain\Election\Enum\VoteStatus;
use ElectionSimulation\Domain\Election\Exception\InvalidVoteTransitionException;
use ElectionSimulation\Domain\Election\StateMachine\VoteStateMachine;
use ElectionSimulation\Domain\Election\ValueObject\VoterId;
use ElectionSimulation\Domain\Election\ValueObject\CandidateId;

class Vote
{
    private VoterId $voterId;
    private CandidateId $candidateId;
    private VoteStatus $status;
    private ?\DateTimeImmutable $timestamp;
    private VoteStateMachine $stateMachine;
    
    // Tracking validation reasons
    private ?string $invalidationReason = null;

    public function __construct(
        VoterId $voterId, 
        CandidateId $candidateId,
        ?VoteStateMachine $stateMachine = null
    ) {
        $this->voterId = $voterId;
        $this->candidateId = $candidateId;
        $this->status = VoteStatus::PENDING;
        $this->timestamp = new \DateTimeImmutable();
        $this->stateMachine = $stateMachine ?? new VoteStateMachine();
    }

    public function getVoterId(): VoterId
    {
        return $this->voterId;
    }

    public function getCandidateId(): CandidateId
    {
        return $this->candidateId;
    }

    public function getStatus(): VoteStatus
    {
        return $this->status;
    }

    public function getInvalidationReason(): ?string
    {
        return $this->invalidationReason;
    }

    /**
     * Mark vote as valid
     * @throws InvalidVoteTransitionException
     */
    public function markAsValid(): void
    {
        try {
            $this->status = $this->stateMachine->transitionTo(
                $this->status, 
                VoteStatus::VALID
            );
            $this->invalidationReason = null;
        } catch (InvalidVoteTransitionException $e) {
            throw $e;
        }
    }

    /**
     * Mark vote as invalid
     * @throws InvalidVoteTransitionException
     */
    public function markAsInvalid(string $reason): void
    {
        try {
            $this->status = $this->stateMachine->transitionTo(
                $this->status, 
                VoteStatus::INVALID
            );
            $this->invalidationReason = $reason;
        } catch (InvalidVoteTransitionException $e) {
            throw $e;
        }
    }

    public function getTimestamp(): ?\DateTimeImmutable
    {
        return $this->timestamp;
    }

    /**
     * Check if vote is in a final state
     */
    public function isFinal(): bool
    {
        return $this->status === VoteStatus::VALID || 
               $this->status === VoteStatus::INVALID;
    }
}
