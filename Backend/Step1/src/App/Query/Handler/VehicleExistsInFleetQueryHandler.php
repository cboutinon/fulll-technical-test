<?php

declare(strict_types=1);

namespace Fulll\App\Query\Handler;

use Fulll\App\Query\VehicleExistsInFleetQuery;
use Fulll\Domain\Exception\FleetNotFoundException;
use Fulll\Domain\Repository\FleetRepositoryInterface;

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
            throw new FleetNotFoundException($vehicleExistInFleetQuery->fleetId->uuid->toString());
        }

        return $fleet->hasVehicle($vehicleExistInFleetQuery->plateNumber);
    }
}
