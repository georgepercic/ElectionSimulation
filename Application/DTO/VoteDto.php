<?php

declare(strict_types=1);

namespace ElectionSimulation\Application\DTO;

use ElectionSimulation\Domain\Election\ValueObject\VoterId;
use ElectionSimulation\Domain\Election\ValueObject\CandidateId;

class VoteDto
{
    private VoterId $voterId;
    private CandidateId $candidateId;

    public function __construct(VoterId $voterId, CandidateId $candidateId)
    {
        $this->voterId = $voterId;
        $this->candidateId = $candidateId;
    }

    public function getVoterId(): VoterId
    {
        return $this->voterId;
    }

    public function getCandidateId(): CandidateId
    {
        return $this->candidateId;
    }
}
