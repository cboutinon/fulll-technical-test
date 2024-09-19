<?php

declare(strict_types=1);

namespace Fulll\Infra\InMemory;

use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\Repository\FleetRepositoryInterface;
use Fulll\Domain\ValueObject\FleetId;

final class InMemoryFleetRepository implements FleetRepositoryInterface
{
    /**
     * @var Fleet[]
     */
    private array $fleets = [];

    public function findById(FleetId $fleetId): ?Fleet
    {
        return array_key_exists($fleetId->uuid->toString(), $this->fleets) ? $this->fleets[$fleetId->uuid->toString()] : null;
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
        $this->fleets[$fleet->getId()->uuid->toString()] = $fleet;

        return $fleet->getId();
    }
}
