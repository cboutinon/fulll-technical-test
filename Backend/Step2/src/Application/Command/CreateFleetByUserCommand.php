<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\ValueObject\UserId;

final readonly class CreateFleetByUserCommand
{
    public function __construct(
        public UserId $userId,
    ) {
    }
}
