<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\FleetId;

class Fleet
{
    private FleetId $id;
    /**
     * @var Vehicle[]
     */
    private array $vehicles;
    private string $user;

    /**
     * @param Vehicle[] $vehicles
     */
    public function __construct(
        string $user,
        array $vehicles,
    ) {
        $this->id = new FleetId();
        $this->vehicles = $vehicles;
        $this->user = $user;
    }

    /**
     * @param Vehicle[] $vehicles
     */
    public function update(
        array $vehicles,
        string $user,
    ): void {
        $this->user = $user;
        $this->vehicles = $vehicles;
    }

    /**
     * @return Vehicle[]
     */
    public function getVehicles(): array
    {
        return $this->vehicles;
    }

    public function getId(): FleetId
    {
        return $this->id;
    }

    public function hasVehicle(string $plateNumber): bool
    {
        foreach ($this->vehicles as $vehicle) {
            if ($vehicle->getPlateNumber() === $plateNumber) {
                return true;
            }
        }

        return false;
    }

    public function addVehicle(Vehicle $vehicle): void
    {
        $this->vehicles[] = $vehicle;
    }

    public function getUser(): string
    {
        return $this->user;
    }
}
