<?php

declare(strict_types=1);

namespace Fulll\App\Command\Handler;

use Fulll\App\Command\RegisterVehicleInFleetCommand;
use Fulll\Domain\Entity\Vehicle;
use Fulll\Domain\Exception\FleetNotFoundException;
use Fulll\Domain\Exception\VehicleAlreadyExistsException;
use Fulll\Domain\Repository\FleetRepositoryInterface;

final readonly class RegisterVehicleInFleetCommandHandler
{
    public function __construct(
        private FleetRepositoryInterface $fleetRepository,
    ) {
    }

    public function handle(RegisterVehicleInFleetCommand $registerVehicleCommand): void
    {
        $fleet = $this->fleetRepository->findById($registerVehicleCommand->fleetId);
        if ($fleet === null) {
            throw new FleetNotFoundException($registerVehicleCommand->fleetId->uuid->toString());
        }

        if ($fleet->hasVehicle($registerVehicleCommand->plateNumber)) {
            throw new VehicleAlreadyExistsException($registerVehicleCommand->plateNumber);
        }

        $vehicle = new Vehicle(
            $registerVehicleCommand->plateNumber,
            $registerVehicleCommand->vehicleType,
        );

        $fleet->addVehicle($vehicle);
        $this->fleetRepository->save($fleet);
    }
}
