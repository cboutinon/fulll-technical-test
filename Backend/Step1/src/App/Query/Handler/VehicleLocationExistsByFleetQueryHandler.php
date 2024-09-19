<?php

declare(strict_types=1);

namespace Fulll\App\Query\Handler;

use Fulll\App\Query\VehicleLocationExistsByFleetQuery;
use Fulll\Domain\Entity\Vehicle;
use Fulll\Domain\Exception\FleetNotFoundException;
use Fulll\Domain\Repository\FleetRepositoryInterface;

final readonly class VehicleLocationExistsByFleetQueryHandler
{
    public function __construct(
        private FleetRepositoryInterface $fleetRepository,
    ) {
    }

    public function handle(VehicleLocationExistsByFleetQuery $vehicleLocationExistsByFleetQuery): Vehicle|null
    {
        $fleet = $this->fleetRepository->findById($vehicleLocationExistsByFleetQuery->fleetId);
        if ($fleet === null) {
            throw new FleetNotFoundException($vehicleLocationExistsByFleetQuery->fleetId->uuid->toString());
        }

        foreach ($fleet->getVehicles() as $vehicle) {
            if ($vehicle->getLocation() === $vehicleLocationExistsByFleetQuery->location) {
                return $vehicle;
            }
        }

        return null;
    }
}
