<?php

declare(strict_types=1);

namespace ElectionSimulation\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use ElectionSimulation\Domain\Election\Entity\Voter;
use ElectionSimulation\Domain\Election\ValueObject\VoterId;

class VoterRepository extends EntityRepository
{
    public function findById(VoterId $id): ?Voter
    {
        return $this->findOneBy(['id' => $id->toString()]);
    }

    public function findByIdNumber(string $idNumber): ?Voter
    {
        return $this->findOneBy(['idNumber' => $idNumber]);
    }
}
