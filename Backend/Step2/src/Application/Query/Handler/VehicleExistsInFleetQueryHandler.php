<?php

declare(strict_types=1);

namespace App\Application\Query\Handler;

use App\Application\Query\VehicleExistsInFleetQuery;
use App\Domain\Exception\FleetNotFoundException;
use App\Domain\Repository\FleetRepositoryInterface;

final readonly class VehicleExistsInFleetQueryHandler
{
    public function __construct(
        private FleetRepositoryInterface $fleetRepository,
    ) {
    }

    public function handle(VehicleExistsInFleetQuery $vehicleExistInFleetQuery): bool
    {
        $fleet = $this->fleetRepository->findById($vehicleExistInFleetQuery->fleetId);
        if ($fleet === null) {
            throw new FleetNotFoundException($vehicleExistInFleetQuery->fleetId->toString());
        }

        return $fleet->hasVehicle($vehicleExistInFleetQuery->plateNumber);
    }
}
