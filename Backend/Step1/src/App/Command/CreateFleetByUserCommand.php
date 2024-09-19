<?php

declare(strict_types=1);

namespace Fulll\App\Command;

final readonly class CreateFleetByUserCommand
{
    public function __construct(
        public string $user,
    ) {
    }
}
