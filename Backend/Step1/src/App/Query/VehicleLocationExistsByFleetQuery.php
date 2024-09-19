<?php

declare(strict_types=1);

namespace Fulll\App\Query;

use Fulll\Domain\ValueObject\FleetId;
use Fulll\Domain\ValueObject\Location;

final readonly class VehicleLocationExistsByFleetQuery
{
    public function __construct(
        public FleetId $fleetId,
        public Location $location,
    ) {
    }
}
