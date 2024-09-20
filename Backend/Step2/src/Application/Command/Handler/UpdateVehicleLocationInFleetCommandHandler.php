<?php

declare(strict_types=1);

namespace App\Application\Command\Handler;

use App\Application\Command\UpdateVehicleLocationInFleetCommand;
use App\Domain\Exception\FleetNotFoundException;
use App\Domain\Repository\FleetRepositoryInterface;

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
            throw new FleetNotFoundException($updateVehicleLocationInFleetCommand->fleetId->toString());
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
