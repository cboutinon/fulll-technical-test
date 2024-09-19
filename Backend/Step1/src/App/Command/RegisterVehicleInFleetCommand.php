<?php

declare(strict_types=1);

namespace Fulll\App\Command;

use Fulll\Domain\ValueObject\FleetId;

final readonly class RegisterVehicleInFleetCommand
{
    public function __construct(
        public FleetId $fleetId,
        public string $plateNumber,
        public string $vehicleType,
    ) {
    }
}
