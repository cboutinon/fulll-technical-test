<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\Domain\ValueObject\FleetId;
use Fulll\Domain\ValueObject\Location;

final readonly class UpdateVehicleLocationInFleetCommand
{
    public function __construct(
        public FleetId $fleetId,
        public string $plateNumber,
        public Location $location,
    ) {
    }
}
