<?php

declare(strict_types=1);

namespace App\Application\Query\Handler;

use App\Application\Query\VehicleLocationExistsByFleetQuery;
use App\Domain\Entity\Vehicle;
use App\Domain\Exception\FleetNotFoundException;
use App\Domain\Repository\FleetRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class VehicleLocationExistsByFleetQueryHandler
{
    public function __construct(
        private FleetRepositoryInterface $fleetRepository,
    ) {
    }

    public function __invoke(VehicleLocationExistsByFleetQuery $vehicleLocationExistsByFleetQuery): Vehicle|null
    {
        $fleet = $this->fleetRepository->findById($vehicleLocationExistsByFleetQuery->fleetId);
        if ($fleet === null) {
            throw new FleetNotFoundException($vehicleLocationExistsByFleetQuery->fleetId->toString());
        }

        foreach ($fleet->getVehicles() as $vehicle) {
            /** @var Vehicle $vehicle */
            if (
                $vehicle->getLocation()?->getLatitude() === $vehicleLocationExistsByFleetQuery->location->getLatitude() &&
                $vehicle->getLocation()?->getLongitude() === $vehicleLocationExistsByFleetQuery->location->getLongitude() &&
                $vehicle->getLocation()?->getAltitude() === $vehicleLocationExistsByFleetQuery->location->getAltitude()
            ) {
                return $vehicle;
            }
        }

        return null;
    }
}
