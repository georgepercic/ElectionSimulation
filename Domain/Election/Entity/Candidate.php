<?php

declare(strict_types=1);

namespace ElectionSimulation\Domain\Election\Entity;

use ElectionSimulation\Domain\Election\ValueObject\CandidateId;
use ElectionSimulation\Infrastructure\ExternalService\CentralElectionBureau;

class Candidate
{
    private CandidateId $id;
    private string $name;
    private string $party;
    private bool $becApproved;
    private CentralElectionBureau $centralElectionBureau;

    public function __construct(
        CandidateId $id, 
        string $name, 
        string $party, 
        CentralElectionBureau $centralElectionBureau
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->party = $party;
        $this->centralElectionBureau = $centralElectionBureau;
        $this->becApproved = $this->checkBECApproval();
    }

    public function getId(): CandidateId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParty(): string
    {
        return $this->party;
    }

    public function isApprovedByBEC(): bool
    {
        return $this->becApproved;
    }

    private function checkBECApproval(): bool
    {
        return $this->centralElectionBureau->verifyCandidateApproval($this->id->toString());
    }
}
