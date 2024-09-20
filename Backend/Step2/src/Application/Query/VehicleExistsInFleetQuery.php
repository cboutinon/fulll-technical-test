<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\ValueObject\FleetId;

final readonly class VehicleExistsInFleetQuery
{
    public function __construct(
        public FleetID $fleetId,
        public string $plateNumber,
    ) {
    }
}
