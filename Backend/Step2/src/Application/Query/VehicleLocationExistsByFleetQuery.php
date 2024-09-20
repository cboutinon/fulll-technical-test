<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\ValueObject\FleetId;
use App\Domain\ValueObject\Location;

final readonly class VehicleLocationExistsByFleetQuery
{
    public function __construct(
        public FleetId $fleetId,
        public Location $location,
    ) {
    }
}
