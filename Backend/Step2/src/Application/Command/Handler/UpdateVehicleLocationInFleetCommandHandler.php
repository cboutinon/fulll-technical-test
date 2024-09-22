<?php

declare(strict_types=1);

namespace App\Application\Command\Handler;

use App\Application\Command\UpdateVehicleLocationInFleetCommand;
use App\Domain\Entity\Vehicle;
use App\Domain\Exception\FleetNotFoundException;
use App\Domain\Exception\VehicleIsAlreadyParkedAtLocation;
use App\Domain\Repository\FleetRepositoryInterface;
use App\Domain\ValueObject\Location;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class UpdateVehicleLocationInFleetCommandHandler
{
    public function __construct(
        private FleetRepositoryInterface $fleetRepository,
    ) {
    }

    public function __invoke(UpdateVehicleLocationInFleetCommand $updateVehicleLocationInFleetCommand): void
    {
        $fleet = $this->fleetRepository->findById($updateVehicleLocationInFleetCommand->fleetId);
        if ($fleet === null) {
            throw new FleetNotFoundException($updateVehicleLocationInFleetCommand->fleetId->toString());
        }

        $vehicles = $fleet->getVehicles();
        foreach ($vehicles as $vehicle) {
            /** @var Vehicle $vehicle */
            if ($vehicle->getPlateNumber() === $updateVehicleLocationInFleetCommand->plateNumber) {
                $this->assertVehicleIsNotAlreadyParkedAtLocation($vehicle,$updateVehicleLocationInFleetCommand->location);
                $vehicle->setLocation($updateVehicleLocationInFleetCommand->location);
            }
        }

        $fleet->update(
            $vehicles,
            $fleet->getUserId(),
        );

        $this->fleetRepository->save($fleet);
    }

    private function assertVehicleIsNotAlreadyParkedAtLocation(Vehicle $vehicle, Location $location): void
    {
        if (
            $vehicle->getLocation()?->getLatitude() === $location->getLatitude() &&
            $vehicle->getLocation()?->getLongitude() === $location->getLongitude() &&
            $vehicle->getLocation()?->getAltitude() === $location->getAltitude()
        ) {
            throw new VehicleIsAlreadyParkedAtLocation(
                $location
            );
        }
    }
}
