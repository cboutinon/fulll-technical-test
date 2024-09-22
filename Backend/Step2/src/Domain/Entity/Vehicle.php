<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Exception\VehicleIsAlreadyParkedAtLocation;
use App\Domain\ValueObject\Location;
use App\Domain\ValueObject\VehicleId;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'vehicle')]
class Vehicle
{
    #[ORM\Id]
    #[ORM\Column(type: 'vehicle_id', unique: true)]
    private VehicleId $id;
    #[ORM\Column(type: 'string')]
    private string $type;

    #[ORM\Embedded(columnPrefix: false)]
    private Location|null $location;

    #[ORM\Column(type: 'string')]
    private string $plateNumber;

    #[ManyToOne(targetEntity: Fleet::class, inversedBy: 'vehicles')]
    #[JoinColumn(name: 'fleet_id', referencedColumnName: 'id')]
    private Fleet|null $fleet = null;

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

    public function getFleet(): ?Fleet
    {
        return $this->fleet;
    }

    public function setFleet(?Fleet $fleet): void
    {
        $this->fleet = $fleet;
    }
}
