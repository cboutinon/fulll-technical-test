<?php

declare(strict_types=1);

namespace Fulll\App\Command\Handler;

use Fulll\App\Command\UpdateVehicleLocationInFleetCommand;
use Fulll\Domain\Exception\FleetNotFoundException;
use Fulll\Domain\Repository\FleetRepositoryInterface;

final readonly class UpdateVehicleLocationInFleetCommandHandler
{
    public function __construct(
        private FleetRepositoryInterface $fleetRepository,
    ) {
    }

    public function handle(UpdateVehicleLocationInFleetCommand $updateVehicleLocationInFleetCommand): void
    {
        $fleet = $this->fleetRepository->findById($updateVehicleLocationInFleetCommand->fleetId);
        if ($fleet === null) {
            throw new FleetNotFoundException($updateVehicleLocationInFleetCommand->fleetId->uuid->toString());
        }

        $vehicles = $fleet->getVehicles();
        foreach ($vehicles as $vehicle) {
            if ($vehicle->getPlateNumber() === $updateVehicleLocationInFleetCommand->plateNumber) {
                $vehicle->setLocation($updateVehicleLocationInFleetCommand->location);
            }
        }

        $fleet->update(
            $vehicles,
            $fleet->getUser(),
        );

        $this->fleetRepository->save($fleet);
    }
}
