<?php

declare(strict_types=1);

namespace ElectionSimulation\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use ElectionSimulation\Domain\Election\Entity\Candidate;
use ElectionSimulation\Domain\Election\ValueObject\CandidateId;

class CandidateRepository extends EntityRepository
{
    public function findById(CandidateId $id): ?Candidate
    {
        return $this->findOneBy(['id' => $id->toString()]);
    }
}