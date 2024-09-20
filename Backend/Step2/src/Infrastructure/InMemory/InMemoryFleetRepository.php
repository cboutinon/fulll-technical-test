<?php

declare(strict_types=1);

namespace App\Infrastructure\InMemory;

use App\Domain\Entity\Fleet;
use App\Domain\Repository\FleetRepositoryInterface;
use App\Domain\ValueObject\FleetId;

final class InMemoryFleetRepository implements FleetRepositoryInterface
{
    /**
     * @var Fleet[]
     */
    private array $fleets = [];

    public function findById(FleetId $fleetId): ?Fleet
    {
        return array_key_exists($fleetId->toString(), $this->fleets) ? $this->fleets[$fleetId->toString()] : null;
    }

    /**
     * @return Fleet[]
     */
    public function findByUser(string $user): array
    {
        $fleets = [];
        foreach ($this->fleets as $fleet) {
            if ($fleet->getUser() === $user) {
                $fleets[] = $fleet;
            }
        }

        return $fleets;
    }

    public function save(Fleet $fleet): FleetId
    {
        $this->fleets[$fleet->getId()->toString()] = $fleet;

        return $fleet->getId();
    }
}
