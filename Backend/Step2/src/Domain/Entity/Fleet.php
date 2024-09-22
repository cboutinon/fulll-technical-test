<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\FleetId;
use App\Domain\ValueObject\UserId;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

#[ORM\Entity]
#[ORM\Table(name: 'fleet')]
class Fleet
{
    #[ORM\Id]
    #[ORM\Column(type: 'fleet_id', unique: true)]
    private FleetId $id;

    /**
     * @var Collection<int, Vehicle> $vehicles
     */
    #[OneToMany(targetEntity: Vehicle::class, mappedBy: 'fleet', cascade: ['persist'])]
    private Collection $vehicles;

    #[ORM\Column(type: 'user_id')]
    private UserId $userId;

    /**
     * @param Collection<int, Vehicle> $vehicles
     */
    public function __construct(
        UserId $userId,
        Collection $vehicles,
    ) {
        $this->id = new FleetId();
        $this->vehicles = $vehicles;
        $this->userId = $userId;
    }


    /**
     * @param Collection<int, Vehicle> $vehicles
     */
    public function update(
        Collection $vehicles,
        UserId $userId,
    ): void {
        $this->userId = $userId;
        $this->vehicles = $vehicles;
    }

    /**
     * @return Collection<int, Vehicle>
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function getId(): FleetId
    {
        return $this->id;
    }

    public function hasVehicle(string $plateNumber): bool
    {
        return $this->vehicles->exists(fn (int $key, mixed $vehicle) => $vehicle instanceof Vehicle && $vehicle->getPlateNumber() === $plateNumber);
    }

    public function addVehicle(Vehicle $vehicle): void
    {
        $this->vehicles->add($vehicle);
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
