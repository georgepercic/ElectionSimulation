<?php

declare(strict_types=1);

namespace ElectionSimulation\Domain\Election\Service;

use ElectionSimulation\Domain\Election\Entity\Vote;
use ElectionSimulation\Domain\Election\Entity\Voter;
use ElectionSimulation\Domain\Election\Entity\Candidate;
use ElectionSimulation\Domain\Election\Exception\InvalidVoteTransitionException;

class VoteValidationService
{
    public function validate(Vote $vote, Voter $voter, Candidate $candidate): bool
    {
        try {
            // Validate voting time
            $this->validateVotingTime($vote);

            // Validate voter eligibility
            $this->validateVoterEligibility($voter);

            // Validate ballot marking
            $this->validateBallotMarking($vote);

            // Validate candidate eligibility
            $this->validateCandidateEligibility($candidate);

            // If all validations pass, mark as valid
            $vote->markAsValid();
            return true;
        } catch (InvalidVoteTransitionException $e) {
            // Log transition error
            return false;
        } catch (\Exception $e) {
            // Mark as invalid with specific reason
            $vote->markAsInvalid($e->getMessage());
            return false;
        }
    }

    private function validateVotingTime(Vote $vote): void
    {
        $currentTime = new \DateTimeImmutable();
        $votingStartTime = $currentTime->setTime(7, 0);
        $votingEndTime = $currentTime->setTime(21, 0);

        if ($vote->getTimestamp() < $votingStartTime || $vote->getTimestamp() > $votingEndTime) {
            throw new \InvalidArgumentException('Vote cast outside of voting hours');
        }
    }

    private function validateVoterEligibility(Voter $voter): void
    {
        if (!$voter->hasValidId()) {
            throw new \InvalidArgumentException('Voter does not have a valid ID');
        }

        if ($voter->hasAlreadyVoted()) {
            throw new \InvalidArgumentException('Voter has already voted');
        }
    }

    private function validateBallotMarking(Vote $vote): void
    {
        // Additional ballot validation logic could be added here
    }

    private function validateCandidateEligibility(Candidate $candidate): void
    {
        if (!$candidate->isApprovedByBEC()) {
            throw new \InvalidArgumentException('Candidate not approved by BEC');
        }
    }
}
