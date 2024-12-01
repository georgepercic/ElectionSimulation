<?php

declare(strict_types=1);

namespace ElectionSimulation\Domain\Election\Enum;

enum VoteStatus: string 
{
    case PENDING = 'pending';
    case VALID = 'valid';
    case INVALID = 'invalid';
}
