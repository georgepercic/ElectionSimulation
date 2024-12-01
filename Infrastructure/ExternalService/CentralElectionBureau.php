<?php

namespace ElectionSimulation\Infrastructure\ExternalService;

use ElectionSimulation\Domain\Election\Entity\Vote;

class CentralElectionBureau 
{
    public function submitVote(Vote $vote): void 
    {
        //
    }

    public function verifyCandidateApproval(): bool 
    {
        return true;
    }
}
