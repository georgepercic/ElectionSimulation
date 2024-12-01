<?php

declare(strict_types=1);

namespace ElectionSimulation\Application\Service;

use ElectionSimulation\Application\DTO\VoteDto;
use ElectionSimulation\Domain\Election\Enum\VoteStatus;
use ElectionSimulation\Domain\Election\Entity\Vote;
use ElectionSimulation\Domain\Election\Entity\Voter;
use ElectionSimulation\Domain\Election\Entity\Candidate;
use ElectionSimulation\Domain\Election\Service\VoteValidationService;
use ElectionSimulation\Infrastructure\MessageQueue\RabbitMQ\VotePublisher;
use ElectionSimulation\Infrastructure\ExternalService\CentralElectionBureau;
use ElectionSimulation\Domain\Election\Exception\InvalidVoteException;

class VotingApplicationService
{
    private VoteValidationService $voteValidationService;
    private VotePublisher $votePublisher;
    private CentralElectionBureau $centralElectionBureau;

    public function __construct(
        VoteValidationService $voteValidationService,
        VotePublisher $votePublisher,
        CentralElectionBureau $centralElectionBureau
    ) {
        $this->voteValidationService = $voteValidationService;
        $this->votePublisher = $votePublisher;
        $this->centralElectionBureau = $centralElectionBureau;
    }

    public function castVote(
        VoteDto $dto, 
        Voter $voter, 
        Candidate $candidate
    ): bool {
        // Check if voter has already voted
        if ($voter->hasAlreadyVoted()) {
            throw new InvalidVoteException('Voter has already voted', VoteStatus::INVALID);
        }

        // Create vote
        $vote = new Vote($dto->getVoterId(), $dto->getCandidateId());

        try {
            // Validate vote
            $isValid = $this->voteValidationService->validate($vote, $voter, $candidate);

            // Publish vote to queue
            $published = $this->votePublisher->publish($vote);

            return true;
        } catch (InvalidVoteException $e) {
            // Log the invalid vote
            return false;
        }
    }
}
