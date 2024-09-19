<?php

declare(strict_types=1);

namespace Fulll\App\Query;

use Fulll\Domain\ValueObject\FleetId;

final readonly class VehicleExistsInFleetQuery
{
    public function __construct(
        public FleetID $fleetId,
        public string $plateNumber,
    ) {
    }
}
