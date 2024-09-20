<?php

declare(strict_types=1);

namespace App\Application\Command\Handler;

use App\Application\Command\RegisterVehicleInFleetCommand;
use App\Domain\Entity\Vehicle;
use App\Domain\Exception\FleetNotFoundException;
use App\Domain\Exception\VehicleAlreadyExistsException;
use App\Domain\Repository\FleetRepositoryInterface;

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
            throw new FleetNotFoundException($registerVehicleCommand->fleetId->toString());
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
