<?php

declare(strict_types=1);

namespace ElectionSimulation\Domain\Shared\ValueObject;

use Symfony\Component\Uid\Uuid;

abstract class Id
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function toString(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
