<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\ValueObject\FleetId;
use App\Domain\ValueObject\Location;

final readonly class UpdateVehicleLocationInFleetCommand
{
    public function __construct(
        public FleetId $fleetId,
        public string $plateNumber,
        public Location $location,
    ) {
    }
}
