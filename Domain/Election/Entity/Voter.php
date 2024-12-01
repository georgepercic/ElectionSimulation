<?php

declare(strict_types=1);

namespace ElectionSimulation\Domain\Election\Entity;

use ElectionSimulation\Domain\Election\ValueObject\VoterId;

class Voter
{
    private VoterId $id;
    private string $name;
    private string $idNumber;
    private ?\DateTimeImmutable $lastVotedAt;
    private bool $hasValidId;

    public function __construct(
        VoterId $id, 
        string $name, 
        string $idNumber, 
        bool $hasValidId = true
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->idNumber = $idNumber;
        $this->lastVotedAt = null;
        $this->hasValidId = $hasValidId;
    }

    public function getId(): VoterId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIdNumber(): string
    {
        return $this->idNumber;
    }

    public function hasValidId(): bool
    {
        return $this->hasValidId;
    }

    public function recordVote(): void
    {
        $this->lastVotedAt = new \DateTimeImmutable();
    }

    public function getLastVotedAt(): ?\DateTimeImmutable
    {
        return $this->lastVotedAt;
    }

    public function hasAlreadyVoted(): bool
    {
        return $this->lastVotedAt !== null;
    }
}