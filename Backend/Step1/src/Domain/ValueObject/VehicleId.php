<?php

declare(strict_types=1);

namespace Fulll\Domain\ValueObject;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class VehicleId
{
    public UuidInterface $uuid;

    public function __construct()
    {
        $this->uuid = Uuid::uuid7();
    }
}
