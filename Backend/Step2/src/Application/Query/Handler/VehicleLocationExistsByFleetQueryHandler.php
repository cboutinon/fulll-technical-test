<?php

declare(strict_types=1);

namespace App\Application\Query\Handler;

use App\Application\Query\VehicleLocationExistsByFleetQuery;
use App\Domain\Entity\Vehicle;
use App\Domain\Exception\FleetNotFoundException;
use App\Domain\Repository\FleetRepositoryInterface;

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
            throw new FleetNotFoundException($vehicleLocationExistsByFleetQuery->fleetId->toString());
        }

        foreach ($fleet->getVehicles() as $vehicle) {
            if ($vehicle->getLocation() === $vehicleLocationExistsByFleetQuery->location) {
                return $vehicle;
            }
        }

        return null;
    }
}
