<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Exception\VehicleIsAlreadyParkedAtLocation;
use App\Domain\ValueObject\Location;
use App\Domain\ValueObject\VehicleId;

class Vehicle
{
    private VehicleId $id;
    private string $type;
    private Location|null $location;
    private string $plateNumber;

    public function __construct(
        string $plateNumber,
        string $type,
    ) {
        $this->id = new VehicleId();
        $this->type = $type;
        $this->plateNumber = $plateNumber;
        $this->location = null;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getLocation(): Location|null
    {
        return $this->location;
    }

    public function setLocation(Location $location): void
    {
        if ($this->location === $location) {
            throw new VehicleIsAlreadyParkedAtLocation($location);
        }

        $this->location = $location;
    }

    public function getId(): VehicleId
    {
        return $this->id;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }
}
