<?php

declare(strict_types=1);

namespace features\bootstrap;

use Behat\Behat\Context\Context;
use Fulll\App\Command\CreateFleetByUserCommand;
use Fulll\App\Command\Handler\CreateFleetByUserCommandHandler;
use Fulll\App\Command\Handler\RegisterVehicleInFleetCommandHandler;
use Fulll\App\Command\Handler\UpdateVehicleLocationInFleetCommandHandler;
use Fulll\App\Command\RegisterVehicleInFleetCommand;
use Fulll\App\Command\UpdateVehicleLocationInFleetCommand;
use Fulll\App\Query\Handler\VehicleExistsInFleetQueryHandler;
use Fulll\App\Query\Handler\VehicleLocationExistsByFleetQueryHandler;
use Fulll\App\Query\VehicleExistsInFleetQuery;
use Fulll\App\Query\VehicleLocationExistsByFleetQuery;
use Fulll\Domain\Exception\VehicleAlreadyExistsException;
use Fulll\Domain\Exception\VehicleIsAlreadyParkedAtLocation;
use Fulll\Domain\ValueObject\FleetId;
use Fulll\Domain\ValueObject\Location;
use Fulll\Infra\InMemory\InMemoryFleetRepository;
use RuntimeException;

final class FleetContext implements Context
{
    private FleetId $fleetId;
    private FleetId $fleet2Id;
    private string $vehicleType;
    private string $plateNumber;
    private VehicleAlreadyExistsException|null $vehicleAlreadyExistsExceptionExpected = null;
    private VehicleIsAlreadyParkedAtLocation|null $vehicleIsAlreadyParkedAtLocation = null;
    private Location $location;
    protected InMemoryFleetRepository $fleetRepository;


    public function __construct() {
        $this->fleetRepository = new InMemoryFleetRepository();
    }

    /**
     * @Given my fleet
     */
    public function prepareMyFleet(): void
    {
        $createFleetByUserHandler = new CreateFleetByUserCommandHandler($this->fleetRepository);
        $this->fleetId = $createFleetByUserHandler->handle(
            new CreateFleetByUserCommand(
                user: 'user1',
            )
        );
    }

    /**
     * @Given a vehicle
     */
    public function prepareAVehicle(): void
    {
        $this->vehicleType = 'car';
        $this->plateNumber = 'EF-112-PG';
    }

    /**
     * @Given I have registered this vehicle into my fleet
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet(): void
    {
        $registerVehicleHandler = new RegisterVehicleInFleetCommandHandler($this->fleetRepository);
        $registerVehicleHandler->handle(
            new RegisterVehicleInFleetCommand(
                fleetId: $this->fleetId,
                plateNumber: $this->plateNumber,
                vehicleType: $this->vehicleType,
            )
        );
    }



    /**
     * @When I register this vehicle into my fleet
     */
    public function iRegisterVehicleIntoMyFleet(): void
    {
        $registerVehicleHandler = new RegisterVehicleInFleetCommandHandler($this->fleetRepository);
        $registerVehicleHandler->handle(
            new RegisterVehicleInFleetCommand(
                fleetId: $this->fleetId,
                plateNumber: $this->plateNumber,
                vehicleType: $this->vehicleType,
            )
        );
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function thisVehicleShouldBePartOfMyFleet(): void
    {
        $vehicleExistInFleet = new VehicleExistsInFleetQueryHandler($this->fleetRepository);
        $isVehicleExistInFleet = $vehicleExistInFleet->handle(
            new VehicleExistsInFleetQuery(
                $this->fleetId,
                $this->plateNumber,
            )
        );

        if ($isVehicleExistInFleet === false) {
            throw new RuntimeException('This vehicle is not be part of my vehicle fleet.');
        }
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function iTryToRegisterThisVehicleIntoMyFleet(): void
    {
        $registerVehicleHandler = new RegisterVehicleInFleetCommandHandler($this->fleetRepository);

        try {
            $registerVehicleHandler->handle(
                new RegisterVehicleInFleetCommand(
                    $this->fleetId,
                    $this->plateNumber,
                    $this->vehicleType,
                )
            );
        } catch (VehicleAlreadyExistsException $e) {
            $this->vehicleAlreadyExistsExceptionExpected = $e;
        }

    }

    /**
     * @Then I should be informed this vehicle has already been registered into my fleet
     */
    public function iShouldBeInformedVehicleAlreadyRegisteredIntoMyFleet(): void
    {
        if ($this->vehicleAlreadyExistsExceptionExpected === null) {
            throw new RuntimeException('You should not registered a vehicle already exists into fleet');
        }
    }

    /**
     * @Given the fleet of another user
     */
    public function prepareFleetOfAnotherUser(): void
    {
        $createFleetByUserHandler = new CreateFleetByUserCommandHandler($this->fleetRepository);
        $this->fleet2Id = $createFleetByUserHandler->handle(
            new CreateFleetByUserCommand(
                user: 'user2',
            )
        );
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function VehicleHasBeenRegisteredIntoOtherUserFleet(): void
    {
        $registerVehicleHandler = new RegisterVehicleInFleetCommandHandler($this->fleetRepository);
        $registerVehicleHandler->handle(
            new RegisterVehicleInFleetCommand(
                $this->fleet2Id,
                $this->plateNumber,
                $this->vehicleType,
            )
        );
    }

    /**
     * @Given a location
     */
    public function prepareALocation(): void
    {
        $this->location = new Location(
            48.8566,
            2.3522
        );
    }

    /**
     * @When I park my vehicle at this location
     */
    public function iParkVehicleAtLocation(): void
    {
        $updateVehicleLocationHandler = new UpdateVehicleLocationInFleetCommandHandler($this->fleetRepository);
        $updateVehicleLocationHandler->handle(
            new UpdateVehicleLocationInFleetCommand(
                $this->fleetId,
                $this->plateNumber,
                $this->location,
            )
        );
    }

    /**
     * @Then the known location of my vehicle should verify this location
     */
    public function iKnownLocationOfMyVehicle(): void
    {
        $vehicleLocationHandler = new VehicleLocationExistsByFleetQueryHandler($this->fleetRepository);
        $vehicleLocationHandler->handle(
            new VehicleLocationExistsByFleetQuery(
                $this->fleetId,
                $this->location,
            )
        );
    }

    /**
     * @Given my vehicle has been parked into this location
     */
    public function vehicleHasBeenParkedIntoLocation(): void
    {
        $updateVehicleLocationHandler = new UpdateVehicleLocationInFleetCommandHandler($this->fleetRepository);
        $updateVehicleLocationHandler->handle(
            new UpdateVehicleLocationInFleetCommand(
                $this->fleetId,
                $this->plateNumber,
                $this->location,
            )
        );
    }

    /**
     * @When I try to park my vehicle at this location
     */
    public function iTryToParkVehicleAtThisLocation(): void
    {
        $updateVehicleLocationHandler = new UpdateVehicleLocationInFleetCommandHandler($this->fleetRepository);

        try {
            $updateVehicleLocationHandler->handle(
                new UpdateVehicleLocationInFleetCommand(
                    $this->fleetId,
                    $this->plateNumber,
                    $this->location,
                )
            );
        } catch (VehicleIsAlreadyParkedAtLocation $e) {
            $this->vehicleIsAlreadyParkedAtLocation = $e;
        }
    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtLocation(): void
    {
        if ($this->vehicleIsAlreadyParkedAtLocation === null) {
            throw new RuntimeException('You should not park vehicle at same location');
        }
    }
}
